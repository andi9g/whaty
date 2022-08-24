
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sistem Informasi Inventarisasi</title>
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
  
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="sidebar-mini sidebar-closed text-sm">
  
  <div class="modal fade" id="resetPassword" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ubah Password</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <form action="{{ route('password.ubah') }}" method="post">
          @csrf
        <div class="modal-body">
          <div class="form-group row">
            <label for="inputPassword1" class="col-sm-3 col-form-label">Password Baru</label>
            <div class="col-sm-9">
              <input type="password" class="form-control" onkeyup="cek()" name="password1" id="inputPassword1" placeholder="password baru">
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword2" class="col-sm-3 col-form-label">Ulangi Password</label>
            <div class="col-sm-9">
              <input type="password" class="form-control" onkeyup="cek();" name="password2" id="inputPassword2" placeholder="ulangi password baru">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Ubah Password</button>
        </div>
      </form>
      </div>
    </div>
  </div>


  <script>
    function cek(){
        var pass1 = document.getElementById('inputPassword1').value;
        var pass2 = document.getElementById('inputPassword2').value;

        if(pass1.length >=5 ){
                document.getElementById('inputPassword1').className="form-control";
            if(pass1 == pass2){
                document.getElementById('inputPassword1').className="form-control is-valid";
                document.getElementById('inputPassword2').className="form-control is-valid";
            }else if(pass2.length == 0){
                document.getElementById('inputPassword2').className="form-control";

            }else {
                 document.getElementById('inputPassword2').className="form-control is-invalid";
            }
        }else if(pass1.length==0){
                document.getElementById('inputPassword1').className="form-control";
        }else {
            document.getElementById('inputPassword1').className="form-control is-invalid";

        }
       

    }
</script>


<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light pinkku">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      
      <li class="nav-item">
        <a class="nav-link" href="{{ url('logout', []) }}" role="button">
          <i class="fa fa-power-off"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar   text-dark  pinkku2 elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/home', []) }}" class="brand-link pink-gelapku">
      <h3 class="brand-image rounded-circle bg-info px-1 text-bold" style="padding-top:2px ">SI</h3>
      <span class="brand-text text-bold text-white" style="font-size: 17px;letter-spacing: 2px">Penjualan Mobil</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-1 mb-3 d-flex">
        <div class="image mt-3">
          <img src="{{ url('gambar/user.png', []) }}" class="" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Session::get('nama')}}</a>
          <span>{{Session::get('posisi')}}</span>
          <br>
          <small>
            <button type="button" class="badge badge-btn badge-secondary border-0" data-toggle="modal" data-target="#resetPassword">Ubah Password</button>
          </small>
          
        </div>
        
      </div>
      <hr>
      </button>
      
      <!-- Modal -->
      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        
          <li class="nav-item pinkku px-2">
            <hr class="py-0 my-0">
            <b class="hoverku text-light text-right">MENU</b>
            <hr class="py-0 my-0">
          </li>

          <li class="nav-item hoverku">
            <a href="{{ url('home', []) }}" class="nav-link @yield('activekuhome')">
              <i class="nav-icon fa fa-home"></i>
              <p>
                Home
              </p>
            </a>
          </li>
          

          @if (Session::get('posisi') === 'admin')
              
          <li class="nav-item hoverku">
            <a href="{{ url('mobil', []) }}" class="nav-link @yield('activekumobil')">
              <i class="nav-icon fa fa-car"></i>
              <p>
                Data Mobil
              </p>
            </a>
          </li>

          <li class="nav-item hoverku">
            <a href="{{ url('pembeli', []) }}" class="nav-link @yield('activekupembeli')">
              <i class="nav-icon fa fa-users"></i>
              <p>
                Data Pembeli
              </p>
            </a>
          </li>

          <li class="nav-item hoverku">
            <a href="{{ url('penjualan', []) }}" class="nav-link @yield('activekupenjualan')">
              <i class="nav-icon fa fa-dollar-sign"></i>
              <p>
                Data Penjualan
              </p>
            </a>
          </li>

          <li class="nav-item pinkku px-2 mt-4 text-left px-2">
            <hr class="py-0 my-0">
            <b class="hoverku text-light text-right">MENU DATA PEMASOK</b>
            <hr class="py-0 my-0">
          </li>

          <li class="nav-item hoverku">
            <a href="{{ url('mobilmasuk', []) }}" class="nav-link @yield('activekumobilmasuk')">
              <i class="nav-icon fa fa-database"></i>
              <p>
                Data Mobil Masuk
                @php
                    $mm = DB::table('mobil')->where('idketerangan', 2)->count();
                @endphp
                <small class="badge badge-info">{{$mm}}</small>
              </p>
            </a>
          </li>

          <li class="nav-item hoverku">
            <a href="{{ url('proses', []) }}" class="nav-link @yield('activekumobilproses')">
              <i class="nav-icon fa fa-sign-in-alt"></i>
              <p>
                Data Mobil Diproses
                @php
                    $md = DB::table('mobil')->where('idketerangan', 3)->count();
                @endphp
                <small class="badge badge-info">{{$md}}</small>
              </p>
            </a>
          </li>


          <li class="nav-item hoverku">
            <a href="{{ url('pembelianmobil', []) }}" class="nav-link @yield('activekupembelianmobil')">
              <i class="nav-icon fa fa-check"></i>
              <p>
                Mobil yang Dibeli
                @php
                    $md = DB::table('mobil')->where('idketerangan', 1)->join('supplier', 'supplier.idsupplier', '=', 'mobil.idsupplier')->count();
                @endphp
                <small class="badge badge-info">{{$md}}</small>
              </p>
            </a>
          </li>

          <li class="nav-item pinkku px-2 mt-4 text-left px-2">
            <hr class="py-0 my-0">
            <b class="hoverku text-light text-right">MENU PENGGUNA</b>
            <hr class="py-0 my-0">
          </li>

          <li class="nav-item hoverku">
            <a href="{{ url('admin', []) }}" class="nav-link @yield('activekuadmin')">
              <i class="nav-icon fa fa-user"></i>
              <p>
                Data Admin
              </p>
            </a>
          </li>

          <li class="nav-item hoverku">
            <a href="{{ url('supplier', []) }}" class="nav-link @yield('activekusupplier')">
              <i class="nav-icon fa fa-users"></i>
              <p>
                Data Supplier
              </p>
            </a>
          </li>

          @endif
          @if (Session::get('posisi')==='supplier')

              <li class="nav-item hoverku">
                <a href="{{ url('jualmobil', []) }}" class="nav-link @yield('activekujualmobil')">
                  <i class="nav-icon fa fa-car"></i>
                  <p>
                    Jual Mobil
                  </p>
                </a>
              </li>

              <li class="nav-item hoverku">
                <a href="{{ url('mobilterjual', []) }}" class="nav-link @yield('activekumobilterjual')">
                  <i class="nav-icon fa fa-dollar-sign"></i>
                  <p>
                    Mobil Terjual
                  </p>
                </a>
              </li>

              <li class="nav-item pinkku px-2 mt-4 text-left px-2">
                <hr class="py-0 my-0">
                <b class="hoverku text-light text-right">DATA IDENTITAS</b>
                <hr class="py-0 my-0">
              </li>


              <li class="nav-item hoverku">
                <a href="{{ url('identitas', []) }}" class="nav-link @yield('activekuIdentitas')">
                  <i class="nav-icon fa fa-user"></i>
                  <p>
                    Identitas Supplier
                  </p>
                </a>
              </li>
          @endif
          

          
          
          
          
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>@yield('judul')</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      @yield('content')

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer text-sm footerku">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.4
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->

<!-- Bootstrap 4 -->
<script src="{{ url('plugins/bootstrap/js/bootstrap.bundle.min.js', []) }}"></script>
<!-- AdminLTE App -->
<script src="{{ url('dist/js/adminlte.min.js', []) }}"></script>

@include('sweetalert::alert')
{{-- <script src="{{ url('yearpicker/src/js/jquery.min.js', []) }}"></script> --}}




@yield('myscript')
<!-- AdminLTE for demo purposes -->
{{-- <script src="{{ url('dist/js/demo.js', []) }}"></script> --}}
</body>
</html>
