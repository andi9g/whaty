
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('plugins/fontawesome-free/css/all.min.css', []) }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ url('dist/css/adminlte.min.css', []) }}">
  <link rel="stylesheet" href="{{ url('yearpicker/dist/yearpicker.css', []) }}">
  <link rel="stylesheet" href="{{ url('select2/dist/css/select2.min.css', []) }}">
  <link rel="stylesheet" href="{{ url('dist/css/cssku.css', []) }}">

  <script src="{{ url('plugins/jquery/jquery.min.js', []) }}"></script>
  <script src="{{ url('yearpicker/dist/yearpicker.js', []) }}"></script>
  <script src="{{ url('select2/dist/js/select2.min.js', []) }}"></script>
</head>
<body class="hold-transition login-page">
<div class="login-box ">
  <div class="login-logo">
    <a href="../../index2.html"><b>Daftar Supplier</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card rounded">
    <div class="card-body login-card-body rounded">
      <p class="login-box-msg"><i>Sistem Informasi Penjualan Mobil</i></p>
      
      <form action="{{ route('proses.register') }}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input type="email" class="form-control @error('username')
            is-invalid
          @enderror" name="username" id="username" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span id="iconusername" class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="text" class="form-control @error('nama')
            is-invalid
          @enderror" name="nama" id="nama" placeholder="nama lengkap">
          <div class="input-group-append">
            <div class="input-group-text">
              <span id="iconnama" class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" class="form-control @error('password1')
          is-invalid
        @enderror" name="password1" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control @error('password2')
          is-invalid
        @enderror" name="password2" placeholder="Retype Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary btn-block">Daftar</button>
          </div>
        </div>
      </form>

      
      <p class="mb-0 text-center">
        <a href="{{ url('/', []) }}">Halaman Utama</a> | <a href="{{ url('login', []) }}" class="text-center link-primary">Halaman Login</a>
      </p>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- Bootstrap 4 -->
<script src="{{ url('plugins/bootstrap/js/bootstrap.bundle.min.js', []) }}"></script>
<!-- AdminLTE App -->
<script src="{{ url('dist/js/adminlte.min.js', []) }}"></script>


<script>
  function pilihposisi(data) {
    var posisi = data.value;
    var username = document.getElementById('username');
    var icon = document.getElementById('iconusername');

    if(posisi == "supplier") {
      username.type='email';
      username.placeholder='Email';
      icon.className="fas fa-envelope";
    }else if(posisi == "admin") {
      username.type='text';
      username.placeholder='Username';
      icon.className="fas fa-edit";
    }else {
      username.type='email';
      username.placeholder='Email';
      icon.className="fas fa-envelope";
    }
  }
</script>
@include('sweetalert::alert')

</body>
</html>
