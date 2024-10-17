<?php

namespace App\Http\Controllers;

use App\Jobs\UploadVideoToCloudinary;
use App\Models\Category;
use App\Models\Course;
use App\Models\Module;
use App\Models\Coupon;
use App\Models\Submodule;
use App\Models\Video;
use App\Models\VideoUploadLogs;
use App\Models\CourseApproval;
use App\Models\Quiz;

use App\Models\Rating;
use App\Models\ReappliedApprovals;
use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;

class CourseController extends Controller
{
    public function index()
    {
        if (session()->get('user_role') == 'Learner') {
            $courses = Auth::user()->courses;
            return view('course.enrolled-courses', ['courses' => $courses]);
        }
        if (session()->get('user_role') == 'Instructor') {
            $courses = Auth::user()->createdCourses;
            return view('course.mycourses', ['courses' => $courses]);
        }

        return view('course.mycourses', ['courses' => Course::all()]);
    }

    public function exploreCourses()
    {
        return view('course.index');
    }

    public function create()
    {
        $quizzes = Quiz::where('user_id', Auth::id())->where('course_id', null)->get();
        return view('course.create', ['categories' => Category::all(), 'languages' => DB::table('languages')->get(), 'quizzes' => $quizzes]);
    }

    public function store()
    {
        // dd(request());
        request()->validate([
            'title' => 'required|max:255|unique:courses,name',
            'description' => ['required', 'string'],
            'about' => ['required', 'string'],
            'language' => 'string|nullable',
            'cr_price' => 'required|integer',
            'es_price' => 'required|integer',
            'category' => 'required',
            'thumbnail_url' => 'required|image',
            'intro_url' => 'mimes:mp4',
            'M.*.title' => 'required|max:255',
            'M.*.S.*.title' => 'required|max:255',
            'M.*.S.*.file' => 'mimes:mp4',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'listing_date' => 'nullable|date',
        ]);
        // dd(request());

        $category = Category::find(request('category'));
        $categoryPrice = $category->categoryPrice;
        if ($categoryPrice) {
            if (request('cr_price') < $categoryPrice->min_price) {
                throw ValidationException::withMessages(['min_price' => 'Its Less then min Category Price limit']);
            }
            if (request('cr_price') > $categoryPrice->max_price) {
                throw ValidationException::withMessages(['max_price' => 'Current Price is Greater than Categories max Price Threshold']);
            }
        }


        $course = new Course();
        $course->name = request('title');
        $course->category_id = request('category');
        $course->user_id = Auth::user()->id;
        $course->price = request('cr_price');
        $course->est_price = request('es_price');
        $course->language = request('language') ?? null;
        $course->description = request('description');
        $course->about = request('about');
        if (request('isfree')) {
            $course->is_free = request('isfree') === 'true' ? 1 : 0;
        }
        $course->difficulty = Str::lower(request('difficulty')) ?? null;
        $course->max_students = request('max_students') ?? null;
        $course->start_date = Carbon::parse(request('start_date'));
        $course->end_date = Carbon::parse(request('end_date'));
        $course->listing_date = Carbon::parse(request('listing_date')) ?? null;
        // Uploading course thumbnail
        $image = request()->file('thumbnail_url')->getRealPath();
        $image_upload_response = Cloudinary::upload($image, [
            'folder' => 'LMS/Categories/' . Category::find(request('category'))->name . '/' . $course->id . '/thumbnail/',
        ])->getSecurePath();

        $course->thumbnail_url = $image_upload_response;
        $course->save();
        if (request('quiz_id')) {
            $quiz = Quiz::find(request('quiz_id'));
            $quiz->course_id = $course->id;
            $quiz->save();
        }
        if (session()->get('user_role') == 'Admin') {
            $course->approvalRequest()->updateOrCreate(
                ['course_id' => $course->id],
                ['status' => 'approved']
            );
        }
        else {
            $corseApproval = new CourseApproval();
            $corseApproval->course_id = $course->id;
            $corseApproval->save();
        }



        if (request()->file('intro_url')) {
            $file = request()->file('intro_url'); // Retrieve the uploaded file from the request
            $filename = $file->getClientOriginalName();
            $path = 'C' . $course->id . '/' . 'Intro/' . $filename;
            Storage::disk('local')->put($path, file_get_contents($file));

            // Get full path to the stored file
            $filepath = storage_path('app/' . $path);
            $cloudinaryPath = 'LMS/Categories/' . Category::find(request('category'))->name . '/' . $course->id . '/intro/';

            $videouploadlog = new VideoUploadLogs();
            $videouploadlog->course_id = $course->id;
            $videouploadlog->save();

            UploadVideoToCloudinary::dispatch($filepath, $cloudinaryPath, $course->id, $videouploadlog->id, true);
        }

        // Save course



        // Check if 'M' (Modules) is present and is an array
        if (request('M') && is_array(request('M'))) {
            $Morder = 1;
            foreach (request('M') as $moduleData) {

                $module = new Module();
                $module->title = $moduleData['title'];
                $module->course_id = $course->id;
                $module->order = $Morder++;
                $module->save();

                // Check if 'S' (Submodules) is present and is an array in each module
                if (isset($moduleData['S']) && is_array($moduleData['S'])) {
                    $Sorder = 1;
                    foreach ($moduleData['S'] as $submoduleData) {
                        $submodule = new Submodule(); // Assuming submodules are also 'Module' instances
                        $submodule->title = $submoduleData['title'];
                        $submodule->module_id = $module->id;
                        $submodule->order = $Sorder++;

                        // Upload submodule video if it exists
                        $submodule->save();
                        if (isset($submoduleData['file'])) {
                            $file = $submoduleData['file']; // Retrieve the uploaded file from the request
                            $filename = $file->getClientOriginalName(); // Retrieve the original filename
                            // Save the file locally before uploading to Cloudinary
                            $path = 'C' . $course->id . '/' . 'M' . $module->order . '/' . 'S' . $submodule->id . '-' . $filename;
                            Storage::disk('local')->put($path, file_get_contents($file));

                            // Get full path to the stored file
                            $filepath = storage_path('app/' . $path);

                            // Define the Cloudinary folder structure
                            $videoToBeStoredPathOnCloud = 'LMS/Categories/' . request('category') . '/' . $course->id . '/modules/' . $module->id . '/submodules/' . $submodule->id . '/' . 'video/';

                            $videouploadlog = new VideoUploadLogs();
                            $videouploadlog->submodule_id = $submodule->id;
                            $videouploadlog->save();


                            // Dispatch the job to upload the video to Cloudinary
                            UploadVideoToCloudinary::dispatch($filepath, $videoToBeStoredPathOnCloud, $submodule->id, $videouploadlog->id, false);
                        }
                    }
                }
            }
        }
        flash()->success('Course created successfully');
        return redirect('/mycourses');
    }

    public function show(Course $course)
    {
        $ratings = Rating::where('course_id', $course->id)->limit(3)->get();
        $coupon = null;
        $isCouponValid = false;

        if (request('coupon')) {
            $coupon = Coupon::where('coupon_code', request('coupon'))->first();

            if ($coupon) {
                if (!$coupon->isValid()) {
                    flash()->error('Coupon is Expired!');
                    return redirect('/course/'.$course->id);
                }
                elseif (!$coupon->isValidForCourse($course->id)) {
                    flash()->error('Coupon is not valid for this course');
                    return redirect('/course/'.$course->id);
                }
                elseif ($coupon->total_usage_count == $coupon->max_usage_limit) {
                    flash()->error('Coupon usage limit reached');
                    return redirect('/course/'.$course->id);
                }
                elseif ($coupon->max_usages_per_user && $coupon->usersUsed()->where('user_id', Auth::id())->count() >= $coupon->max_usages_per_user) {
                    flash()->error('You have already used this coupon');
                    return redirect('/course/'.$course->id);
                }
                elseif ($coupon->minimum_order_value > $course->price) {  // Fix this condition: it should be greater than
                    // dd($coupon->minimum_order_value);
                    flash()->error('Coupon is valid only for orders above $' . $coupon->minimum_order_value);
                    return redirect('/course/'.$course->id);
                }
                $isCouponValid = true;
                flash()->success('Coupon successfully applied!');
            }
            // elseif(!$coupon){
            //     flash()->error('Coupon Not Found!');
            //     return redirect()->back();
            // }
        }

        return view('course.show', [
            'course' => $course,
            'ratings' => $ratings,
            'isCouponValid' => $isCouponValid,
            'coupon' => $coupon,
        ]);
    }


    public function edit(Course $course)
    {
        if (!Gate::allows('update', $course)) {
            abort(403);
        }
        $quizzes = Quiz::all();
        return view('course.edit', ['course' => $course, 'categories' => Category::all(), 'quizzes' => $quizzes]);
    }

    public function update(Course $course)
    {
        // dd(request('quizzes'));
        // dd(request()->file());
        if (!Gate::allows('update', $course)) {
            abort(403);
        }
        $validatedData = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'est_price' => 'required',
            'about' => 'required',
            'language' => 'nullable',
            'difficulty' => 'string|required',
            'max_students' => 'nullable',
        ]);

        $category = Category::find(request('category_id'));
        $categoryPrice = $category->categoryPrice;
        if ($categoryPrice) {
            if (request('price') < $categoryPrice->min_price) {
                throw ValidationException::withMessages(['min_price' => 'Its Less then min Category Price limit']);
            }
            if (request('price') > $categoryPrice->max_price) {
                throw ValidationException::withMessages(['max_price' => 'Current Price is Greater than Categories max Price Threshold']);
            }
        }

        if (request('quizzes') && is_array(request('quizzes'))) {
            foreach (request('quizzes') as $quiz_id) {
                $quiz = Quiz::find($quiz_id);
                $quiz->course_id = $course->id;
                $quiz->save();
            }
        }


        if (request()->file('thumbnail_url')) {
            $image = request()->file('thumbnail_url')->getRealPath();
            $uploaded_image_url = Cloudinary::upload($image, [
                'folder' => 'LMS/Categories/' . Category::find(request('category_id'))->name . '/' . $course->id . '/thumbnail/',
            ])->getSecurePath();
            $course->thumbnail_url = $uploaded_image_url;
        }

        if (request()->file('intro_url')) {
            $video = request()->file('intro_url')->getRealPath();

            // Upload the video to Cloudinary and get the response object
            $video_upload_response = Cloudinary::uploadVideo($video, [
                'folder' => 'LMS/Categories/' . Category::find(request('category_id'))->name . '/' . $course->id . '/intro/',
            ]);

            $responseData = $video_upload_response->getResponse();
            if (!$responseData) {
                return response()->json(['error' => 'Failed to Upload Video On Cloudinary'], 500);
            }


            // Create a new Video instance and populate it with metadata
            if ($course->video_id) {
                $videoInstance = Video::find($course->video_id);
                Cloudinary::destroy($videoInstance->public_id, [
                    'resource_type' => 'video',
                ]);
            } else {
                $videoInstance = new Video();
            }

            // $videoInstance = $course->video_id ? Video::find($course->video_id) : new Video();
            $videoInstance->url = $responseData['secure_url']; // Secure URL
            $videoInstance->duration = $responseData['duration']; // Duration in seconds
            $videoInstance->type = $responseData['format']; // Format (e.g., mp4)
            $videoInstance->public_id = $responseData['public_id']; // Format (e.g., mp4)

            // Save the video details to the database
            $videoInstance->save();
            $course->video_id = $videoInstance->id;
        }

        request('is_free') ? $course->is_free = 1 : $course->is_free = 0;


        $course->update($validatedData);

        if (!$course) {
            flash()->error('Error updating course. Please try again.');
            return back();
        }

        flash()->success('Course updated successfully.');
        return redirect()->back();
    }

    public function unenrolluser(Course $course, User $user)
    {
        $user->courses()->detach($course->id);
        DB::table('enrolled_users_by_admin')->where('course_id', $course->id)->where('learner_id', $user->id)->delete();
        DB::table('unenrolled_users_by_admin')->insert([
            'course_id' => $course->id,
            'learner_id' => $user->id,
            'admin_id' => Auth::id(),
            'created_at' => now(),
        ]);
        flash()->success('Successfully Unennrolled User from the Course!');
        return redirect()->back();
    }
    public function enrolluser(User $user)
    {
        $course = Course::find(request('course_id'));
        $user->courses()->attach($course->id, ['enrolled_at' => now()]);
        DB::table('enrolled_users_by_admin')->insert([
            'course_id' => $course->id,
            'learner_id' => $user->id,
            'admin_id' => Auth::id(),
            'created_at' => now(),
        ]);
        flash()->success('Successfully Enrolled User to the Course!');
        return redirect()->back();
    }

    public function destroy(Course $course)
    {
        if (!Gate::allows('update', $course)) {
            abort(403);
        }
    }

    public function reapplyForApproval(Course $course)
    {
        $course->approvalRequest->status = 'pending';
        $course->approvalRequest->save();
        DB::table('course_approval_logs')->insert([
            'course_id' => $course->id,
            'status' => 'pending',
            'created_at' => now(),
        ]);

        flash()->success('Successfully Reapplied fo Approval!');
        return redirect()->back();
    }

    public function ratings(Course $course)
    {
        $ratings = $course->ratings;
        $ratings = $ratings->sortByDesc('created_at');
        return view('course.ratings', ['ratings' => $ratings, 'course' => $course]);
    }
}
