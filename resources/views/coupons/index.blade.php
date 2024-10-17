@component('layout')

<div class="table-rapper mt-10 bg-white border border-gray-300 rounded-xl shadow-lg">

    <table class="min-w-full table-auto ">
        <thead class="">
            <tr>
                <th class="px-6 py-3 border-b font-semibold text-left">CODE</th>
                <th class="px-6 py-3 border-b font-semibold text-center">DISCOUNT</th>
                <th class="px-4 py-3 border-b font-semibold text-left">USED</th>
                <th class="px-4 py-3 border-b font-semibold text-center">COURSES</th>
                <th class="px-4 py-3 border-b font-semibold text-left">IS_ACTIVE</th>
                <th class="px-6 py-3 border-b font-semibold text-center"></th>
            </tr>
        </thead>
        <tbody id="userTable">
            @foreach ($coupons as $coupon)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-extrabold text-xs cursor-copy">{{$coupon->coupon_code}}</td>
                    <td class="px-4 py-4 text-center">${{$coupon->discount_amount}}</td>
                    {{-- <td class="px-4 py-4 text-center">{{$course->lectures('f')>1 ? $course->queuedSubModules().' Queued' : $course->lectures('f')}}</td> --}}
                    <td class="px-4 py-4">{{$coupon->total_usage_count}}/{{$coupon->max_usage_limit}}</td>
                    <td class="px-4 py-4 text-center">{{$coupon->courses->count()}}</td>

                    <td class="px-4 py-4 ">
                        <span class="bg-purpolis py-1 px-4 rounded-full text-white text-xs">{{$coupon->is_active == 1 ? 'Active' : 'Expired'}}</span>
                    </td>

                    <td class="px-2 py-4 text-purpolis">
                        <div class="div flex gap-2">
                            <a href="coupon/edit/{{$coupon->id}}">
                                <x-svgs.edit></x-svgs.edit>
                            </a>
                            @if (Gate::allows('isAdmin'))
                            <a href="coupon/delete/{{$coupon->id}}">
                                <x-svgs.delete></x-svgs.delete>
                            </a>
                            @endif
                        </div>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>



@endcomponent
