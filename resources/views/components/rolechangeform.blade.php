<form action="/switch-role" method="POST" id="switch-role-form">
    @csrf
    <select name="currentSignInRole" onchange="changeSessionRole(this)" id=""
        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
        @foreach (Auth::user()->roles as $role)
            <option value="{{ $role->name }}" {{ session()->get('user_role') === $role->name ? 'selected' : ' ' }}>
                {{ $role->name }}</option>
        @endforeach
    </select>

</form>
