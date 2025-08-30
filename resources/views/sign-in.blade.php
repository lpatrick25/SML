<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Laundry Management System | Sign In</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />

    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="{{ asset('assets/css/core/libs.min.css') }}" />

    <!-- Hope Ui Design System Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/hope-ui.min.css?v=2.0.0') }}" />

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.min.css?v=2.0.0') }}" />

    <!-- Dark Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/dark.min.css') }}" />

    <!-- Customizer Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/customizer.min.css') }}" />

    <!-- RTL Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/rtl.min.css') }}" />

    <!-- Custom Styles for Laundry Theme -->
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #F5F6FA;
            margin: 0;
            overflow-x: hidden;
        }

        .login-content {
            background: linear-gradient(135deg, #4A90E2 0%, #F5F6FA 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .auth-card {
            background: #FFFFFF;
            border-radius: 16px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.15);
            padding: 2.5rem;
            max-width: 550px;
            width: 100%;
            margin: 1.5rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .auth-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        .logo-title {
            color: #333333;
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: 0.02em;
        }

        .form-control {
            border: 1px solid #D3DCE6;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: #4A90E2;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.15);
            outline: none;
        }

        .btn-primary {
            background-color: #4A90E2;
            border-color: #4A90E2;
            border-radius: 8px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: background-color 0.3s ease, transform 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary:hover {
            background-color: #357ABD;
            border-color: #357ABD;
            transform: translateY(2px);
        }

        .btn-primary:disabled {
            background-color: #6c757d;
            border-color: #6c757d;
            cursor: not-allowed;
        }

        .form-label {
            color: #333333;
            font-weight: 500;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .password-toggle {
            position: relative;
        }

        .password-toggle .toggle-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #4A90E2;
            transition: color 0.3s ease;
        }

        .password-toggle .toggle-icon:hover {
            color: #357ABD;
        }

        .sign-bg {
            position: absolute;
            bottom: 0;
            left: 0;
            z-index: -1;
            opacity: 0.5;
        }

        .sign-bg svg circle {
            fill: #4A90E2;
            opacity: 0.08;
        }

        .alert {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            display: none;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .spinner {
            display: none;
            width: 1.5rem;
            height: 1.5rem;
            border: 2px solid #ffffff;
            border-top: 2px solid transparent;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        @keyframes spin {
            0% {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        @media (max-width: 767px) {
            .auth-card {
                padding: 1.5rem;
                margin: 1rem;
            }

            .sign-bg {
                display: none;
            }

            .btn-primary {
                padding: 0.75rem 1.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- loader Start -->
    <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body"></div>
        </div>
    </div>
    <!-- loader END -->

    <div class="wrapper">
        <section class="login-content">
            <div class="row m-0 align-items-center vh-100">
                <div class="col-lg-12">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="card card-transparent shadow-none d-flex justify-content-center mb-0 auth-card">
                                <div class="card-body">
                                    <a href="#" class="navbar-brand d-flex align-items-center mb-4">
                                        <!-- Logo -->
                                        <div class="logo-main">
                                            <div class="logo-normal">
                                                <svg class="text-primary icon-40" viewBox="0 0 40 40" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="20" cy="20" r="18" fill="#4A90E2"
                                                        fill-opacity="0.1" />
                                                    <path
                                                        d="M20 10C15.58 10 12 13.58 12 18C12 22.42 15.58 26 20 26C24.42 26 28 22.42 28 18C28 13.58 24.42 10 20 10ZM20 23C17.24 23 15 20.76 15 18C15 15.24 17.24 13 20 13C22.76 13 25 15.24 25 18C25 20.76 22.76 23 20 23Z"
                                                        fill="#4A90E2" />
                                                    <path
                                                        d="M18 18C18 19.1 18.9 20 20 20C21.1 20 22 19.1 22 18C22 16.9 21.1 16 20 16C18.9 16 18 16.9 18 18Z"
                                                        fill="#357ABD" />
                                                    <path d="M20 14V12M20 24V22" stroke="#4A90E2" stroke-width="1.5" />
                                                </svg>
                                            </div>
                                        </div>
                                        <h4 class="logo-title ms-3">Laundry Management System</h4>
                                    </a>
                                    <h2 class="mb-2 text-center">Sign In</h2>
                                    <p class="text-center text-muted mb-4">Access your laundry management dashboard.</p>
                                    <div id="alert" class="alert"></div>
                                    <form id="login-form">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email"
                                                        name="email" placeholder="Enter your email" required>
                                                    <div class="invalid-feedback" id="email-error"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group password-toggle">
                                                    <label for="password" class="form-label">Password</label>
                                                    <input type="password" class="form-control" id="password"
                                                        name="password" placeholder="Enter your password" required>
                                                    <span class="toggle-icon" onclick="togglePassword()">
                                                        <svg width="20" height="20" viewBox="0 0 24 24"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M12 4.5C7 4.5 2.73 7.61 1 12C2.73 16.39 7 19.5 12 19.5C17 19.5 21.27 16.39 23 12C21.27 7.61 17 4.5 12 4.5ZM12 17C9.24 17 7 14.76 7 12C7 9.24 9.24 7 12 7C14.76 7 17 9.24 17 12C17 14.76 14.76 17 12 17ZM12 9C10.34 9 9 10.34 9 12C9 13.66 10.34 15 12 15C13.66 15 15 13.66 15 12C15 10.34 13.66 9 12 9Z"
                                                                fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                    <div class="invalid-feedback" id="password-error"></div>
                                                </div>
                                            </div>
                                            <div
                                                class="col-lg-12 d-flex justify-content-between align-items-center mt-3">
                                                <div class="form-check mb-0">
                                                    <input type="checkbox" class="form-check-input" id="remember"
                                                        name="remember">
                                                    <label class="form-check-label" for="remember">Remember Me</label>
                                                </div>
                                                <a href="#" class="text-primary">Forgot Password?</a>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mt-4">
                                            <button type="submit" class="btn btn-primary" id="login-btn">
                                                Sign In
                                                <span class="spinner"></span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sign-bg">
                        <svg width="300" height="250" viewBox="0 0 431 398" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g opacity="0.05">
                                <circle cx="100" cy="100" r="80" fill="#4A90E2" />
                                <circle cx="200" cy="200" r="100" fill="#357ABD" />
                                <circle cx="300" cy="150" r="60" fill="#4A90E2" fill-opacity="0.5" />
                                <circle cx="150" cy="300" r="70" fill="#4A90E2" fill-opacity="0.3" />
                            </g>
                        </svg>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Library Bundle Script -->
    <script src="{{ asset('assets/js/core/libs.min.js') }}"></script>

    <!-- External Library Bundle Script -->
    <script src="{{ asset('assets/js/core/external.min.js') }}"></script>

    <!-- Widgetchart Script -->
    <script src="{{ asset('assets/js/charts/widgetcharts.js') }}"></script>

    <!-- mapchart Script -->
    <script src="{{ asset('assets/js/charts/vectore-chart.js') }}"></script>
    <script src="{{ asset('assets/js/charts/dashboard.js') }}"></script>

    <!-- fslightbox Script -->
    <script src="{{ asset('assets/js/plugins/fslightbox.js') }}"></script>

    <!-- Settings Script -->
    <script src="{{ asset('assets/js/plugins/setting.js') }}"></script>

    <!-- Slider-tab Script -->
    <script src="{{ asset('assets/js/plugins/slider-tabs.js') }}"></script>

    <!-- Form Wizard Script -->
    <script src="{{ asset('assets/js/plugins/form-wizard.js') }}"></script>

    <!-- App Script -->
    <script src="{{ asset('assets/js/hope-ui.js') }}" defer></script>

    <!-- AJAX and Password Toggle Script -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-icon svg');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.innerHTML =
                    '<path d="M3.98 8.22C2.73 9.47 2 10.85 2 12C2 13.15 2.73 14.53 3.98 15.78M12 4.5C7 4.5 2.73 7.61 1 12C2.73 16.39 7 19.5 12 19.5M20.02 8.22C21.27 9.47 22 10.85 22 12C22 13.15 21.27 14.53 20.02 15.78M12 7C14.76 7 17 9.24 17 12C17 14.76 14.76 17 12 17C9.24 17 7 14.76 7 12C7 9.24 9.24 7 12 7M12 9C10.34 9 9 10.34 9 12C9 13.66 10.34 15 12 15C13.66 15 15 13.66 15 12C15 10.34 13.66 9 12 9Z" fill="currentColor"/>';
            } else {
                passwordInput.type = 'password';
                toggleIcon.innerHTML =
                    '<path d="M12 4.5C7 4.5 2.73 7.61 1 12C2.73 16.39 7 19.5 12 19.5C17 19.5 21.27 16.39 23 12C21.27 7.61 17 4.5 12 4.5ZM12 17C9.24 17 7 14.76 7 12C7 9.24 9.24 7 12 7C14.76 7 17 9.24 17 12C17 14.76 14.76 17 12 17ZM12 9C10.34 9 9 10.34 9 12C9 13.66 10.34 15 12 15C13.66 15 15 13.66 15 12C15 10.34 13.66 9 12 9Z" fill="currentColor"/>';
            }
        }

        $(document).ready(function() {
            $('#login-form').on('submit', function(e) {
                e.preventDefault();

                const $form = $(this);
                const $button = $('#login-btn');
                const $spinner = $button.find('.spinner');
                const $alert = $('#alert');

                // Clear previous errors
                $('#email-error').text('').hide();
                $('#password-error').text('').hide();
                $alert.removeClass('alert-success alert-danger').hide();

                // Show loading spinner
                $button.prop('disabled', true);
                $spinner.show();

                $.ajax({
                    url: '{{ route('login') }}',
                    type: 'POST',
                    data: $form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    success: function(response) {
                        var data = response.content;
                        // Store token in localStorage
                        localStorage.setItem('auth_token', data.token);

                        // Show success message
                        $alert.addClass('alert-success').text(response.message).show();

                        // Redirect to dashboard after a short delay
                        setTimeout(function() {
                            if (data.user.role === 'Admin') {
                                window.location.href =
                                    '/admin/dashboard'; // Adjust to your admin dashboard route
                                return;

                            }
                            window.location.href =
                            '/dashboard'; // Adjust to your dashboard route
                        }, 1000);
                    },
                    error: function(xhr) {
                        $button.prop('disabled', false);
                        $spinner.hide();

                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            if (errors.email) {
                                $('#email').addClass('is-invalid');
                                $('#email-error').text(errors.email[0]).show();
                            }
                            if (errors.password) {
                                $('#password').addClass('is-invalid');
                                $('#password-error').text(errors.password[0]).show();
                            }
                        } else {
                            $alert.addClass('alert-danger')
                                .text(xhr.responseJSON.message ||
                                    'An error occurred. Please try again.')
                                .show();
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
