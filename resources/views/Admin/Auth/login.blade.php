
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->
  <title>ATM | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>A T M</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg"><b>Log In</b></p>

                <form method="POST" id="admin_login" name="adminLogin" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group err_email">
                        <div class="input-group mb-3"> <input type="email" class="form-control" placeholder="Email" name="email">
                            
                        </div>
                        <span class="text-xs text-danger mt-2 errmsg_email"></span>
                    </div>
                    <div class="form-group err_password">
                        <div class="input-group mb-3"> <input type="password" name="password" class="form-control" placeholder="Password">
                            
                        </div> <!--begin::Row-->
                        <span class="text-xs text-danger mt-2 errmsg_password"></span>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="form-check"> <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"> <label class="form-check-label" for="flexCheckDefault">
                                Remember Me
                                </label> </div>
                        </div> <!-- /.col -->
                        <div class="col-4">
                            <div class="d-grid gap-2"> <button type="button" id="login_btn" class="btn btn-primary">Sign In</button> </div>
                        </div> <!-- /.col -->
                    </div> <!--end::Row-->
                </form>
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="{{ route('register') }}" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>

<script src=" {{ asset('/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <!-- <script src="../.."></script> -->
    <script src=" {{ asset('/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script>
        $('#login_btn').on('click', function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = document.adminLogin;
            var formData = new FormData(form);
            var url = '{{ route('loginredirect') }}';
            $.ajax({
                type: 'post',
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processData: false,
                contentType: false,
                dataType: 'json',
                data: formData,
                dataSrc: "",
                beforeSend: function() {
                    $('.loader').css('display', 'flex');
                },
                complete: function(data, status) {
                    $('.loader').css('display', 'none');
                },
                success: function(data) {
                    if (data.status == 401) {
                        $.each(data.error1, function(index, value) {
                            $('.err_' + index + ' input').addClass('border border-danger');
                            $('.errmsg_' + index).text(value);
                        });
                    }
                    if (data.status == 200) {
                        window.location.href = data.redirect;
                    }
                }
            });
        });
</script> 
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
</body>
</html>
