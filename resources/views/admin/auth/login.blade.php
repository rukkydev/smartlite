<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        .password-toggle {
            cursor: pointer;
            user-select: none;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
        .form-control.is-invalid {
            border-color: #dc3545;
        }
        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100 p-4">
    <div class="card shadow-sm p-4 w-100" style="max-width: 500px;">
        <div class="text-center mb-4">
            <h4 class="fw-bold"><i class="ri-lock-2-line me-2"></i>Admin Login</h4>
            <p class="text-muted small mt-2">Sign in to access the admin dashboard</p>
        </div>

        <!-- Alert placeholder -->
        <div id="alertBox" role="alert" aria-live="assertive"></div>

        <form id="loginForm" novalidate>
            @csrf
            <div class="mb-3 position-relative">
                <label for="email" class="form-label fw-medium">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" 
                       required autofocus aria-describedby="emailError" 
                       placeholder="Email Address">
                <div id="emailError" class="error-message d-none"></div>
            </div>

            <div class="mb-3 position-relative">
                <label for="password" class="form-label fw-medium">Password</label>
                <input type="password" id="password" name="password" class="form-control" 
                       required aria-describedby="passwordError">
                <i class="ri-eye-line password-toggle" onclick="togglePasswordVisibility()" 
                   aria-label="Show password"></i>
                <div id="passwordError" class="error-message d-none"></div>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" id="remember" name="remember" class="form-check-input">
                <label for="remember" class="form-check-label text-muted small">Remember me</label>
            </div>

            <button type="submit" id="loginBtn" class="btn btn-primary w-100 py-2">
                <span class="spinner-border spinner-border-sm d-none" id="spinner" role="status" aria-hidden="true"></span>
                <span id="btnText">Sign In</span>
            </button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('admin.password.request') }}" 
               class="text-primary small text-decoration-none">
                Forgot your password?
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle');
            const isPassword = passwordInput.type === 'password';
            
            passwordInput.type = isPassword ? 'text' : 'password';
            toggleIcon.classList.toggle('ri-eye-line', isPassword);
            toggleIcon.classList.toggle('ri-eye-off-line', !isPassword);
            toggleIcon.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
        }

        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const btn = document.getElementById('loginBtn');
            const spinner = document.getElementById('spinner');
            const btnText = document.getElementById('btnText');
            const alertBox = document.getElementById('alertBox');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const emailError = document.getElementById('emailError');
            const passwordError = document.getElementById('passwordError');

            // Reset states
            alertBox.innerHTML = '';
            emailError.classList.add('d-none');
            passwordError.classList.add('d-none');
            emailInput.classList.remove('is-invalid');
            passwordInput.classList.remove('is-invalid');

            // Client-side validation
            let hasError = false;
            if (!emailInput.value) {
                emailError.textContent = 'Email is required';
                emailError.classList.remove('d-none');
                emailInput.classList.add('is-invalid');
                hasError = true;
            } else if (!/\S+@\S+\.\S+/.test(emailInput.value)) {
                emailError.textContent = 'Invalid email format';
                emailError.classList.remove('d-none');
                emailInput.classList.add('is-invalid');
                hasError = true;
            }
            if (!passwordInput.value) {
                passwordError.textContent = 'Password is required';
                passwordError.classList.remove('d-none');
                passwordInput.classList.add('is-invalid');
                hasError = true;
            } else if (passwordInput.value.length < 8) {
                passwordError.textContent = 'Password must be at least 6 characters';
                passwordError.classList.remove('d-none');
                passwordInput.classList.add('is-invalid');
                hasError = true;
            }

            if (hasError) return;

            // Disable button + show spinner
            btn.disabled = true;
            spinner.classList.remove('d-none');
            btnText.textContent = 'Signing in...';

            try {
                const formData = new FormData(form);
                const response = await fetch("{{ route('admin.login.submit') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const result = await response.json();

                if (response.ok) {
                    alertBox.innerHTML = `
                        <div class="alert alert-success alert-dismissible text-sm fade show" role="alert">
                            <i class="ri-check-line me-2"></i>${result.message || 'Login successful! Redirecting...'}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                    setTimeout(() => window.location.href = "{{ route('admin.dashboard') }}", 1000);
                } else {
                    alertBox.innerHTML = `
                        <div class="alert alert-danger text-sm alert-dismissible fade show" role="alert">
                            <i class="ri-error-warning-line me-2"></i>${result.message || 'Invalid credentials'}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                    if (result.errors) {
                        if (result.errors.email) {
                            emailError.textContent = result.errors.email[0];
                            emailError.classList.remove('d-none');
                            emailInput.classList.add('is-invalid');
                        }
                        if (result.errors.password) {
                            passwordError.textContent = result.errors.password[0];
                            passwordError.classList.remove('d-none');
                            passwordInput.classList.add('is-invalid');
                        }
                    }
                }
            } catch (error) {
                alertBox.innerHTML = `
                    <div class="alert alert-danger text-sm alert-dismissible fade show" role="alert">
                        <i class="ri-alert-line me-2"></i>Network error. Please try again later.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
            } finally {
                // Reset button
                btn.disabled = false;
                spinner.classList.add('d-none');
                btnText.textContent = 'Sign In';
            }
        });
    </script>
</body>
</html>