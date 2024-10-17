<?php

namespace App\Models;

use App\Helper\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Quiz extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function model(){
        return $this->belongsTo(Module::class);
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function mcqs(){
        return $this->hasMany(Mcq::class);
    }
    public function onelines(){
        return $this->hasMany(Oneline::class);
    }
    public function multians(){
        return $this->hasMany(Multianswer::class);
    }
    public function truefalse(){
        return $this->hasMany(Truefalse::class);
    }

    public function attemptedquizzes(){
        return $this->belongsToMany(User::class,'attemptedquizzes')->withPivot(['marks','created_at','total_correct_ans','total_attempted_ans']);
    }
    public function parseDateTime($dateTime){
        return Helper::formatDateTime($dateTime);
    }
    public function scorePercentage($obtained,$totalmarks){
        return round(Helper::calculatePercentage($obtained,$totalmarks));
    }
    public function isAttemped(){
        return $this->attemptedquizzes()->where('user_id',Auth::id())->where('quiz_id',$this->id)->exists();
    }
    public function userScore(){
        $attempedQuiz = $this->attemptedquizzes()->where('user_id',Auth::id())->where('quiz_id',$this->id)->select('marks')->first();
        return $attempedQuiz ? $attempedQuiz->marks : 0;
    }
    public function userWrongAttemptedAns(){
        return $this->attemptedquizzes()->where('user_id',Auth::id())->where('quiz_id',$this->id)->select('total_wrong_ans')->first();
    }
    public function userCorrectAttemptedAns(){
        return $this->attemptedquizzes()->where('user_id',Auth::id())->where('quiz_id',$this->id)->select('total_correct_ans')->first();
    }
    public function userTotalAttemptedAns(){
        return $this->attemptedquizzes()->where('user_id',Auth::id())->where('quiz_id',$this->id)->select('total_attempted_ans')->first();
    }


    public function questions() {
        // Fetching all question types with tagging, converting to array if they are collections
        $mcqs = array_map(fn($q) => ['type' => 'mcq', 'question' => $q], $this->mcqs->toArray());
        $onelines = array_map(fn($q) => ['type' => 'oneline', 'question' => $q], $this->onelines->toArray());
        $multians = array_map(fn($q) => ['type' => 'multians', 'question' => $q], $this->multians->toArray());
        $truefalse = array_map(fn($q) => ['type' => 'truefalse', 'question' => $q], $this->truefalse->toArray());

        // Merging and returning all questions
        $questions = array_merge($mcqs, $onelines, $multians, $truefalse);
        shuffle($questions); // Optional shuffle
        return $questions;
    }

    public function mcqAnswers($id){
        return $this->mcqs()->where('id',$id)->first()->answeredMcqs()->where('user_id',Auth::id())->first();
    }
    public function onelineAnswers($id){
        return $this->onelines()->where('id',$id)->first()->answeredOnelines()->where('user_id',Auth::id())->first();
    }
    public function multiansAnswers($id){
        return $this->multians()->where('id',$id)->first()->
        answeredMultians()->where('user_id',Auth::id())->first();
    }
    public function truefalseAnswers($id){
        return $this->truefalse()->where('id',$id)->first()->
        answeredTruefalseans()->where('user_id',Auth::id())->first();
    }


}
