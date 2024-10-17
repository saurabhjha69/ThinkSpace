<?php

namespace App\Http\Controllers;

use App\Jobs\UploadVideoToCloudinary;
use App\Models\Category;
use App\Models\Course;
use App\Models\Module;
use App\Models\Submodule;
use App\Models\Video;
use App\Models\VideoUploadLogs;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\AssignOp\Mod;

class ModuleController extends Controller
{
    public function index(Course $course){
        return view('module.index',['course'=> $course]);
    }

    public function create(){

    }

    public function store(){
        request()->validate([
            'module.*.title' => 'required',
            'course_id' => 'required'
        ]);

        $course = Course::find(request('course_id'));
        $counter = 0;
        if (request('module') && is_array(request('module'))) {
            foreach (request('module') as $index => $module) {
                $moduleInstance = new Module();
                $moduleInstance->course_id = $course->id;
                $moduleInstance->title = $module['title'];
                $moduleInstance->order = $index;
                $res = $moduleInstance->save();
                if (!$res) {
                    return redirect()->back()->with('fail', 'Failed to Add Module' . $module['title']);
                }
                $counter++;
            }
        }
        flash()->success('Successfully Added ' . $counter . ' Module');
        return redirect('course/' . $course->id . '/modules');
    }

    public function show($id){

    }

    public function edit(Module $module){
        return view('module.edit',['module' => $module]);
    }

    public function update(Module $module){
        // dd(request());
        request()->validate([
            'module_title' => 'required',
            'category_id' => 'required',
            'submodule.*.title' => 'required',
        ]);

        $module->title = request('module_title');

        if(request('submodule') && is_array(request('submodule'))){
            foreach(request('submodule') as $index => $submodule){

                $submoduleInstance = isset($submodule['id']) ? Submodule::find($submodule['id']) : new Submodule();

                $submoduleInstance->title = $submodule['title'];
                $submoduleInstance->order = $index;
                $submoduleInstance->module_id = $module->id;
                $submoduleInstance->save();
                if(isset($submodule['file'])){
                    $file = $submodule['file'];

                    $filename = $file->getClientOriginalName();
                    $path = 'M'.$module->id.'/S'.$submoduleInstance->id.'/'.$filename;
                    Storage::disk('local')->put($path, file_get_contents($file));
                    $filepath = storage_path('app/' . $path);

                    // Get full path to the stored file
                    $cloudinaryPath = 'LMS/Categories/' . Category::find(request('category_id'))->name . '/' . $module->course_id . '/modules/' . $module->id . '/submodules/' . $submoduleInstance->id . '/' . 'video/';
                    $videouploadlog = new VideoUploadLogs();
                    $videouploadlog->submodule_id = $submoduleInstance->id;
                    $videouploadlog->save();
                    UploadVideoToCloudinary::dispatch($filepath,$cloudinaryPath,$submoduleInstance->id,$videouploadlog->id,false);


            }
        }
        $module->save();
        flash()->success('Module Updated Successfully');
        return redirect('/modules/'.$module->id);
    }}

    public function destroy(){
        Module::where('course_id',request('course_id'))->where('id',request('module_id'))->delete();
        flash()->success('Module Deleted Successfully');
        return redirect('/course/'.request('course_id').'/modules');
    }
}
