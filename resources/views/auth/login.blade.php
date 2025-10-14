<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>

<style>
    /* Page background and layout */
    body {
        font-family: "Poppins", sans-serif;
        background: linear-gradient(135deg, #74ABE2, #5563DE);
        height: 100vh;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Login box container */
    form, h1, p {
        margin: 0;
        padding: 0;
    }

    .login-container {
        background: #fff;
        border-radius: 15px;
        padding: 40px 50px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        width: 350px;
        text-align: center;
        animation: fadeIn 0.8s ease;
    }

    h1 {
        margin-bottom: 20px;
        color: #333;
        font-size: 26px;
        letter-spacing: 1px;
    }

    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    input[type="email"]:focus,
    input[type="password"]:focus {
        border-color: #5563DE;
        outline: none;
        box-shadow: 0 0 5px rgba(85,99,222,0.4);
    }

    button {
        width: 100%;
        background-color: #5563DE;
        color: white;
        border: none;
        padding: 12px;
        border-radius: 8px;
        font-size: 15px;
        cursor: pointer;
        margin-top: 10px;
        transition: background 0.3s ease;
    }

    button:hover {
        background-color: #3946C3;
    }

    p {
        margin-top: 15px;
        color: #555;
        font-size: 14px;
    }

    a {
        color: #5563DE;
        text-decoration: none;
        font-weight: 600;
    }

    a:hover {
        text-decoration: underline;
    }

    p[style*="color:red"] {
        font-size: 14px;
        margin-bottom: 10px;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
</head>
<body>

<div class="login-container">
    <h1>Login</h1>
    @if($errors->any())
        <p style="color:red">{{ $errors->first() }}</p>
    @endif
    <form action="{{ url('/login') }}" method="POST">
        @csrf
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="{{ url('/register') }}">Register here</a></p>
</div>

</body>
</html>
