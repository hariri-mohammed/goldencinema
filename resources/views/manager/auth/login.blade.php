<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-control" content="no-cache">

    <link rel="stylesheet" href="{{ asset('css/Manger_login.css') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <title>Manager Login</title>
    <style>
        /* Manager-specific styling */
        .manager-theme .switch-link {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 20px;
            border: 2px solid #fff;
            border-radius: 25px;
            transition: all 0.3s ease;
            display: inline-block;
            margin-top: 20px;
        }
        .manager-theme .switch-link:hover {
            background: #fff;
            color: #007bff;
            transform: translateY(-2px);
        }
    </style>
</head>

<body style="font-family: 'Times New Roman', Times, serif">

    <div class="main-box flex-column flex-lg-row manager-theme">
        <div class="img-box d-none d-lg-block">
            <img src="{{ asset('img/login_cofer.avif') }}" alt="">
        </div>
        <div class="form-box w-100 w-md-50">

            <form method="POST" action="{{ route('manager.login') }}">
                @csrf
                <div class="logo text-center mt-4">
                    <img src="{{ asset('img/Logo.PNG') }}" alt="">
                </div>
                <h1 class="text-white text-center">Manager Login</h1>
                <h5 class="text-white-50 text-center">Enter your Manager Credentials</h5>
                <div class="input-box">
                    <div class="form-group">
                        <input class="email form-control" type="email" name="email" placeholder="Enter Your Email"
                            required autofocus :value="old('email')" />
                        <i id="svg" class="fa fa-envelope fa-fw"></i>
                        @if ($errors->has('email'))
                            <div class="alert alert-danger">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        @endif

                    </div>
                </div>
                <div class="input-box">
                    <div class="form-group">
                        <input class="password form-control" type="password" name="password"
                            placeholder="Enter Your Password" minlength="8" maxlength="25"
                            pattern="[A-Za-z0-9!@#%^&_]+" title="( A-Z, a-z , 0-9 , ! , @ , # , % , ^ , & , _ )"
                            required />
                        <i id="svg" class="fa fa-key fa-fw"></i>
                        @if ($errors->has('password'))
                            <div id="alert" class="alert alert-danger ">
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                        @endif
                    </div>
                </div>

                <div class="btn-box text-center">
                    <input id="btn" type="submit" value="Log In" />
                </div>

                <div class="text-center">
                    <a href="{{ route('admin_login') }}" class="switch-link">
                        <i class="fa fa-exchange"></i> Switch to Admin Login
                    </a>
                </div>

                <script>
                    // إخفاء الرسالة الخاصة بالحذف بعد خمس ثوانٍ
                    document.addEventListener('DOMContentLoaded', function() {
                        setTimeout(function() {
                            var alerts = document.querySelectorAll('.alert');
                            alerts.forEach(function(alert) {
                                alert.style.display = 'none';
                            });
                        }, 5000); // 5000 milliseconds = 5 seconds
                    });
                </script>

            </form>
        </div>
    </div>

</body>

</html>
