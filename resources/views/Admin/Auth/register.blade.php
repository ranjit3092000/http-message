<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>A T M | Registration Page</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo">
        <a href="../../index2.html"><b>A T M</b></a>
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Register</p>

            <form method="post" id="register" name="register" onsubmit="return false" enctype="multipart/form-data">
                @csrf
                <div class="form-group err_name">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Full name">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <span class="text-xs text-danger mt-2 errmsg_name"></span>
                </div>

                <!-- Email -->
                <div class="form-group err_email">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <span class="text-xs text-danger mt-2 errmsg_email"></span>
                </div>

                <!-- Password -->
                <div class="form-group err_password">
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <span class="text-xs text-danger mt-2 errmsg_password"></span>
                </div>

                <!-- Confirm Password -->
                <div class="form-group err_confirm_password">
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Retype password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <span class="text-xs text-danger mt-2 errmsg_confirm_password"></span>
                </div>

                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                            <label for="agreeTerms">
                                I agree to the <a href="#">terms</a>
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button id="saveUser" class="btn btn-primary btn-block">Register</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <a href="login.html" class="text-center">I already have a membership</a>
        </div>
        <!-- /.form-box -->
    </div>
    <!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#saveUser').on('click', function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var form = document.register; // Correct form reference
            var formData = new FormData(form);
            var url = "{{ route('store') }}";

            $.ajax({
                type: 'POST',
                url: url,
                processData: false,
                contentType: false,
                dataType: 'json',
                data: formData,
                dataSrc: "",
                success: function(data) {
                    if (data.status == 401) {
                        $.each(data.error1, function(index, value) {
                            $('.err_' + index + ' input').addClass('border border-danger');
                            $('.errmsg_' + index).text(value[0]); // Display error message
                        });
                    }
                    if (data.status == 1) {
                        console.log('Redirecting to:', data.redirect); // Log the redirect URL
                        window.location.href = data.redirect;
                    }
                },
                error: function(xhr, status, error) {
                    var errMsg = xhr.responseJSON;
                    if (errMsg.message == 'CSRF token mismatch.') {
                        location.reload();
                    }
                }
            });
        });
    });

</script>

<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>

