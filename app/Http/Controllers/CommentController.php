<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Course;
use App\Models\Module;
use App\Models\Submodule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function index(Submodule $submodule){
        $comments = $submodule->comments;
        return view('/course/watch/'.$submodule->module->course_id,['comments'=>$comments]);
    }
    
    public function store(){
        $submodule = Submodule::find(request('submodule_id'));
        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->course_id = $submodule->module->course_id;
        $comment->submodule_id = $submodule->id;
        $comment->comment = request('content');
        $res = $comment->save();
        if(!$res){
            flash()->error('Failed to add comment!','Please Try Again After Sometime');
        }
        else{
            flash()->success('Comment Added Successfully');
        }
        return redirect()->back();


    }

    public function update(Comment $comment){
        $comment->comment = request('comment');
        $res = $comment->save();
        if(!$res){
            flash()->error('Failed to update comment!','Please Try Again After Sometime');
        }
        else{
            flash()->success('Comment Updated Successfully');
        }
        return redirect()->back();

    }
    public function destroy(Comment $comment){
        $res = $comment->delete();
        if(!$res){
            flash()->error('Failed to delete comment!','Please Try Again After Sometime');
        }
        else{
            flash()->success('Comment Deleted Successfully');
        }
        return redirect()->back();
    }
}
