<div class="dropdown dropdown-end">
    <label tabindex="0" class="btn btn-ghost btn-circle avatar">
        <div class="w-10 rounded-full">
            <x-gravatar :email="auth()->user()->email" />
        </div>
    </label>
    <ul tabindex="0" class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
        <li>
            <form class="p-0" action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-ghost btn-block text-red-600 normal-case" type="submit">Logout</button>
            </form>
        </li>
    </ul>
</div>
