<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\McqController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\MultianswerController;
use App\Http\Controllers\OnelineController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\TrueFalseController;
use App\Http\Controllers\UserController;
use App\Models\Attemptedquiz;
use App\Models\Category;
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
use App\Models\Privilege;
use App\Models\Purchasedcourse;
use App\Models\Quiz;
use App\Models\Rating;
use App\Models\Role;
use App\Models\Submodule;
use App\Models\Subprivilege;
use App\Models\Truefalse;
use App\Models\Truefalseans;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\Video;
use App\Models\VideoStats;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Stripe\StripeClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\HtmlString;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

use function Pest\Laravel\json;

// Route::get('/user/create', function () {
//     return view('team-create');
// });

// user creation
Route::get('/user/create', [UserController::class, 'create'])->name('create');
Route::get('/user', [UserController::class, 'index'])->name('index');
Route::delete('/user', [UserController::class, 'destroy'])->name('destroy');
Route::get('/user/edit/{user}', [UserController::class, 'edit'])->name('edit');
Route::put('/user/edit/{user}', [UserController::class, 'update'])->name('update');
;
Route::post('/user/create', [UserController::class, 'store'])->name('store');
Route::post('/user/sort', [UserController::class, 'sort'])->name('sort');


// auth

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/signup', function () {
    return view('auth.signup');
});
Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



//categories
Route::get('/categories', [CategoryController::class, 'index'])->name('index');
Route::post('/category/create', [CategoryController::class, 'store'])->name('store');
Route::delete('/category/del', [CategoryController::class, 'destroy'])->name('destroy');


//course

Route::post('/course', [CourseController::class, 'store'])->name('store');
Route::get('/course/create', [CourseController::class, 'create'])->name('create');
Route::get('/course/{course}', [CourseController::class, 'show'])->name('show');
Route::get('/course/edit/{course}', [CourseController::class, 'edit'])->name('edit');
Route::put('/course/edit/{course}', [CourseController::class, 'update'])->name('update');
Route::get('/mycourses', [CourseController::class, 'index'])->name('index');
Route::get('/explore', [CourseController::class, 'explore'])->name('explore');

Route::get('modules/{module}',[ModuleController::class, 'edit'])->name('edit');
Route::put('modules/edit/{module}',[ModuleController::class, 'update'])->name('update');
Route::get('course/{course}/modules',[ModuleController::class, 'index'])->name('index');
Route::post('/course/modules/add',function(){
    request()->validate([
        'module.*.title' => 'required',
        'course_id' => 'required'
    ]);

    $course = Course::find(request('course_id'));
    $counter = 0;
    if(request('module') && is_array(request('module'))){
        foreach(request('module') as $index => $module){
            $moduleInstance = new Module();
            $moduleInstance->course_id = $course->id;
            $moduleInstance->title = $module['title'];
            $moduleInstance->order = $index;
            $res = $moduleInstance->save();
            if(!$res){
                return redirect()->back()->with('fail','Failed to Add Module'.$module['title']);
            }
            $counter++;
        }
    }
    flash()->success('Successfully Added '.$counter.' Module');
    return redirect('course/'.$course->id.'/modules');
});
Route::delete('/module/delete',[ModuleController::class, 'destroy']);

//certificat
// Route::get('/certificate/get',function(){
//     return view('certificate.structure');
// });
Route::get('/certificate/{course}', [CertificateController::class, 'generateCertificate']);

//quiz
Route::get('/quiz', [QuizController::class, 'create'])->name('create');

Route::get('/quizs', [QuizController::class, 'index'])->name('index');
Route::post('/quiz', [QuizController::class, 'store'])->name('store');
Route::get('quiz/{quiz}', [QuizController::class, 'edit'])->name('edit');
Route::put('quiz/edit/{quiz}', [QuizController::class, 'update'])->name('update');

Route::get('/attempt/quiz/{quiz}', function (Quiz $quiz) {
    return view('quiz.attempt.attempt', ['quiz' => $quiz]);
});
Route::post('/attempt/quiz/{quiz}', function (Quiz $quiz) {
    $validatedData = request()->validate([
        'mcq.*.question' => 'required',
        'mcq.*.ans' => 'required',
        'mcq.*.id' => 'required',
        'oneline.*.question' => 'required',
        'oneline.*.ans' => 'required',
        'oneline.*.id' => 'required',
        'truefalse.*.question' => 'required',
        'truefalse.*.ans' => 'required',
        'truefalse.*.id' => 'required',
        'multians.*.question' => 'required',
        'multians.*.id' => 'required',
        'multians.*.choice1' => 'required_without_all:multians.*.choice2,multians.*.choice3,multians.*.choice4',
        'multians.*.choice2' => 'required_without_all:multians.*.choice1,multians.*.choice3,multians.*.choice4',
        'multians.*.choice3' => 'required_without_all:multians.*.choice1,multians.*.choice2,multians.*.choice4',
        'multians.*.choice4' => 'required_without_all:multians.*.choice1,multians.*.choice2,multians.*.choice3',
    ]);
    $user = Auth::user();
    $total_marks = 0;
    
    


    // Handle MCQs
    if (!empty($validatedData['mcq'])) {
        foreach ($validatedData['mcq'] as $mcq) {
            $mcqans = new Mcqans();
            $mcqans->user_id = $user->id;
            $mcqans->mcq_id = $mcq['id'];
            $mcqans->ans = $mcq['ans'];

            if (Mcq::where('id', $mcq['id'])->where('ans', $mcq['ans'])->exists()) {
                $marks = Mcq::where('id', $mcq['id'])->value('marks');
                $mcqans->marks = $marks;
                $total_marks += $marks;
                $mcqans->is_correct = true;
            } else {
                $mcqans->marks = 0;
                $mcqans->is_correct = false;
            }
            $mcqans->save();
        }
    }

    // Handle One-line answers
    if (!empty($validatedData['oneline'])) {
        foreach ($validatedData['oneline'] as $oneline) {
            $onelineans = new Onelineans();
            $onelineans->user_id = $user->id;
            $onelineans->oneline_id = $oneline['id'];
            $onelineans->ans = $oneline['ans'];

            if (Oneline::where('id', $oneline['id'])->where('ans', $oneline['ans'])->exists()) {
                $marks = Oneline::where('id', $oneline['id'])->value('marks');
                $onelineans->marks = $marks;
                $total_marks += $marks;
                $onelineans->is_correct = true;
            } else {
                $onelineans->marks = 0;
                $onelineans->is_correct = false;
            }
            $onelineans->save();
        }
    }

    // Handle True/False answers
    if (!empty($validatedData['truefalse'])) {
        foreach ($validatedData['truefalse'] as $truefalse) {
            $truefalseans = new Truefalseans(); // Use correct model
            $truefalseans->user_id = $user->id;
            $truefalseans->truefalse_id = $truefalse['id'];
            $truefalseans->ans = (int) $truefalse['ans'];

            if (Truefalse::where('id', $truefalse['id'])->where('ans', (int) $truefalse['ans'])->exists()) {
                $marks = Truefalse::where('id', $truefalse['id'])->value('marks');
                $truefalseans->marks = $marks;
                $total_marks += $marks;
                $truefalseans->is_correct = true;
            } else {
                $truefalseans->marks = 0;
                $truefalseans->is_correct = false;
            }
            $truefalseans->save();
        }
    }

    // Handle Multi-answer questions
    if (!empty($validatedData['multians'])) {
        foreach ($validatedData['multians'] as $multians) {
            $multianswers = new Multians(); // Correct model
            $multianswers->user_id = $user->id;
            $multianswers->multianswer_id = $multians['id'];
    
            // Retrieve the correct multi-answer choices from the database
            $multiansObject = Multianswer::find($multians['id']);
    
            if ($multiansObject) {
                $correctChoices = 0; // Counter to track how many correct choices were made
                $totalCorrectChoices = 0; // To store how many correct choices there are
    
                // Loop through each of the possible choices and check if the submitted ones are correct
                for ($i = 1; $i <= 4; $i++) {
                    if (isset($multians['choice' . $i])) {
                        // Save the user's answer for choice $i
                        $multianswers->{'choice' . $i} = $multians['choice' . $i];
    
                        // Compare user’s choice with the correct choice in the database
                        if ($multiansObject->{'choice' . $i} == $multians['choice' . $i]) {
                            $correctChoices++; // Increment correct choice counter
                        }
                    }
    
                    // Count how many correct answers the multi-answer question has
                    if (!empty($multiansObject->{'choice' . $i})) {
                        $totalCorrectChoices++;
                    }
                }
    
                // Determine if all correct choices are made by the user
                if ($correctChoices == $totalCorrectChoices && $correctChoices > 0) {

                    $marks = Multianswer::where('id', $multians['id'])->value('marks');
                    $multianswers->marks = $marks;
                    $total_marks += $marks;
                    $multianswers->is_correct = true;
                } else {
                    $multianswers->marks = 0;
                    $multianswers->is_correct = false;
                }
    
                // Save the multi-answer result
                $multianswers->save();
            }
        }
    }
    $attemptedQuiz = new Attemptedquiz();
    $attemptedQuiz->user_id = $user->id;
    $attemptedQuiz->quiz_id = $quiz->id;
    $attemptedQuiz->marks = $total_marks;
    $attemptedQuiz->is_completed = true;
    $attemptedQuiz->save();

    return response()->json(['success','total_marks' => $total_marks]);
    
});

Route::get('/attempted/{quiz}',function(Quiz $quiz){
    return view('quiz.attempt.attemped',[
        'quiz' => $quiz
    ]);
});

Route::get('/attempted',function(){
    return view('quiz.attempt.index',[
        'quizzes' => Auth::user()->attemptedquizzes
    ]);
});


//questions
Route::put('/multians/{multianswer}', [MultianswerController::class, 'update'])->name('update');
Route::put('/mcq/{mcq}', [McqController::class, 'update'])->name('update');
Route::put('/oneline/{oneline}', [OnelineController::class, 'update'])->name('update');
Route::put('/truefalse/{truefalse}', [TrueFalseController::class, 'update'])->name('update');

//payment 
Route::get('payment/{course}', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
Route::post('payment', [PaymentController::class, 'processPayment'])->name('payment.process');

Route::post('/create-checkout-session', function () {
    $course = Course::find(request('course_id'));
    $user = Auth::user();
    $stripe = new StripeClient('sk_test_51PySJ6FDSWNoYbpZacsKpojbRFfP2m5uacznkWIoLwXg2FxgST5IvdXFbjzWCl2NBPlMcokuE9PvuH8ekZSvWeSg00byZoZkFU');

    $checkout_session = $stripe->checkout->sessions->create([
        'customer_email' => $user->email,
        'line_items' => [
            [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $course->name,
                        'images' => [$course->thumbnail_url],
                    ],
                    'unit_amount' => $course->price * 100,
                ],
                'quantity' => 1,
            ]
        ],
        'mode' => 'payment',
        'payment_method_types' => ['card'],
        'success_url' => 'http://localhost:8000/success?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => 'http://localhost:8000/course/' . $course->id . '?failed=true&session_id={CHECKOUT_SESSION_ID}',

    ]);



    Payment::create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'status' => 'pending',
        'payment_status' => 'pending',
        // Default status before payment confirmation
        'stripe_session_id' => $checkout_session->id,
    ]);

    return redirect()->to($checkout_session->url);

})->middleware(['auth']);



Route::get('/success', function () {
    // dd(request()->query('session_id'));

    $stripe = new StripeClient('sk_test_51PySJ6FDSWNoYbpZacsKpojbRFfP2m5uacznkWIoLwXg2FxgST5IvdXFbjzWCl2NBPlMcokuE9PvuH8ekZSvWeSg00byZoZkFU');
    $session_id = request()->query('session_id');
    $session = $stripe->checkout->sessions->retrieve($session_id);

    // Retrieve payment associated with the Stripe session
    $payment = Payment::where('stripe_session_id', $session->id)->first();

    if ($payment) {
        $payment->payment_status = $session->payment_status;
        $payment->status = $session->status;
        $payment->save();

        // Update the corresponding purchased course status to 'completed'

    }


    // return flash('Successfully Purchased The Course');
    return response('Successfully Purchased The Course');
});
Route::get('/failure', function () {
    return response('Failed to Purchase the course');
});


Route::get('/dash', function () {
    return view('home.index');
})->middleware('auth');

Route::get('/profile', function () {
    return view('profile.show',['user' => Auth::user()]);
});
Route::get('/profile/edit', function () {
    return view('profile.edit',['user' => Auth::user()]);
});
Route::post('/profile/edit', function () {
    $validatedData = request()->validate([
        'firstname' => 'string|required',
        'lastname' => 'string|required',
        'phone_no' => 'string|required',
        'address' => 'string|required',
        'bio' => 'string|required',
        'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
        'education' => 'string|required',
        'work_experience' => 'string|required',
        'social_links' => 'string',
    ]);

    $user = Auth::user();
    $userInfo = new UserInfo();
    $userInfo->user_id = $user->id;
    $userInfo->firstname = $validatedData['firstname'];
    $userInfo->lastname = $validatedData['lastname'];
    $userInfo->phone_no = $validatedData['phone_no'];
    $userInfo->address = $validatedData['address'];
    $userInfo->bio = $validatedData['bio'];
    $userInfo->education = $validatedData['education'];
    $userInfo->work_experience = $validatedData['work_experience'];
    $userInfo->social_links = $validatedData['social_links'];

    // $userInfo->save();
    if (request()->hasFile('profile_picture')) {
        $image = request()->file('profile_picture')->getRealPath();
        $cloudPath = Cloudinary::upload($image,[
            'folder' => 'profile_pictures/' . $user->id.'/',
            'transformation' => [
                'width' => 150,
                'height' => 150,
                'crop' => 'fill',
            ]
        ])->getSecurePath();
        $userInfo->profile_picture = $cloudPath;

        
    }
    $userInfo->save();
    flash()->success('Profile updated successfully');
    return redirect('/profile');

});

Route::get('/feilds',function(){
    return view('profile.feilds');
});
Route::get('/leaderboard', function () {
    return view('leaderboard');
});

Route::get('/roles', function () {
    flash()->success('Successfully role Created');
    return view('roles.create');
});
Route::post('/process_role', function () {
    $validatedData = request()->validate([
        'role_name' => 'string|required|unique:roles,name',
        'expiry_date' => 'date',
        'max_users_allowed' => 'nullable|integer',
    ]);

    $role = Role::create([
        'name' => $validatedData['role_name'],
        'expiry' => $validatedData['expiry_date'],
        'max_users' => $validatedData['max_users_allowed'],
    ]);
    if (!$role) {
        return back();
    }
    return redirect('/roles');
});
Route::get('/privileges', function () {
    return view('privileges.create', ['roles' => Role::all()]);
});

// Route::get('/user-create', function () {
//     return view('team-create', ['privileges' => Privilege::all(), 'roles' => Role::all()]);
// });

// Route::get('/privileges/edit',function(){
//     $privileges = Privilege::all();

//     foreach ($privileges as $privilege) {
//         // Handle existing subprivileges (checkboxes)
//         $subprivileges = request()->input('subprivileges.' . $privilege->id, []);
//         $privilege->subprivileges()->sync($subprivileges); // Sync selected subprivileges

//         // Handle newly added subprivileges
//         $newSubprivileges =request()->input('new_subprivileges.' . $privilege->id, []);
//         foreach ($newSubprivileges as $newSubprivilegeName) {
//             $newSubprivilege = Subprivilege::create(['name' => $newSubprivilegeName]); // Create new subprivilege
//             $privilege->subprivileges()->attach($newSubprivilege->id); // Attach to the privilege
//         }
//     }

//     return redirect()->back()->with('success', 'Privileges updated successfully.');
// });

// Route::put('/privileges/{id}',function($id){
//     request()->validate([
//         'privilege_name' => 'required|string|max:255',
//         'subprivileges' => 'array|nullable',
//     ]);

//     // Find the privilege
//     $privilege = Privilege::findOrFail($id);
//     $privilege->name = request()->input('privilege_name');
//     $privilege->save();

//     // Sync selected subprivileges
//     $privilege->subprivileges()->sync(request()->input('subprivileges', []));

//     return redirect()->route('privileges.index')->with('success', 'Privilege updated successfully');
// });




Route::get('/test', function () {
    $users = User::find(1001);

    return response()->json(['roles' => $users->roles, 'privilege' => $users->privileges]);
});

Route::post('/role', function () {
    $validatedData = request()->validate([
        'roleName' => 'required|unique:roles,name',
    ]);

    $role = DB::table('roles')->insert([
        'name' => request('roleName'),
        'created_at' => time(),
        'updated_at' => time(),
    ]);
    if (!$role)
        throw ValidationException::withMessages(['roleName' => 'failed to insert role']);

    return redirect('/roles_permissions');
});

Route::delete('/role', function () {
    $deletedrole = DB::table('roles')->where('id', request('roleName'))->delete();
    if (!$deletedrole)
        throw ValidationException::withMessages(['roleid' => 'failed to delete role']);
    return redirect('/roles_permissions');
});






Route::get('/timepass/course_create', function () {
    return view('create_course');
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

    return view('module.show', ['course' => $course, 'modules' => $course->modules]);
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

Route::post('create_roles_privileges', function () {

});

Route::get('/explore',function(){
    return view('explore.explore',['courses'=>Course::all()]);
});
Route::post('/rate-course/{course}',function(Course $course){
    $rating = new Rating();
    $rating->course_id = $course->id;
    $rating->user_id = request('user_id');
    $rating->stars = request('rating');
    $rating->stars = request('rating');
    $rating->comment = request('review');
    $res = $rating->save();
    if(!$res){
        return redirect('/course/watch/'.$course->id)->with('ratingfail', 'Failed to add rating!');
    }
    return redirect('/course/watch/'.$course->id)->with('success', 'rating added successfully');

    


});

Route::post('/mark-submodule-complete', function() {
    $markSubModuleComplete = CompletedSubModule::where('user_id', request('user_id'))
                                                ->where('course_id', request('course_id'))
                                                ->where('module_id', request('module_id'))
                                                ->where('submodule_id', request('submodule_id'))
                                                ->first();
    
    // Log current completion status
    // Log::info('Current Status: ' . $markSubModuleComplete->is_completed);

    // If no record exists, create a new entry
    if (!$markSubModuleComplete) {
        $markedSubModule = new CompletedSubModule();
        $markedSubModule->course_id = request('course_id');
        $markedSubModule->module_id = request('module_id');
        $markedSubModule->submodule_id = request('submodule_id');
        $markedSubModule->user_id = request('user_id');
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



Route::post('/update-watch-hours',function(){
    if(request('public_id') && request('duration')){
        $video = Video::where('public_id',request('public_id'))->first();
        $videoStats = new VideoStats();
        $videoStats->video_id = $video->id;
        $videoStats->watch_hours = request('duration');
        $res = $videoStats->save();
        if(!$res) {
            return response()->json('Failed to Add Video Stats',403);
        }
        return response()->json('Succesfully added the stats',200);
    }
});

