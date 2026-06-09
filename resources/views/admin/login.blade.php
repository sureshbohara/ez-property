<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ setting('favicon_url') }}">
    <title>Admin Login</title>
    @include('layouts.admin.style')
</head>
<body>
<div class="wrapper">
    <main class="authentication-content">
        <div class="container-fluid">
            <div class="authentication-card">
                <div class="card shadow rounded-0 overflow-hidden">
                    <div class="row g-0">
          
                        <div class="col-lg-6 bg-light d-flex align-items-center justify-content-center">
                            <img src="{{ setting('logo_url') }}" 
                                 class="img-fluid" 
                                 alt="Logo" 
                                 style="width: 80%;">
                        </div>

         
                        <div class="col-lg-6">
                            <div class="card-body p-4 p-sm-5">
                                <h5 class="card-title">Sign In</h5>
                                <p class="card-text">See your growth and get consulting support!</p>
                                
                                <form class="form-body" 
                                      method="POST" 
                                      id="adminLoginForm"
                                      action="{{ route('admin.login.submit') }}">
                                    @csrf
                                    
                                    <div class="login-separater text-center mb-4">
                                        <span>SIGN IN WITH EMAIL</span>
                                        <hr>
                                    </div>
                                    
                                    <div class="row g-3">
                                      
                                        <div class="col-12">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" 
                                                   name="email" 
                                                   class="form-control radius-30 ps-5 @error('email') is-invalid @enderror" 
                                                   placeholder="Email Address" 
                                                   required
                                                   value="{{ old('email') }}">
                                            <span class="email-error text-danger small"></span>
                                        </div>

                                    
                                        <div class="col-12">
                                            <label class="form-label">Enter Password</label>
                                            <div class="position-relative">
                                                <input type="password" 
                                                       id="password" 
                                                       name="password" 
                                                       class="form-control radius-30 ps-5 @error('password') is-invalid @enderror" 
                                                       placeholder="Enter Password" 
                                                       required>
                                                <span class="passwordShow" 
                                                      onclick="togglePassword()" 
                                                      style="position: absolute; right: 15px; top: 38px; cursor: pointer;">
                                                    <i class="bi bi-eye-slash" id="eye"></i>
                                                </span>
                                            </div>
                                            <span class="password-error text-danger small"></span>
                                        </div>

                                       
                                        <div class="col-6">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="remember" 
                                                       id="rememberMe" 
                                                       value="1"
                                                       {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="rememberMe">
                                                    Remember Me
                                                </label>
                                            </div>
                                        </div>

                                        
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button type="submit" 
                                                        id="loginBtn"
                                                        class="btn btn-primary radius-30">
                                                    <span class="btn-text">Sign In</span>
                                                    <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

@include('layouts.admin.scripts')

<script>
    function togglePassword() {
        const pw = document.getElementById('password');
        const eye = document.getElementById('eye');
        if (pw.type === 'password') {
            pw.type = 'text';
            eye.className = 'bi bi-eye';
        } else {
            pw.type = 'password';
            eye.className = 'bi bi-eye-slash';
        }
    }

    $('#adminLoginForm').on('submit', function(e){
        e.preventDefault();
        let form = $(this);
        let btn = $('#loginBtn');
        let btnText = btn.find('.btn-text');
        let spinner = btn.find('.spinner-border');
        btn.prop('disabled', true);
        btnText.addClass('d-none');
        spinner.removeClass('d-none');
        $('.email-error, .password-error').text('').hide();
        $('.is-invalid').removeClass('is-invalid');
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res){
                if(res.success){
                    toastr.success(res.message || 'Login successful!');
                    setTimeout(function(){
                        window.location.href = res.redirect || '{{ route("admin.dashboard") }}';
                    }, 1000);
                } else {
                    handleErrors(res.errors);
                }
            },
            error: function(xhr){
                let res = xhr.responseJSON;
                if(res?.errors){
                    handleErrors(res.errors);
                }
                toastr.error(res?.message || 'Login failed. Please try again.');
            },
            complete: function(){
                // Re-enable button
                btn.prop('disabled', false);
                btnText.removeClass('d-none');
                spinner.addClass('d-none');
            }
        });
    });
    function handleErrors(errors){
        $.each(errors, function(field, messages){
            let errorSpan = $('.' + field + '-error');
            if(errorSpan.length){
                errorSpan.text(messages[0]).show();
                $('[name="'+field+'"]').addClass('is-invalid');
            }
        });
    }
</script>
</body>
</html>