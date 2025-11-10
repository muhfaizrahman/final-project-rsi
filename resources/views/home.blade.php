<h1>Ini homepage</h1>

<a href="{{ route('loginPage') }}">Login</a>
<a href="{{ route('registerPage') }}">Register</a>
<form action="{{ route('logout') }}" method="POST" style="display:inline;">
    @csrf
    <button type="submit">Logout</button>
</form>