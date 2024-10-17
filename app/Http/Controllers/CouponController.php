<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::with('courses')->get(); // Eager load courses
        return view('coupons.index', compact('coupons'));
    }

    public function create()
    {
        $courses = Course::all(); // Fetch all courses to link to the coupon
        return view('coupons.create', compact('courses'));
    }

    public function store(Request $request)
    {
        // dd($request);
        // dd(Auth::id());
        $request->validate([
            'coupon_code' => 'required|string|max:6|unique:coupons',
            'minimum_order_value' => 'nullable|integer',
            'discount_amount' => 'nullable|numeric',
            'max_usage_limit' => 'nullable|integer',
            'max_usages_per_user' => 'nullable|integer',
            'valid_from' => 'required|date',
            'valid_till' => 'required|date|after:valid_from',
            'description' => 'nullable|string',
            'course_ids' => 'array', // The selected courses to link with the coupon
        ]);
        $coupon = new Coupon();
        $coupon->created_by = Auth::user()->id;
        $coupon->coupon_code = $request->coupon_code;
        $coupon->minimum_order_value = $request->minimum_order_value;
        $coupon->discount_amount = $request->discount_amount;
        $coupon->max_usage_limit = $request->max_usage_limit;
        $coupon->max_usages_per_user = $request->max_usages_per_user;
        $coupon->valid_from = $request->valid_from;
        $coupon->valid_till = $request->valid_till;
        $coupon->description = $request->description;
        $coupon->is_active = $request->is_active ? true : false;
        $coupon->save();
        // $coupon = DB::table('coupons')->insert([
        //     'created_by' => Auth::user()->id,
        //     'coupon_code' => $request->coupon_code,
        //     'discount_percentage' => $request->discount_percentage,
        //     'minimum_order_value' => $request->minimum_order_value,
        //     'max_discount_amount' => $request->max_discount_amount,
        //     'max_usage_limit' => $request->max_usage_limit,
        //     'max_usages_per_user' => $request->max_usages_per_user,
        //     'valid_from' => $request->valid_from,
        //     'valid_till' => $request->valid_till,
        //     'description' => $request->description,
        //     'is_active' => $request->is_active ? true : false,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);


        if ($request->has('course_ids')) {
            $coupon->courses()->sync($request->course_ids); // Sync selected courses
        }

        return response()->json(['Successfull',$coupon]);
    }

    public function edit(Coupon $coupon)
    {
        $courses = Course::all();
        return view('coupons.edit', compact('coupon', 'courses'));
    }

    public function report(Coupon $coupon){
        return view('analytics.coupon',['coupon' => $coupon]);
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:6|unique:coupons,coupon_code,' . $coupon->id,
            'discount_percentage' => 'nullable|numeric',
            'discount_amount' => 'nullable|numeric',
            'minimum_order_value' => 'nullable|integer',
            'max_discount_amount' => 'nullable|numeric',
            'max_usage_limit' => 'nullable|integer',
            'max_usages_per_user' => 'nullable|integer',
            'valid_from' => 'required|date',
            'valid_till' => 'required|date|after:valid_from',
            'applies_to' => 'nullable|json',
            'description' => 'nullable|string',
            'auto_apply' => 'boolean',
            'one_time_use' => 'boolean',
            'coupon_type' => 'required|in:percentage,fixed,free_shipping',
            'course_ids' => 'array',
        ]);

        $coupon->update($request->only([
            'coupon_code', 'discount_percentage', 'discount_amount', 'minimum_order_value',
            'max_discount_amount', 'max_usage_limit', 'max_usages_per_user', 'valid_from',
            'valid_till', 'applies_to', 'description', 'auto_apply', 'one_time_use', 'coupon_type'
        ]));

        if ($request->has('course_ids')) {
            $coupon->courses()->sync($request->course_ids); // Sync updated courses
        }

        return redirect()->route('coupons.index')->with('success', 'Coupon updated successfully');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('coupons.index')->with('success', 'Coupon deleted successfully');
    }

    public function linkCourse(Request $request, Coupon $coupon)
    {
        $request->validate(['course_ids' => 'required|array']);
        $coupon->courses()->sync($request->course_ids);
        return redirect()->back()->with('success', 'Courses linked to coupon successfully');
    }
}
