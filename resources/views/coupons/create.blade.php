@component('layout')

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Create Coupon</h1>
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('coupons.store') }}" method="POST" class="bg-white shadow-lg rounded-lg p-8">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="coupon_code" class="block text-sm font-medium text-gray-700">Coupon Code</label>
                    <input type="text"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:outline-none focus:ring focus:ring-blue-500"
                        id="coupon_code" name="coupon_code" maxlength="6" required>
                </div>


                <div>
                    <label for="minimum_order_value" class="block text-sm font-medium text-gray-700">Minimum Order
                        Value</label>
                    <input type="number"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:outline-none focus:ring focus:ring-blue-500"
                        id="minimum_order_value" name="minimum_order_value">
                </div>

                <div>
                    <label for="max_discount_amount" class="block text-sm font-medium text-gray-700">Discount
                        Amount</label>
                    <input type="number" step="0.01"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:outline-none focus:ring focus:ring-blue-500"
                        id="max_discount_amount" name="discount_amount">
                </div>

                <div>
                    <label for="max_usage_limit" class="block text-sm font-medium text-gray-700">Max Usage Limit</label>
                    <input type="number"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:outline-none focus:ring focus:ring-blue-500"
                        id="max_usage_limit" name="max_usage_limit">
                </div>
                <div>
                    <label for="max_usage_limit" class="block text-sm font-medium text-gray-700">Max Usage Per User</label>
                    <input type="number"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:outline-none focus:ring focus:ring-blue-500"
                        id="max_usage_limit" name="max_usages_per_user">
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label for="valid_from" class="block text-sm font-medium text-gray-700">Valid From</label>
                    <input type="date"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:outline-none focus:ring focus:ring-blue-500"
                        id="valid_from" name="valid_from" required>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label for="valid_till" class="block text-sm font-medium text-gray-700">Valid Till</label>
                    <input type="date"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:outline-none focus:ring focus:ring-blue-500"
                        id="valid_till" name="valid_till" required>
                </div>
                <div class="isactive ">
                    <input type="checkbox" name="is_active" checked id="">
                    <label for="">IS Active (Default True)</label>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:outline-none focus:ring focus:ring-blue-500"
                        id="description" name="description" rows="3"></textarea>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label for="course_ids" class="block text-sm font-medium text-gray-700">Link Courses</label>
                    <select multiple
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:outline-none focus:ring focus:ring-blue-500"
                        name="course_ids[]" id="course_ids">
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-6 col-span-1 md:col-span-2">
                    <button type="submit"
                        class="w-full inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                        Create Coupon
                    </button>
                </div>
            </div>
        </form>
    </div>
@endcomponent
