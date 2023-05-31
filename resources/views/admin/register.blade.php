<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
</head>
<body>
    <h1>Admin Registration</h1>

    <form action="{{ route('admin.register') }}" method="post">
        @csrf
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" required>
        @error('name')
            <strong>{{ $message }}</strong>
        @enderror
        <br>

        <label for="loginid">loginid:</label>
        <input type="loginid" name="loginid" id="loginid" value="{{ old('loginid') }}" required>
        @error('loginid')
            <strong>{{ $message }}</strong>
        @enderror
        <br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        @error('password')
            <strong>{{ $message }}</strong>
        @enderror
        <br>

        <label for="password-confirm">Confirm Password:</label>
        <input type="password" name="password_confirmation" id="password-confirm" required>
        <br>

        <button type="submit">Register</button>
    </form>
</body>
</html>
