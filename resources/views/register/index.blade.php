<h2>Register</h2>

@if (session('success')) 
    <p>{{ session('success') }}</p>
@endif

@if ($errors->any()) 
    <p>{{ $errors->first() }}</p>    
@endif

<form method="POST" action="{{ route('register') }}">
    @csrf
    <label for="email">Email:</label>
    <input type="email" name="email" placeholder="Email" required>
    
    <label for="password">Password:</label>
    <input type="password" name="password" placeholder="Password" required>

    <label for="password_confirmation">Confirm Password:</label>
    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
    <button type="submit">Register</button>
</form>

<p>Sudah punya akun? <a href="{{ route('loginPage') }}">Login di sini</a></p>    