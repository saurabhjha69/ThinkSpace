<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\ReappliedApprovals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    public function approveCourseEdit(Course $course){
        return view('admin.approval.course',compact('course'));
    }
    public function approveCourse(Course $course)
    {

        if(request('status') == 'Approve'){
            $course->approvalRequest()->update([
                'user_id' => Auth::id(),
                'status' => 'approved',
                'reason' => request('reason') ? request('reason') : null,
            ]);
            DB::table('course_approval_logs')->insert([
                'course_id' => $course->id,
                'user_id' => Auth::id(),
                'reason' => request('reason') ? request('reason') : null,
                'status' => 'approved',
                'created_at' => now(),
            ]);
            flash()->success('Successfully Approved The Course');
            return redirect()->back();
        }
        if(request('status') == 'Reject'){
            $course->approvalRequest()->update([
                'user_id' => Auth::id(),
                'status' => 'rejected',
                'reason' => request('reason') ? request('reason') : null,
            ]);
            DB::table('course_approval_logs')->insert([
                'course_id' => $course->id,
                'user_id' => Auth::id(),
                'reason' => request('reason') ? request('reason') : null,
                'status' => 'rejected',
                'created_at' => now(),
            ]);
            flash()->success('Successfully Rejected The Course');
            return redirect()->back();
        }
        flash()->info('Course Status is Still Pending');
        return redirect()->back();


    }
    public function settings(){
        return view('admin.settings.index');
    }
}
