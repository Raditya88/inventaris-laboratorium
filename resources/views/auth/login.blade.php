<h3>Login Admin</h3>

@if(session('error'))
    <p style="color:red; font-style:italic;">
        {{ session('error') }}
    </p>
@endif

<form method="POST" action="/login">
    @csrf

    <input
        type="text"
        name="username"
        placeholder="Username"
        style="display:block; margin-bottom:10px; padding:6px;"
    >

    <input
        type="password"
        name="password"
        placeholder="Password"
        style="display:block; margin-bottom:10px; padding:6px;"
    >

    <button type="submit">Login</button>
</form>
