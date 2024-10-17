<?php

namespace App\Http\Controllers;

use App\Jobs\UploadVideoToCloudinary;
use App\Models\Category;
use App\Models\Course;
use App\Models\Module;
use App\Models\Payment;
use App\Models\Submodule;
use App\Models\Video;
use App\Models\VideoUploadLogs;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Stripe\StripeClient;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('course.mycourses', ['courses' => $courses]);
    }

    public function exploreCourses()
    {
        return view('course.index');
    }

    public function create()
    {
        return view('course.create', ['categories' => Category::all(), 'languages' => DB::table('languages')->get(), 'quizzes' => DB::table('quizzes')->get()]);
    }

    public function store()
    {
        // dd(request());
        request()->validate([
            'title' => 'required|max:255',
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
        ]);
        // dd(request());


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
        // Uploading course thumbnail
        $image = request()->file('thumbnail_url')->getRealPath();
        $image_upload_response = Cloudinary::upload($image, [
            'folder' => 'LMS/Categories/' . Category::find(request('category'))->name . '/' . $course->id . '/thumbnail/',
        ])->getSecurePath();

        $course->thumbnail_url = $image_upload_response;
        $course->save();

        if (request()->file('intro_url')) {
            $file = request()->file('intro_url'); // Retrieve the uploaded file from the request
            $filename = $file->getClientOriginalName();
            $path = 'C'.$course->id.'/'.'Intro/'. $filename;
            Storage::disk('local')->put($path, file_get_contents($file));
                        
            // Get full path to the stored file
            $filepath = storage_path('app/' . $path);
            $cloudinaryPath = 'LMS/Categories/' . Category::find(request('category'))->name . '/' . $course->id . '/intro/';

            $videouploadlog = new VideoUploadLogs();
            $videouploadlog->course_id = $course->id;
            $videouploadlog->save();

            UploadVideoToCloudinary::dispatch($filepath,$cloudinaryPath,$course->id,$videouploadlog->id,true);
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
                            $path = 'C'.$course->id.'/'.'M'.$module->order.'/'.'S'.$submodule->id.'-' . $filename;
                            Storage::disk('local')->put($path, file_get_contents($file));
                        
                            // Get full path to the stored file
                            $filepath = storage_path('app/' . $path);
                        
                            // Define the Cloudinary folder structure
                            $videoToBeStoredPathOnCloud = 'LMS/Categories/' . request('category') . '/' . $course->id . '/modules/' . $module->id . '/submodules/' . $submodule->id . '/' . 'video/';
                        
                            $videouploadlog = new VideoUploadLogs();
                            $videouploadlog->submodule_id = $submodule->id;
                            $videouploadlog->save();

                        
                            // Dispatch the job to upload the video to Cloudinary
                            UploadVideoToCloudinary::dispatch($filepath, $videoToBeStoredPathOnCloud, $submodule->id,$videouploadlog->id,false);

                        }
                        
                        
                    }
                }
            }
        }

        return redirect('/dash');
    }

    public function show(Course $course)
    {


        $isPurchased = $course->isCoursePurchased(Auth::user()->id);


        return view('course.show', ['course' => $course, 'isPurchased' => $isPurchased]);
    }

    public function edit(Course $course)
    {
        return view('course.edit', ['course' => $course, 'categories' => Category::all()]);
    }

    public function update(Course $course)
    {
        // dd(request()->file());
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
            throw ValidationException::withMessages(['updateError' => 'failed to Update the course!']);
        }


        return response()->json(['sucess' => 'Successfully Updated']);

    }

    public function destroy($id)
    {

    }
}
