<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->float('discount_percentage')->nullable();
            $table->float('discount_amount')->nullable();
            $table->timestamp('valid_from');
            $table->timestamp('valid_till');
            $table->string('coupon_code', 6);
            $table->text('description')->nullable();
            $table->integer('minimum_order_value')->nullable();
            $table->float('max_discount_amount')->nullable();
            $table->integer('max_usage_limit')->nullable();
            $table->integer('max_usages_per_user')->nullable();
            $table->integer('total_usage_count')->nullable()->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('coupon_course', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses', 'id')->cascadeOnDelete();
            $table->foreignId('coupon_id')->constrained('coupons', 'id')->cascadeOnDelete();
            $table->boolean('is_active')->default(true);
            $table->integer('usage_count')->nullable()->default(0);
            $table->integer('max_usages')->nullable();
            $table->unique(['course_id', 'coupon_id']);
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
