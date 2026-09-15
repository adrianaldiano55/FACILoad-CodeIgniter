<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"rel="stylesheet">
    <style>
        body {
            background-color: #3b185f;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: -100px;
            left: -100px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, #ff007f 0%, rgba(255,0,127,0) 70%);
            border-radius: 50%;
        }

        body::after {
            content: '';
            position: absolute;
            bottom: -100px;
            right: -100px;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, #ff007f 0%, rgba(255,0,127,0) 70%);
            border-radius: 50%;
        }

        .login-wrapper {
            width: 100%;
            max-width: 900px;
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            z-index: 1;
        }

        .login-form-side {
            padding: 3rem 4rem;
        }

        .back-arrow {
            color: #6c757d;
            font-size: 1.2rem;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 2rem;
        }

        .login-title {
            font-weight: 700;
            color: #1a1a1a;
            font-size: 2rem;
        }

        .login-subtitle {
            color: #8c8c8c;
            font-size: 0.95rem;
        }

        .login-subtitle a {
            color: #ff6b4a;
            text-decoration: none;
        }

        .custom-input {
            border: none;
            border-bottom: 1px solid #e0e0e0;
            border-radius: 0;
            padding-left: 0;
            padding-bottom: 8px;
            color: #333;
            box-shadow: none !important;
            outline: none !important;
        }

        .custom-input:focus {
            border-color: #ff6b4a !important;
            box-shadow: none !important;
        }

        .custom-input::placeholder {
            color: #b0b0b0;
        }

        .form-check-input:focus {
            border-color: #ff6b4a !important;
            box-shadow: 0 0 0 0.25rem rgba(255, 107, 74, 0.25) !important;
        }

        .form-check-input:checked {
            background-color: #ff6b4a !important;
            border-color: #ff6b4a !important;
        }

        .form-check-label {
            color: #8c8c8c;
            font-size: 0.88rem;
        }

        .btn-gradient {
            background: linear-gradient(90deg, #ff9a3c, #ff4e00);
            border: none;
            color: #fff;
            border-radius: 50px;
            font-weight: 600;
            padding: 0.65rem 2.5rem;
            transition: opacity 0.2s, transform 0.2s;
        }

        .btn-gradient:hover {
            opacity: 0.95;
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-gmail {
            border: 1px solid #e0e0e0;
            border-radius: 50px;
            color: #555;
            font-weight: 500;
            padding: 0.65rem 1.5rem;
            background: #fff;
        }

        .btn-gmail:hover {
            background: #f8f9fa;
            color: #333;
        }

        .image-side {
            padding: 0;
            background-color: #2b1055;
            overflow: hidden;
        }

        .image-side img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="login-wrapper row g-0">
        
        <!-- Left Side: Form -->
        <div class="col-lg-6 col-md-7 login-form-side">
            <a href="#" class="back-arrow"><i class="bi bi-arrow-left"></i></a>
            
            <h2 class="login-title mb-2">Login</h2>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            <p class="login-subtitle mb-4">Please enter your login information or <a href="<?= site_url('register') ?>">click here</a> to registration</p>

                <form action="<?= site_url('login') ?>" method="post">
                    <?= csrf_field() ?>
                <div class="mb-4">
                    <input type="number" id="id" name="id" class="form-control custom-input" placeholder="Login ID" required>
                </div>
                <div class="mb-4">
                    <input type="email" id="email" name="email" class="form-control custom-input" placeholder="Email" required>
                </div>
                <div class="mb-4">
                    <input type="password" id="password" name="password" class="form-control custom-input" placeholder="Password" required>
                </div>
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">
                        Remember me
                    </label>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <button type="submit" class="btn btn-gradient">Log In</button>
                </div>
            </form>
        </div>

        <!-- Right Side: Image -->
        <div class="col-lg-6 col-md-5 d-none d-md-block image-side">
            <img src="https://picsum.photos/600/800" alt="Login Banner">
        </div>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>