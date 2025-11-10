<h2>Login</h2>

@if (session('loginError')) 
    <p>{{ session('loginError') }}</p> 
@endif
@if (session('success')) 
    <p>{{ session('success') }}</p> 
@endif

<form method="POST" action="/login">
    @csrf
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
<p>Belum punya akun? <a href="{{ route('registerPage') }}">Register di sini</a></p>