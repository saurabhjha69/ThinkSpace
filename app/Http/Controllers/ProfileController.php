<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserInfo as ModelsUserInfo;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }
    public function editProfile()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }
    public function updateProfile()
    {
        $validatedData = request()->validate([
            'firstname' => 'string|required',
            'lastname' => 'string|required',
            'phone_no' => 'string|required',
            'address' => 'string|required',
            'dob' => 'date|required',
            'gender' => 'required',
            'bio' => 'string|required',
            'profile_picture' => 'image|mimes:jpeg,png,jpg|max:10240',
            'education' => 'string|required',
            'work_experience' => 'string|nullable',
            'specialization' => 'string|nullable'
        ]);

        $user = Auth::user();

        $userInfo = $user->userinfo ? $user->userinfo :  new ModelsUserInfo();
        $userInfo->user_id = $user->id;
        $userInfo->firstname = $validatedData['firstname'];
        $userInfo->lastname = $validatedData['lastname'];
        $userInfo->phone_no = $validatedData['phone_no'];
        $userInfo->address = $validatedData['address'];
        $userInfo->bio = $validatedData['bio'];
        $userInfo->date_of_birth = $validatedData['dob'];
        $userInfo->gender = $validatedData['gender'];
        $userInfo->education = $validatedData['education'];
        $userInfo->specialization = $validatedData['specialization'];
        $userInfo->work_experience = $validatedData['work_experience'];
        if (request('social') && is_array(request('social'))) {
            $links = [];
            foreach (request('social') as $social_link) {
                array_push($links, $social_link);
            }
            // dd($links);
            $userInfo->social_links = json_encode($links);
        }
        $res = $userInfo->save();
        if(!$res){
            flash()->error('Failed to  Updated User Profile');
            return redirect()->route('profile.edit.profile');
        }
        flash()->success('Successfully Updated User Profile');
        return redirect()->route('profile.show');



        // $userInfo->save();

    }
    public function destroy() {}
    public function show()
    {
        return view('profile.show', ['user' => Auth::user()]);
    }
    public function editProfilePicture()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }
    public function updateProfilePicture()
    {
        $user = Auth::user();
        // dd(request());
        if (request()->hasFile('profile_picture')) {
            $image = request()->file('profile_picture')->getRealPath();
            $cloudPath = Cloudinary::upload($image, [
                'folder' => 'profile_pictures/' . $user->id . '/',
                'transformation' => [
                    'width' => 150,
                    'height' => 150,
                    'crop' => 'fill',
                ]
            ])->getSecurePath();
            if($user->userinfo){
                $res = $user->userinfo->update([
                    'profile_picture' => $cloudPath,
                    'profile_status' => 'complete'
                ]);
            }
            else {
                $userinfo = new ModelsUserInfo();
                $userinfo->profile_picture = $cloudPath;
                $userinfo->user_id = $user->id;
                $userinfo->profile_status = 'complete';
                $res = $userinfo->save();
            }
            if (!$res) {
                flash()->error('Profile Photo Upload Failed');
                return redirect()->route('profile.edit.photo');
            }
            flash()->success('Profile Photo Updated successfully');
            return redirect()->route('profile.edit.photo');
        }
        flash()->info('To Update Profile phooto choose a photo!');
        return redirect()->route('profile.edit.photo');
    }
    public function editProfileSettings()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }
    public function updateProfileSettings()
    {
        if(request('update_email')){
            $user = Auth::user();
            $user->email = request('email');
            $res = $user->save();

            if(!$res){
                flash()->error('Failed to Update Email');
                return redirect()->route('profile.edit.settings');
            }
            flash()->success('Successfully Updated Email');
                return redirect()->route('profile.edit.settings');
        }
        if(request('update_password')){
            $user = Auth::user();
            $validatedData = request()->validate([
                'current_password' => 'required',
                'password' => 'required|min:6|max:12|confirmed',
            ]);
            if(!Hash::check($validatedData['current_password'],$user->password)){
                session()->flash('fail','Wrong Old Password Given!');
                return redirect()->route('profile.edit.settings');
            }
            $user->password = bcrypt($validatedData['password']);
            $res = $user->save();

            if(!$res){
                flash()->error('Failed to Update Password');
                return redirect()->route('profile.edit.settings');
            }
            flash()->success('Successfully Updated Password');
                return redirect()->route('profile.edit.settings');
        }


    }
    public function instructorProfile(User $user){
        // $user = User::where('username',$username)->first();
        $courses = $user->createdCourses;
        return view('profile.instructor',['user' => $user,'courses' =>$courses]);
    }
}
