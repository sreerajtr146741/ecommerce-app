<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>

<style>
    body {
        font-family: "Poppins", sans-serif;
        background: linear-gradient(135deg, #6DD5FA, #2980B9);
        height: 100vh;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .register-container {
        background: #fff;
        border-radius: 15px;
        padding: 40px 50px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        width: 380px;
        text-align: center;
        animation: fadeIn 0.8s ease;
    }

    h1 {
        margin-bottom: 20px;
        color: #333;
        font-size: 26px;
        letter-spacing: 1px;
    }

    input[type="text"],
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

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus {
        border-color: #2980B9;
        outline: none;
        box-shadow: 0 0 5px rgba(41,128,185,0.4);
    }

    button {
        width: 100%;
        background-color: #2980B9;
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
        background-color: #1F6392;
    }

    p {
        margin-top: 15px;
        color: #555;
        font-size: 14px;
    }

    a {
        color: #2980B9;
        text-decoration: none;
        font-weight: 600;
    }

    a:hover {
        text-decoration: underline;
    }

    p[style*="color:green"] {
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

<div class="register-container">
    <h1>Register</h1>
    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif
    <form action="{{ url('/register') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required><br>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="{{ url('/login') }}">Login here</a></p>
</div>

</body>
</html>
