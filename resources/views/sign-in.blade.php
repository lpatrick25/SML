<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laundry Management System | Sign In</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <style>
        .password-toggle {
            cursor: pointer;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>Laundry</b> Management System</a>
            </div>
            <div class="card-body">
                <!-- Alert Placeholder -->
                <div id="alert" class="alert d-none"></div>

                <p class="login-box-msg">Access your laundry management dashboard.</p>

                <form id="login-form" action="#" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email"
                            required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        <div id="email-error" class="invalid-feedback d-block" style="display:none;"></div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" id="password" name="password" class="form-control"
                            placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text password-toggle" onclick="togglePassword()">
                                <span id="toggle-icon" class="fas fa-eye"></span>
                            </div>
                        </div>
                        <div id="password-error" class="invalid-feedback d-block" style="display:none;"></div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember"> Remember Me </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" id="login-btn" class="btn btn-primary btn-block">
                                <span class="spinner-border spinner-border-sm mr-1" style="display:none;"></span>
                                Sign In
                            </button>
                        </div>
                    </div>
                </form>

                <p class="mb-1 mt-3">
                    {{-- <a href="{{ route('password.request') }}">I forgot my password</a> --}}
                </p>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggle-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        $(document).ready(function() {
            $('#login-form').on('submit', function(e) {
                e.preventDefault();

                const $form = $(this);
                const $button = $('#login-btn');
                const $spinner = $button.find('.spinner-border');
                const $alert = $('#alert');

                $('#email-error, #password-error').text('').hide();
                $alert.removeClass('alert-success alert-danger').addClass('d-none');

                $button.prop('disabled', true);
                $spinner.show();

                $.ajax({
                    url: '{{ route('login') }}',
                    type: 'POST',
                    data: $form.serialize(),
                    success: function(response) {
                        var data = response.content;
                        localStorage.setItem('auth_token', data.token);

                        $alert.removeClass('d-none').addClass('alert-success').text(response
                            .message);

                        setTimeout(function() {
                            if (data.user.role === 'Admin') {
                                window.location.href = '/admin/dashboard';
                                return;
                            }
                            if (data.user.role === 'Staff') {
                                window.location.href = '/staff/dashboard';
                                return;
                            }
                            window.location.href = '/dashboard';
                        }, 1000);
                    },
                    error: function(xhr) {
                        $button.prop('disabled', false);
                        $spinner.hide();

                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            if (errors.email) {
                                $('#email-error').text(errors.email[0]).show();
                            }
                            if (errors.password) {
                                $('#password-error').text(errors.password[0]).show();
                            }
                        } else {
                            $alert.removeClass('d-none').addClass('alert-danger')
                                .text(xhr.responseJSON.message ||
                                    'An error occurred. Please try again.');
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
