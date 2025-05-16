<!DOCTYPE html>
<html>
<head>
    <title>Auth Page</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f3f4f6;
        }
        .container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }
        .card {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 25px 50px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
        }
        .tabs {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        .tabs button {
            flex: 1;
            padding: 0.75rem;
            border: none;
            background: #e5e7eb;
            color: #1f2937;
            font-weight: bold;
            cursor: pointer;
            border-radius: 0.5rem;
        }
        .tabs button.active {
            background: #2563eb;
            color: white;
        }
        form > div {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-bottom: 0.3rem;
            font-weight: 600;
            color: #374151;
        }
        input, select {
            width: 100%;
            padding: 0.75rem;
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
        }
        button.submit-btn {
            width: 100%;
            padding: 0.75rem;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-weight: bold;
        }
        button.submit-btn:hover {
            background: #1e40af;
        }
        .google-btn {
            width: 100%;
            margin-top: 1rem;
            padding: 0.75rem;
            background: #db4437;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: bold;
            cursor: pointer;
        }
        .google-btn:hover {
            background: #c23321;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="tabs">
            <button id="login-tab" class="active">Login</button>
            <button id="register-tab">Register</button>
        </div>

        @if(session('error'))
            <p class="error">{{ session('error') }}</p>
        @endif

        {{-- Login Form --}}
        <form id="login-form">
            <div>
                <label>Email</label>
                <input type="email" id="login-email" required>
            </div>
            <div>
                <label>Password</label>
                <input type="password" id="login-password" required>
            </div>
            <p id="login-error" class="error"></p>
            <button type="submit" class="submit-btn">Login</button>
            <a href="{{ route('google.redirect') }}">
                <button type="button" class="google-btn">Sign in with Google (Client only)</button>
            </a>
        </form>

        {{-- Register Form --}}
        <form id="register-form" method="POST" action="/register" style="display: none;">
            @csrf
            <div>
                <label>Name</label>
                <input type="text" name="name" required>
            </div>
            <div>
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div>
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <div>
                <label>Role</label>
                <select name="role" required>
                    <option value="" disabled selected>Choose role</option>
                    <option value="client">Client (can use Google)</option>
                    <option value="driver">Driver (email only)</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="submit-btn">Register</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    // Tab switching logic
    const loginTab = document.getElementById('login-tab');
    const registerTab = document.getElementById('register-tab');
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');

    loginTab.addEventListener('click', () => {
        loginTab.classList.add('active');
        registerTab.classList.remove('active');
        loginForm.style.display = 'block';
        registerForm.style.display = 'none';
    });

    registerTab.addEventListener('click', () => {
        registerTab.classList.add('active');
        loginTab.classList.remove('active');
        loginForm.style.display = 'none';
        registerForm.style.display = 'block';
    });

    // Login form submission
    document.getElementById('login-form').addEventListener('submit', async function (e) {
        e.preventDefault();

        const email = document.getElementById('login-email').value;
        const password = document.getElementById('login-password').value;
        const errorMsg = document.getElementById('login-error');

        try {
            const response = await axios.post('/login', {
                email,
                password
            });

            const data = response.data;

            // ✅ Case: Verified user
            if (data.token) {
                localStorage.setItem('token', data.token);
                errorMsg.textContent = '';

                const role = data.role;
                if (role === 'client') {
                    window.location.href = '/dashboard';
                } else if (role === 'driver') {
                    window.location.href = '/driver/dashboard';
                } else if (role === 'admin') {
                    window.location.href = '/admin/dashboard';
                } else {
                    errorMsg.textContent = 'Unknown role: ' + (role ?? 'undefined');
                }

            }
            // ⚠️ Case: Not verified client
            else if (data.not_verified) {
                localStorage.setItem('unverifiedEmail', email);
                window.location.href = `/verify?email=${encodeURIComponent(email)}`;
            }
            // ❌ Case: something else
            else {
                errorMsg.textContent = data.message || 'Login failed';
            }

        } catch (error) {
            const message = error.response?.data?.message || 'Login failed';
            errorMsg.textContent = message;
        }
    });
</script>
</body>
</html>
