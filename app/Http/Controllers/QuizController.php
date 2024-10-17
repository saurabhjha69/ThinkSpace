<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Mcq;
use App\Models\Multianswer;
use App\Models\Oneline;
use App\Models\Quiz;
use App\Models\Truefalse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class QuizController extends Controller
{
    public function index()
    {

        $quizs = Quiz::when(request('search'),function($query){
            $query->where('title', 'like', '%' . request('search') . '%');
        })
        ->when(request('quizFilterByCourse') && request('quizFilterByCourse')!='All',function($query){
            $query->where('course_id', request('quizFilterByCourse'));
        })
        ->when(request('orderBy'), function ($query) {
            if (request('orderBy') == 'Oldest') {
                $query->orderBy('created_at', 'asc');
            }
            if (request('orderBy') == 'Newest') {
                $query->orderBy('created_at', 'desc');
            }
        })
        ->when(request('orderBy'),function($query){
            $query->withCount('attemptedquizzes')
            ->orderBy('attemptedquizzes_count', 'desc');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        $coursesWithQuiz = Course::whereHas('quizzes')->get();

        return view('quiz.index', ['quizzes' => $quizs, 'courses' => $coursesWithQuiz]);
    }

    public function create()
    {
        return view('quiz.create');
    }

    public function store()
    {
        // dd(request());
        request()->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        $quizid = random_int(99, 99999999);
        $quiz = new Quiz();
        $quiz->id = $quizid;
        $quiz->user_id = Auth::user()->id;
        $quiz->title = request('title');
        $quiz->des = request('description');
        $quiz->save();
        $total_marks = 0;


        if (request('ques') && is_array(request('ques'))) {
            foreach (request('ques') as $type => $questions) {
                foreach ($questions as $index => $question) {
                    if ($type === 'truefalse') {
                        $trueorfalse = new Truefalse();
                        $trueorfalse->question = $question['question'];
                        $trueorfalse->ans = (int)$question['ans'];
                        $trueorfalse->quiz_id = $quizid;
                        $trueorfalse->marks = $question['marks'];
                        $total_marks += (int)$question['marks'];
                        $trueorfalse->save();
                    }
                    if ($type === 'oneline') {
                        $onelineClass = new Oneline();
                        $onelineClass->question = $question['question'];
                        $onelineClass->ans = $question['ans'];
                        $onelineClass->quiz_id = $quizid;
                        $onelineClass->marks = $question['marks'];
                        $total_marks += (int)$question['marks'];
                        $onelineClass->save();
                    }
                    if ($type === 'mcq') {
                        $mcqClass = new Mcq();
                        $mcqClass->question = $question['question'];

                        if (isset($question['opt']) && is_array($question['opt'])) {
                            foreach ($question['opt'] as $key => $opt) {
                                $mcqClass->{'option' . $key} = $opt;
                            }
                        }

                        $mcqClass->ans = $question['ans'];
                        $mcqClass->quiz_id = $quizid;
                        $mcqClass->marks = $question['marks'];
                        $total_marks += (int)$question['marks'];
                        $mcqClass->save();
                    }
                    if ($type === 'multians') {
                        $multiansClass = new Multianswer();
                        $multiansClass->question = $question['question'];

                        if (isset($question['choice']) && is_array($question['choice'])) {
                            foreach ($question['choice'] as $key => $choice) {
                                if ($choice != null) {
                                    $multiansClass->{'choice' . $key} = $choice;
                                }
                            }
                        }
                        if (isset($question['opt']) && is_array($question['opt'])) {
                            foreach ($question['opt'] as $key => $opt) {
                                $multiansClass->{'option' . $key} = $opt;
                            }
                        }

                        $multiansClass->quiz_id = $quizid;
                        $multiansClass->marks = $question['marks'];
                        $total_marks += (int)$question['marks'];
                        $multiansClass->save();
                    }
                }
            }
        }
        $quiz->total_marks = $total_marks;
        $res = $quiz->save();
        if (!$res) {
            flash()->error('Something Went Wrong!');
            return redirect('/quizs');
        }



        flash()->success('Quiz Created Successfully');
        return redirect('/quizs');
    }

    public function show(Quiz $quiz)
    {

        return view('quiz.show', ['quiz' => $quiz]);
    }

    public function edit(Quiz $quiz)
    {
        return view('quiz.edit', ['quiz' => $quiz]);
    }

    public function update(Quiz $quiz)
    {
        if (request('ques') && is_array(request('ques'))) {
            foreach (request('ques') as $type => $questions) {
                foreach ($questions as $index => $question) {
                    if ($type === 'truefalse') {
                        $trueorfalse = new Truefalse();
                        $trueorfalse->question = $question['question'];
                        $trueorfalse->ans = (int)$question['ans'];
                        $trueorfalse->quiz_id = $quiz->id;
                        $trueorfalse->save();
                    }
                    if ($type === 'oneline') {
                        $onelineClass = new Oneline();
                        $onelineClass->question = $question['question'];
                        $onelineClass->ans = $question['ans'];
                        $onelineClass->quiz_id = $quiz->id;
                        $onelineClass->save();
                    }
                    if ($type === 'mcq') {
                        $mcqClass = new Mcq();
                        $mcqClass->question = $question['question'];

                        if (isset($question['opt']) && is_array($question['opt'])) {
                            foreach ($question['opt'] as $key => $opt) {
                                $mcqClass->{'option' . $key} = $opt;
                            }
                        }

                        $mcqClass->ans = $question['ans'];
                        $mcqClass->quiz_id = $quiz->id;
                        $mcqClass->save();
                    }
                    if ($type === 'multians') {
                        $multiansClass = new Multianswer();
                        $multiansClass->question = $question['question'];

                        if (isset($question['choice']) && is_array($question['choice'])) {
                            foreach ($question['choice'] as $key => $choice) {
                                if ($choice != null) {
                                    $multiansClass->{'choice' . $key} = $choice;
                                }
                            }
                        }
                        if (isset($question['opt']) && is_array($question['opt'])) {
                            foreach ($question['opt'] as $key => $opt) {
                                $multiansClass->{'option' . $key} = $opt;
                            }
                        }

                        $multiansClass->quiz_id = $quiz->id;
                        $multiansClass->save();
                    }
                }
            }
        }
        return redirect('quiz/' . $quiz->id);
    }

    public function destroy(Quiz $quiz)
    {
        try{
            $quiz->truefalse()->delete();
        $quiz->onelines()->delete();
        $quiz->mcqs()->delete();
        $quiz->multians()->delete();

        // Then delete the quiz itself
        $quiz->delete();
        // Flash a success message
        flash()->success('Quiz Deleted Successfully');

        // Redirect to the quiz page
        return redirect('quizs');
        }
        catch(\Exception $e){
            throw ValidationException::withMessages([
                'fail' => $e->getMessage()
            ]);
            return redirect('/quizs');
        }


    }
}
