<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Multians extends Model
{
    use HasFactory;

    public function multianswer(){
        return $this->belongsTo(Multianswer::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
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
   
}
