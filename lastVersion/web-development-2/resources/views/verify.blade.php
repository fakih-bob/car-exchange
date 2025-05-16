<!DOCTYPE html>
<html>
<head><title>Verify Email</title></head>
<body>
    <h2>Enter OTP to Verify Email</h2>
    @if(session('error')) <p style="color:red">{{ session('error') }}</p> @endif
    @if(session('success')) <p style="color:green">{{ session('success') }}</p> @endif

    <form method="POST" action="{{ route('verify.otp') }}">
        @csrf
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>OTP:</label><br>
        <input type="text" name="otp" required><br><br>

        <button type="submit">Verify</button>
    </form>
</body>
</html>
