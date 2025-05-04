<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f4f6;
        }

        .min-h-screen {
            min-height: 100vh;
        }

        .flex {
            display: flex;
        }

        .items-center {
            align-items: center;
        }

        .justify-center {
            justify-content: center;
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .w-full {
            width: 100%;
        }

        .max-w-md {
            max-width: 28rem;
        }

        .bg-white {
            background-color: white;
        }

        .shadow-2xl {
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
        }

        .rounded-2xl {
            border-radius: 1rem;
        }

        .p-8 {
            padding: 2rem;
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        .duration-300 {
            transition-duration: 300ms;
        }

        .text-2xl {
            font-size: 1.5rem;
        }

        .font-bold {
            font-weight: 700;
        }

        .text-center {
            text-align: center;
        }

        .text-gray-800 {
            color: #1f2937;
        }

        .mb-6 {
            margin-bottom: 1.5rem;
        }

        .space-y-4 > * + * {
            margin-top: 1rem;
        }

        label {
            font-weight: 600;
            display: block;
            margin-bottom: 0.5rem;
            color: #374151;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        input:focus {
            outline: none;
            border-color: #2563eb;
        }

        .text-red-600 {
            color: #dc2626;
        }

        .text-white {
            color: #fff;
        }

        .bg-blue-600 {
            background-color: #2563eb;
        }

        .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .rounded-lg {
            border-radius: 0.5rem;
        }

        .w-full {
            width: 100%;
        }

        button:hover {
            background-color: #1e40af;
        }
    </style>
</head>
<body>
<div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="bg-white shadow-2xl rounded-2xl p-8 w-full max-w-md transition-all duration-300">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login</h2>
        <form id="login-form" class="space-y-4">
            <div>
                <label>Email</label>
                <input type="email" id="email" required />
            </div>
            <div>
                <label>Password</label>
                <input type="password" id="password" required />
            </div>
            <p id="error-msg" class="text-red-600 text-center"></p>
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg">Login</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.getElementById('login-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const errorMsg = document.getElementById('error-msg');

    try {
        const response = await axios.post('/login', {
            email: email,
            password: password
        });
        console.log('Login successful:', response.data);
        const token = response.data.token;
        localStorage.setItem('token', token);

        errorMsg.textContent = '';
        if(response.data.role === 'admin') {
           // window.location.href = '/admin/dashboard';
        } else if(response.data.role === 'driver') {
            window.location.href = '/driver/dashboard';
        }
        else if(response.data.role === 'client') {
            window.location.href = '/dashboard';
        } else {
            errorMsg.textContent = 'Unauthorized role';
            return;
        }
       // window.location.href = '/dashboard';
    } catch (error) {
        console.error('Login error:', error.response);
        errorMsg.textContent = error.response?.data?.message || 'Login failed';
    }
});
</script>
</body>
</html>
