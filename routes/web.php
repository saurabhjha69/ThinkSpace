<?php

use App\Charts\MonthlyCourseSaleChart;
use App\Charts\MonthlyUsersChart;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\McqController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\MultianswerController;
use App\Http\Controllers\OnelineController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\TrueFalseController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SubPermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CouponController;
use App\Models\Attemptedquiz;
use App\Http\Middleware\RoleBasedDashboard;
use App\Models\Category;
use App\Models\Comment;
use App\Models\SubModule;
use App\Models\ReappliedApprovals;
use App\Models\CompletedSubModule;
use App\Models\Course;
use App\Models\Mcq;
use App\Models\Mcqans;
use App\Models\Module;
use App\Models\Multians;
use App\Models\Multianswer;
use App\Models\Oneline;
use App\Models\Onelineans;
use App\Models\Payment;
use App\Models\Prefrences;
use App\Models\Quiz;
use App\Models\Rating;
use App\Models\Role;
use App\Models\Truefalse;
use App\Models\Truefalseans;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\Video;
use App\Models\VideoStats;
use App\Models\VideoUploadLogs;
use App\Models\Permission;
use App\Models\SubPermission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Http\Middleware\AdminMiddlewar;




// user creation
Route::group(['middleware' => 'auth', 'middleware' => 'allowRole:Admin'], function () {
    Route::get('/user/create', [UserController::class, 'create'])->name('create');
    Route::get('/user', [UserController::class, 'index'])->name('index');
    Route::get('/user/{user}', [UserController::class, 'show'])->name('show');
    Route::delete('/user', [UserController::class, 'destroy'])->name('destroy');
    Route::get('/user/edit/{user}', [UserController::class, 'edit'])->name('edit');
    Route::put('/user/edit/{user}', [UserController::class, 'update'])->name('update');;
    Route::post('/user/create', [UserController::class, 'store'])->name('store');
    Route::post('/user/sort', [UserController::class, 'sort'])->name('sort');
    Route::put('/user/{user}', [UserController::class, 'suspend'])->name('suspend');

    Route::get('/categories', [CategoryController::class, 'index'])->name('index');
    Route::get('/category/{category}', [CategoryController::class, 'show'])->name('show');
    Route::post('/category/create', [CategoryController::class, 'store'])->name('store');
    Route::delete('/category/del', [CategoryController::class, 'destroy'])->name('destroy');

    //admin
    Route::get('/roles', [RoleController::class, 'index'])->name('roles');
    Route::post('/process_role', [RoleController::class, 'process_role'])->name('process_role');
    Route::get('/map-subpermissions-to-permissions', [SubPermissionController::class, 'mapSubPermissions'])->name('map-subpermissions-to-permissions');
    Route::post('/map-subpermissions-to-permissions', [SubPermissionController::class, 'processSubPermissions'])->name('process_subpermissions');
    Route::delete('/role', function () {
        $deletedrole = DB::table('roles')->where('id', request('roleName'))->delete();
        if (!$deletedrole)
            throw ValidationException::withMessages(['roleid' => 'failed to delete role']);
        return redirect('/roles_permissions');
    });
    Route::get('/approve-course/{course}', [AdminController::class, 'approveCourseEdit'])->name('approve-course-edit');
    Route::post('/approve-course/{course}', [AdminController::class, 'approveCourse'])->name('approve-course');

    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
});


// auth



Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::get('/signup', [AuthController::class, 'signupView'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/switch-role', [AuthController::class, 'refreshSession'])->name('refreshSession')->middleware('auth');



//categories+++



//course

Route::post('/course', [CourseController::class, 'store'])->name('store');
Route::get('/course/create', [CourseController::class, 'create'])->name('create');
Route::get('/course/{course}', [CourseController::class, 'show'])->name('show')->middleware('auth');
Route::get('/course/edit/{course}', [CourseController::class, 'edit'])->name('edit');
Route::put('/course/edit/{course}', [CourseController::class, 'update'])->name('update');
Route::get('/mycourses', [CourseController::class, 'index'])->name('index');
Route::get('/explore', [CourseController::class, 'explore'])->name('explore');
Route::get('/course/report/{course}', [AnalysisController::class, 'singleCourse']);
Route::put('/course/{course}/user/{user}/unenroll', [CourseController::class, 'unenrolluser'])->name('course.unenroll.user');
Route::post('/course/user/{user}/enroll', [CourseController::class, 'enrolluser'])->name('course.enroll.user');
Route::post('/course-approval/reapply/{course}', [CourseController::class, 'reapplyForApproval'])->name('course.approval.reapply');
Route::get('/course/{course}/ratings', [CourseController::class, 'ratings'])->name('course.ratings');

Route::get('modules/{module}', [ModuleController::class, 'edit'])->name('edit');
Route::put('modules/edit/{module}', [ModuleController::class, 'update'])->name('update');
Route::get('course/{course}/modules', [ModuleController::class, 'index'])->name('index');
Route::post('/course/modules/add', [ModuleController::class, 'store'])->name('store');
Route::delete('/module/delete', [ModuleController::class, 'destroy']);


Route::get('/certificate/{course}', [CertificateController::class, 'generateCertificate']);


// Coupon routes
Route::get('/coupons', [CouponController::class, 'index'])->name('coupons.index'); // Display all coupons
Route::get('/coupons/create', [CouponController::class, 'create'])->name('coupons.create'); // Show form to create coupon
Route::post('/coupons', [CouponController::class, 'store'])->name('coupons.store'); // Store coupon
Route::get('/coupons/{coupon}/edit', [CouponController::class, 'edit'])->name('coupons.edit'); // Show form to edit coupon
Route::put('/coupons/{coupon}', [CouponController::class, 'update'])->name('coupons.update'); // Update coupon
Route::delete('/coupons/{coupon}', [CouponController::class, 'destroy'])->name('coupons.destroy'); // Delete coupon

// Linking coupons to courses
Route::post('/coupons/{coupon}/courses', [CouponController::class, 'linkCourse'])->name('coupons.linkCourse'); // Link coupon to course
Route::get('/coupon/report/{coupon}', [CouponController::class, 'report'])->name('coupons.report');

//quiz
Route::get('/quiz/create', [QuizController::class, 'create'])->name('create');
Route::get('/quizs', [QuizController::class, 'index'])->name('index');
Route::post('/quiz/create', [QuizController::class, 'store'])->name('store');
Route::get('quiz/edit/{quiz}', [QuizController::class, 'edit'])->name('edit');
Route::put('quiz/edit/{quiz}', [QuizController::class, 'update'])->name('update');
Route::delete('quiz/{quiz}', [QuizController::class, 'destroy'])->name('destroy');
Route::get('quiz/{quiz}', [QuizController::class, 'show'])->name('show');



//questions
Route::put('/multians/{multianswer}', [MultianswerController::class, 'update'])->name('update');
Route::put('/mcq/{mcq}', [McqController::class, 'update'])->name('update');
Route::put('/oneline/{oneline}', [OnelineController::class, 'update'])->name('update');
Route::put('/truefalse/{truefalse}', [TrueFalseController::class, 'update'])->name('update');

//payment
Route::post('/create-checkout-session/{coupon}', [PaymentController::class, 'process'])->middleware(['auth']);
Route::get('/success', [PaymentController::class, 'success'])->name('success');
Route::get('/failure', function () {
    return response('Failed to Purchase the course');
});


Route::get('/dash', function () {

    return view('home.index', ['user' => Auth::user()]);
})->middleware(['auth','roleBasedDashboard:learner']);

Route::get('/instructor', function () {
    $enrolledUsers = Auth::user()->enrolledStudents();
    return view('home.instructor', ['user' => Auth::user(), 'enrolledUsers' => $enrolledUsers]);
})->middleware('auth')->name('instructor');
Route::get('/admin', function (MonthlyUsersChart $chart, MonthlyCourseSaleChart $saleschart) {
    $roles = Role::withCount('users')->get();


    $data = $roles->pluck('users_count')->toArray();
    $labels = $roles->pluck('name')->toArray();
    $chart = $chart->build($data, $labels);

    $topCourses = Course::withCount('users')
        ->orderBy('users_count', 'desc')
        ->take(5)
        ->get();


    $salesData = [];
    $courseNames = [];

    foreach ($topCourses as $course) {
        $totalSales = $course->payments()->sum('amount');
        $salesData[] = $totalSales;
        $courseNames[] = $course->name;
    }
    $saleschart = $saleschart->build($salesData, $courseNames);
    return view('home.admin', [
        'user' => Auth::user(),
        'users' => User::all(),
        'videologs' => VideoUploadLogs::orderBy('updated_at', 'desc')->limit(4)->get(),
        'courses' => Course::orderBy('created_at', 'desc')->limit(5)->get(),
        'revenue' => Payment::sum('amount'),
        'monthlyUsersChart' => $chart,
        'monthlyCourseSalesChart' => $saleschart
    ]);
})->middleware('auth')->middleware(AdminMiddlewar::class);
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->name('profile.edit.profile');
Route::get('/profile/photo', [ProfileController::class, 'editProfilePicture'])->name('profile.edit.photo');
Route::get('/profile/settings', [ProfileController::class, 'editProfileSettings'])->name('profile.edit.settings');
Route::post('/profile/edit', [ProfileController::class, 'updateProfile'])->name('profile.update.profile');
Route::post('/profile/photo', [ProfileController::class, 'updateProfilePicture'])->name('profile.update.photo');
Route::put('/profile/settings', [ProfileController::class, 'updateProfileSettings'])->name('profile.update.settings');
Route::get('/instructor-profile/{user}', [ProfileController::class, 'instructorProfile'])->name('profile.instructor');

Route::get('/feilds', function () {
    return view('profile.feilds');
});










Route::get('/prefrences', function () {
    $user = Auth::user();
    $userExists = Prefrences::where('user_id', $user->id)->first();

    if ($userExists) {
        // If preferences exist, redirect to the dashboard
        return redirect('/dash');
    } else {
        // If no preferences exist, show the interest selection view
        return view('interest.selection', ['categories' => Category::all()]);
    }
});
Route::get('/thankspage', function () {
    return view('interest.thankspage', ['username' => Auth::user()->name]);
});
Route::post('/user/prefrences', function () {
    $user = Auth::user();

    if (request('categories') && is_array(request('categories'))) {
        foreach (request('categories') as $category) {

            $prefrences = new Prefrences();
            $prefrences->user_id = $user->id;
            $prefrences->category_id = $category;
            $prefrences->save();
        }
        return redirect('/thankspage');
    };

    throw ValidationException::withMessages(['perfrences' => 'Atleast Select One Preference!']);
});


//timepass


Route::get('/course/watch/{course}', function (Course $course) {
    $defaultSubModule = null;


    foreach ($course->modules as $module) {

        foreach ($module->submodules as $submodule) {

            if (!$submodule->isMarkedCompleted()) {
                $defaultSubModule = $submodule;
                break;
            }
        }
    }
    $allCompleted = false;
    if (!$defaultSubModule) {
        $defaultSubModule = $course->modules[0]->submodules[0];
        $allCompleted = true;
    }
    $comments = Comment::where('course_id', $course->id)->get();



    return view('module.show', ['course' => $course, 'modules' => $course->modules, 'defaultSubModule' => $defaultSubModule, 'allCompleted' => $allCompleted, 'comments' => $comments]);
});

// Route::get('/course/{course}/modules/submodule/{submodule}', function (Course $course, Submodule $submodule) {
//     $video_url = $submodule->file_url;
//     return view('module.show', ['course' => $course, 'modules' => $course->modules, 'video_url' => $video_url]);
// });

Route::get('/rating', function () {
    return view('rating.create');
});

Route::post('/rating', function () {
    $validatedData = request()->validate([
        'rating' => 'required|numeric|between:1,5',
        'review' => 'required|max:255',
    ]);

    $rating = new Rating();
    $rating->user_id = Auth::user()->id;
    $rating->course_id = 808407;
    $rating->stars = request('rating');
    $rating->comment = request('review');
    $res = $rating->save();
    if (!$res) {
        throw ValidationException::withMessages(['rating' => 'Failed to insert rating']);
    }
    return redirect('/dash');
});

Route::post('create_roles_privileges', function () {});

Route::get('/explore', function () {
    $courses = Course::when(request('search'), function ($query) {
        $query->where('name', 'like', '%' . request('search') . '%');
    })
        ->when(request('categoryFilter') && request('categoryFilter') != 'All', function ($query) {
            $query->where('category_id', request('categoryFilter'));
        })
        ->when(request('orderBy'), function ($query) {
            if (request('orderBy') == 'oldest') {
                $query->orderBy('created_at', 'asc');
            }
            if (request('orderBy') == 'newest') {
                $query->orderBy('created_at', 'desc');
            }
            if (request('orderBy') == 'lowtohigh') {
                $query->orderBy('price', 'asc');
            }
            if (request('orderBy') == 'hightolow') {
                $query->orderBy('price', 'desc');
            }
        })


        ->simplePaginate(6)
        ->appends(request()->query());

    $categories = Category::all();
    return view('explore.explore', ['courses' => $courses, 'categories' => $categories]);
});
Route::post('/rate-course/{course}', function (Course $course) {
    $rating = new Rating();
    $rating->course_id = $course->id;
    $rating->user_id = request('user_id');
    $rating->stars = request('rating');
    $rating->stars = request('rating');
    $rating->comment = request('review');
    $res = $rating->save();
    if (!$res) {
        return redirect('/course/watch/' . $course->id)->with('ratingfail', 'Failed to add rating!');
    }
    return redirect('/course/watch/' . $course->id)->with('success', 'rating added successfully');
});

Route::post('/mark-submodule-complete', function () {
    $markSubModuleComplete = CompletedSubModule::where('user_id', Auth::id())
        ->where('submodule_id', request('submodule_id'))
        ->first();

    // Log current completion status
    Log::info('Current Status: ' . $markSubModuleComplete);

    // If no record exists, create a new entry
    if (!$markSubModuleComplete) {
        $submodule = Submodule::find(request('submodule_id'));
        $markedSubModule = new CompletedSubModule();
        $markedSubModule->course_id = $submodule->module->course_id;
        $markedSubModule->module_id = $submodule->module_id;
        $markedSubModule->submodule_id = $submodule->id;
        $markedSubModule->user_id = Auth::id();
        $markedSubModule->is_completed = 1;  // Mark as completed
        $res = $markedSubModule->save();

        Log::info('New Submodule Marked as Completed: ' . $markedSubModule->is_completed);

        if (!$res) {
            return redirect('/course/watch/' . request('course_id'))->with('fail', 'Failed to Mark Submodule as Completed');
        }
        return redirect('/course/watch/' . request('course_id'))->with('success', 'Marked SubModule as Completed');
    }

    // Toggle the status
    $markSubModuleComplete->is_completed = $markSubModuleComplete->is_completed == 1 ? 0 : 1;
    Log::info('New Toggled Status: ' . $markSubModuleComplete->is_completed);

    // Save the changes
    $res = $markSubModuleComplete->save();
    Log::info('Save Result: ' . $res);

    if (!$res) {
        return redirect('/course/watch/' . request('course_id'))->with('error', 'Failed to Update SubModule!');
    }

    // Provide appropriate success message
    if ($markSubModuleComplete->is_completed == 1) {
        return redirect('/course/watch/' . request('course_id'))->with('success', 'Marked SubModule as Completed');
    } else {
        return redirect('/course/watch/' . request('course_id'))->with('success', 'Marked SubModule as Incomplete');
    }
});



Route::post('/update-watch-hours', function () {
    if (request('public_id') && request('duration')) {
        $video = Video::where('public_id', request('public_id'))->first();
        $videoStats = new VideoStats();
        $videoStats->video_id = $video->id;
        $videoStats->user_id = Auth::id();
        $videoStats->watch_hours = request('duration');
        $res = $videoStats->save();
        if (!$res) {
            return response()->json('Failed to Add Video Stats', 403);
        }
        return response()->json('Succesfully added the stats', 200);
    }
});



Route::post('/comment/create', [CommentController::class, 'store']);
Route::get('/comment/{submodule}', [CommentController::class, 'index']);
Route::put('/comment/edit/{comment}', [CommentController::class, 'update']);
Route::delete('/comment/delete/{comment}', [CommentController::class, 'destroy']);


Route::get('/course/watch/{course}/{quiz}', function (Course $course, Quiz $quiz) {
    $defaultSubModule = null;
    foreach ($course->modules as $module) {
        foreach ($module->submodules as $submodule) {
            if (!$submodule->isMarkedCompleted()) {
                $defaultSubModule = $submodule;
                break;
            }
        }
    }
    $questions = $quiz->questions();
    return view('module.show', ['quiz' => $quiz, 'course' => $course, 'modules' => $course->modules, 'defaultSubModule' => $defaultSubModule, 'comments' => $course->comments, 'questions' => $questions, 'quiz' => $quiz]);
})->name('attempt.quiz');

Route::post('/submit-quiz/{quiz}', function (Quiz $quiz) {
    // request()->validate([
    //     'mcq.*.ans' => 'required',
    //     'truefalse.*.ans' => 'required',
    //     'oneline.*.ans' => 'required',
    // ]);

    $total_marks = 0;
    $total_attemped_questions = 0;
    $total_correct_answers = 0;
    $total_wrong_answers = 0;
    if (request('mcq') && is_array(request('mcq'))) {
        foreach (request('mcq') as $mcq) {
            if (!isset($mcq['ans'])) {
                flash()->info('Please answer all MCQ questions');
                return redirect()->back();
            }
            $mcqansInstance = new Mcqans();
            $mcqansInstance->user_id = Auth::id();
            $mcqansInstance->mcq_id = $mcq['id'];
            $mcqansInstance->ans = $mcq['ans'];

            if (Mcq::where('id', $mcq['id'])->where('ans', $mcq['ans'])->exists()) {
                $marks = Mcq::where('id', $mcq['id'])->value('marks');
                $mcqansInstance->marks = $marks;
                $total_marks += $marks;
                $mcqansInstance->is_correct = true;
                $total_correct_answers++;
            } else {
                $mcqansInstance->marks = 0;
                $mcqansInstance->is_correct = false;
                $total_wrong_answers++;
            }
            $mcqansInstance->save();
        }
    }
    if (request('multians') && is_array(request('multians'))) {
        foreach (request('multians') as $multians) {
            if (!isset($multians['ans'])) {
                flash()->info('Please answer all Multians questions');
                return redirect()->back();
            }
            $multianswers = new Multians(); // Correct model
            $multianswers->user_id = Auth::id();
            $multianswers->multianswer_id = $multians['id'];

            // Retrieve the correct multi-answer choices from the database
            $multiansObject = Multianswer::find($multians['id']);
            $correctChoices = $multiansObject->correctAnswers();
            $userChoices = [];
            foreach ($multians['ans'] as $choice) {
                array_push($userChoices, $choice);
            }
            // dd($correctChoices);
            // dd($userChoices);
            // Compare the user's choices with the correct choices

            $isCorrect = $correctChoices == $userChoices;
            if ($isCorrect) {
                $multianswers->marks = $multiansObject->marks;
                $total_marks += $multiansObject->marks;
                $multianswers->is_correct = true;
                $total_correct_answers++;
            } else {
                $multianswers->marks = 0;
                $multianswers->is_correct = false;
                $total_wrong_answers++;
            }
            foreach ($userChoices as $userAnswer) {
                $multianswers->{'choice' . $userAnswer} = $userAnswer;
            }
            $multianswers->save();
        }
    }
    if (request('oneline') && is_array(request('oneline'))) {
        foreach (request('oneline') as $oneline) {
            if (!isset($oneline['ans'])) {
                flash()->info('Please answer all Oneline questions');
                return redirect()->back();
            }
            $onelineans = new Onelineans();
            $onelineans->user_id = Auth::id();
            $onelineans->oneline_id = $oneline['id'];
            $onelineans->ans = $oneline['ans'];

            if (Oneline::where('id', $oneline['id'])->where('ans', $oneline['ans'])->exists()) {
                $marks = Oneline::where('id', $oneline['id'])->value('marks');
                $onelineans->marks = $marks;
                $total_marks += $marks;
                $onelineans->is_correct = true;
                $total_correct_answers++;
            } else {
                $onelineans->marks = 0;
                $onelineans->is_correct = false;
                $total_wrong_answers++;
            }
            $onelineans->save();
        }
    }
    if (request('truefalse') && is_array(request('truefalse'))) {
        foreach (request('truefalse') as $truefalse) {
            if (!isset($truefalse['ans'])) {
                flash()->info('Please answer all Truefalse questions');
                return redirect()->back();
            }
            $truefalseans = new Truefalseans(); // Use correct model
            $truefalseans->user_id = Auth::id();
            $truefalseans->truefalse_id = $truefalse['id'];
            $truefalseans->ans = (int) $truefalse['ans'];

            if (Truefalse::where('id', $truefalse['id'])->where('ans', (int) $truefalse['ans'])->exists()) {
                $marks = Truefalse::where('id', $truefalse['id'])->value('marks');
                $truefalseans->marks = $marks;
                $total_marks += $marks;
                $truefalseans->is_correct = true;
                $total_correct_answers++;
            } else {
                $truefalseans->marks = 0;
                $truefalseans->is_correct = false;
                $total_wrong_answers++;
            }
            $truefalseans->save();
        }
    }
    $attemptedQuiz = new Attemptedquiz();
    $attemptedQuiz->user_id = Auth::id();
    $attemptedQuiz->quiz_id = $quiz->id;
    $attemptedQuiz->marks = $total_marks;
    $attemptedQuiz->is_completed = true;
    $attemptedQuiz->total_correct_ans = $total_correct_answers;
    $attemptedQuiz->total_wrong_ans = $total_wrong_answers;
    $attemptedQuiz->total_attempted_ans = $total_correct_answers + $total_wrong_answers;

    $res = $attemptedQuiz->save();
    if ($res) {
        flash()->success('Quiz submitted successfully');
        return back();
        // return redirect()->route('attempt.quiz',['submittedQuiz'=>$attemptedQuiz]);
    } else {
        flash()->error('Something went wrong');
        return redirect()->back();
    }
});
