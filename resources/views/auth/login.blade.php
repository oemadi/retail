<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{namaToko()}} - Login</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ url('public/adminlte') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('public/adminlte') }}/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ url('public/adminlte') }}/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('public/adminlte') }}/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ url('public/adminlte') }}/plugins/iCheck/square/blue.css">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page" style="background:#fff">
    <div class="login-box">
        <div class="login-logo">
            <a href=""><img src="{{ url('public/asset_toko') }}/{{logo()}}" width="15%"> {{namaToko()}}</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body" style="background:#278DDF;border-radius:10px">
            <p class="login-box-msg">Sign in to start your session</p>
            @if (Session::has('message'))
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger">{{ Session::get('message') }}</div>
                </div>
            </div>
            @endif
            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="form-group has-feedback @error('username') has-error @enderror">
                    <input type="text" class="form-control" placeholder="username" name="username" id="username">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @error('username')
                    <label class="help-block error">{{ $message }}</label>
                    @enderror
                </div>
                <div class="form-group has-feedback @error('password') has-error @enderror">
                    <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @error('password')
                    <label class="help-block error">{{ $message }}</label>
                    @enderror
                </div>
				<div class="form-group has-feedback @error('branch') has-error @enderror">
					<select name="branch" id="branch" class="form-control">
                        <option value="">Pilih Cabang</option>
                        <option value="1">Depok</option>
									<option value="2">Cikarang</option>
                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
									</select>
                                    @error('branch')
                                    <label class="help-block error">{{ $message }}</label>
                                    @enderror
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-xs-4" style="float:right">
                        <button type="submit" class="btn btn-default btn-block btn-flat" style="color:blue;font-weight:bold;border-radius:5px">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
    </div>
    <script src="{{ url('public/adminlte') }}/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ url('public/adminlte') }}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="{{ url('public/adminlte') }}/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
    </script>
</body>

</html>
