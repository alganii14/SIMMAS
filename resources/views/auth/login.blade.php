<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
    /* Reset styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    /* Background styling */
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: url('/img/1325726.png') no-repeat center center/cover;
        color: #fff;
    }

    /* Login container styling */
    .login-container {
        background: rgba(0, 0, 0, 0.8);
        padding: 40px;
        width: 300px;
        border-radius: 10px;
        text-align: center;
    }

    .login-container img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin-bottom: 20px;
    }

    .login-container h2 {
        color: #fff;
        margin-bottom: 20px;
        font-size: 24px;
    }

    .login-container input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        background: #333;
        border: none;
        border-bottom: 2px solid #555;
        color: #fff;
    }

    .login-container input:focus {
        outline: none;
        border-bottom: 2px solid #fff;
    }

    .login-container button {
        width: 100%;
        padding: 10px;
        background: #555;
        border: none;
        border-radius: 20px;
        color: #fff;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .login-container button:hover {
        background: #777;
    }

    .login-container a {
        display: block;
        color: #fff;
        text-decoration: none;
        margin-top: 10px;
    }

    .login-container a:hover {
        text-decoration: underline;
    }

    /* Error message styling */
    .alert {
        color: #ff6b6b;
        font-size: 14px;
        margin-bottom: 15px;
        text-align: left;
    }

    /* Show password checkbox container */
    .show-password-container {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        margin-top: 10px;
    }

    /* Adjust checkbox and label for better alignment */
    .show-password-container input {
        margin-right: 8px;
        width: auto;
    }

    .show-password-container label {
        color: #fff;
        font-size: 14px;
    }
    </style>
</head>

<body>
    <div class="login-container">
        <!-- Profile icon -->
        <img src="/img/logo.png" alt="User Icon">

        <!-- Login heading -->
        <h2>Login here</h2>

        <!-- Display validation errors -->
        @if ($errors->any())
        <div class="alert">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Login form -->
        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <input type="email" placeholder="Email" name="email" required>
            <input type="password" placeholder="Password" name="password" id="password" required>

            <!-- Show password toggle -->
            <div class="show-password-container">
                <input type="checkbox" id="showPassword">
                <label for="showPassword">Show Password</label>
            </div>

            <button type="submit">Login</button>
        </form>
    </div>

    <script>
    // Toggle password visibility
    document.getElementById('showPassword').addEventListener('change', function() {
        var passwordField = document.getElementById('password');
        if (this.checked) {
            passwordField.type = 'text';
        } else {
            passwordField.type = 'password';
        }
    });
    </script>
</body>

</html>