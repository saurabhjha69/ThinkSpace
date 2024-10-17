<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Multianswer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
    public function correctAnswers()
    {
        // Initialize the array to hold correct answer numbers
        $correctNumbers = [];

        // Loop through choices 1 to 4
        for ($i = 1; $i <= 4; $i++) {
            // Use dynamic property access
            $choiceField = "choice" . $i;

            // Check if the current choice is correct (assuming 1 is the correct answer)
            if ($this->$choiceField != null) {
                array_push($correctNumbers, $i); // Add correct answer number to array
            }
        }

        // Return the array of correct answer numbers
        return $correctNumbers;
    }


    public function answeredMultians()
    {
        return $this->hasMany(Multians::class);
    }
    public function usersAnswer($id)
    {
        return $this->answeredMultians()->where('user_id', Auth::user()->id)->where('multianswer_id', $id)->first();
    }
}
