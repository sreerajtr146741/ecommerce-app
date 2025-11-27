<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login • MyShop</title>

    <!-- Bootstrap 5 + Custom Styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .login-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            overflow: hidden;
            background: white;
        }
        .login-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .login-header h2 {
            margin: 0;
            font-weight: 600;
            letter-spacing: 1px;
        }
        .form-control {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 12px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            letter-spacing: 1px;
            transition: all 0.3s;
        }
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
        }
        .logo {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .alert {
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card login-card">
                <div class="login-header">
                    <div class="logo">
                        <img src="https://img.icons8.com/fluency/96/000000/shopping-cart-loaded.png" alt="Shop">
                    </div>
                    <h2>WELCOME BACK</h2>
                    <p class="mb-0 opacity-75">Login to manage your products</p>
                </div>

                <div class="card-body p-5">

                    <!-- SUCCESS MESSAGE -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <strong>Success!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- ERROR MESSAGES -->
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <strong>Oops!</strong> {{ $errors->first() }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label text-muted">Email Address</label>
                            <input type="email" name="email" class="form-control form-control-lg" 
                                   value="{{ old('email') }}" required autofocus placeholder="you@example.com">
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg" 
                                   required autocomplete="current-password" placeholder="Enter your password">
                        </div>

                        <!-- REMEMBER ME + DEFAULT CHECKED + FORGOT PASSWORD REMOVED -->
                        <div class="d-flex justify-content-start align-items-center mb-4">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" checked>
                                <label class="form-check-label text-muted fw-500" for="remember">
                                    Remember me <small class="text-success">(Stay logged in for 2 weeks)</small>
                                </label>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg btn-login text-white">
                                LOGIN TO MYSTORE
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted mb-0">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="text-decoration-none fw-bold" 
                               style="color: #667eea;">
                                Sign up free
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <p class="text-center text-white mt-4 opacity-75 small">
                © 2025 MyShop • All rights reserved
            </p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>