<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterVideoIdNullableInSubmodulesTable extends Migration
{
    public function up()
    {
        Schema::table('submodules', function (Blueprint $table) {
            $table->unsignedBigInteger('video_id')->nullable()->change(); // Make the column nullable
        });
    }

    public function down()
    {
        Schema::table('submodules', function (Blueprint $table) {
            $table->unsignedBigInteger('video_id')->nullable(false)->change(); // Revert to non-nullable if needed
        });
    }
}
