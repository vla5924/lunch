<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@lang('misc.login') | @lang('misc.lunch')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/theme/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="/theme/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/theme/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="/" class="h1"><b>@lang('misc.lunch')</b></a>
    </div>
    <div class="card-body">
      @include('components.form-alert')
      <p class="login-box-msg">Войдите, чтобы продолжить</p>
      <div class="social-auth-links text-center mt-2 mb-3">
        {!! Socialite::driver('telegram')->getButton() !!}
        <br />
        <br />
        <a href="{{ route('auth.yandex') }}" class="btn btn-danger">
            <i class="fab fa-yandex mr-2"></i> Войти через Яндекс
        </a>
      </div>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="/theme/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/theme/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/theme/dist/js/adminlte.min.js"></script>
</body>
</html>
