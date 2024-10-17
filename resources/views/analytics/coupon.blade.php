@component('layout')
    <section>
        <div class="stats grid grid-cols-4 gap-20 mt-10">
            <x-statsbox topic="Total Uses" value="{{ $coupon?->usersUsed()->count}}"></x-statsbox>
            <x-statsbox topic="Total Ratings" value="{{ $course->ratings->count() }}"></x-statsbox>
            <x-statsbox topic="Learners Watch Hour"
                value="{{ App\Helper\Helper::secondsToHoursMinutes($course->courseWatchHours()) }}"></x-statsbox>
            <x-statsbox topic="Total Revenue" value="${{ $course?->totalSales() }}"></x-statsbox>
        </div>
    </section>
    <section>
        <div class="chart bg-white  rounded-lg mt-10 p-5">
            {!! $subModuleWatchHoursChart->container() !!}
        </div>
    </section>
    <section>
        <div class="table-rapper overflow-x-auto bg-white border border-gray-300 rounded-md mt-10">
            <h1 class="p-4 text-center font-bold">Enrolled Students</h1>
            @foreach ($errors->all() as $error)
                <li class="text-red-500 text-2xl">{{ $error }}</li>
            @endforeach
            <table class="min-w-full table-auto ">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 border-b font-semibold text-left">Username</th>
                        <th class="px-6 py-3 border-b font-semibold text-left">Email</th>
                        <th class="px-6 py-3 border-b font-semibold text-left">Progress</th>
                        <th class="px-6 py-3 border-b font-semibold text-left">Role</th>
                        <th class="px-6 py-3 border-b font-semibold text-left">Enrolled At</th>
                        <th class="px-6 py-3 border-b font-semibold text-center"></th>
                    </tr>
                </thead>
                <tbody id="userTable">
                    @foreach ($course->users as $user)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $user?->username }}
                                @if ($user->isEnrolledByAdmin($user->id,$course->id))
                                    <small
                                        class="bg-purpolis/20 border border-purpolis/45 font-bold ml-5 text-purpolis py-1 px-2 text-[10px] rounded-full ">
                                        Enrolled By Admin
                                    </small>
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ $user?->email }}</td>
                            <td class="px-6 py-4">{{ $course->userCompletedSubModules($user->id) }}%</td>
                            <td class="px-6 py-4">
                                @if ($user->roles->count() <= 1)
                                    <span class="pl-1"> {{ $user?->roles?->first()->name ?? 'No Role' }}</span>
                                @else
                                    <select name="roles" id="">
                                        @foreach ($user?->roles as $role)
                                            <option value="">{{ $role?->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </td>

                            <td class="px-6 py-4">{{ App\Helper\Helper::formatDateTime($user?->pivot?->enrolled_at) }}</td>
                            <td class="px-6 py-4 flex gap-4">
                                <a href="/user/{{ $user?->id }}">
                                    <x-svgs.visit></x-svgs.visit>
                                </a>
                                @if (Gate::allows('isAdmin'))
                                    <a href="/user/edit/{{ $user?->id }}">
                                        <x-svgs.edit></x-svgs.edit>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    {{ $subModuleWatchHoursChart->script() }}
@endcomponent
