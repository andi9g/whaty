@extends('layout.layoutAdmin')

@section('activekuadmin')
    activeku
@endsection

@section('judul')
    <i class="fa fa-car"></i> Data Admin
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">

            <button type="button" class="btn btn-primary my-2" data-toggle="modal" data-target="#exampleModal">
                Tambah Data Admin
            </button>
            
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><b>Tambah Data Admin</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <form action="{{ route('admin.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class='form-group'>
                                <label for='fornama'>Nama Lengkap</label>
                                <input type='text' name='nama' id='fornama' class='form-control form-control-sm text-capitalize' placeholder='masukan Nama Lengkap'>
                            </div>
                            <div class='form-group'>
                                <label for='forusername'>Username</label>
                                <input type='text' name='username' id='forusername' class='form-control form-control-sm text-capitalize' placeholder='masukan Username'>
                            </div>
                            <div class='form-group'>
                                <label for='forpassword'>Password</label>
                                <input type='password' name='password' id='forpassword' class='form-control form-control-sm text-capitalize' placeholder='masukan password'>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <form action="{{ url()->current() }}" class="form-inline justify-content-end">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" value="{{empty($_GET['keyword'])?'':$_GET['keyword']}}" name="keyword" aria-describedby="button-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-outline-success" type="submit" id="button-addon2">Cari</button>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body table-responsive">
            
            <table class="table table-striped table-hover table-bordered table-sm">
                <tr>
                    <th width="10px">No</th>
                    <th class="text-capitalize">Usename</th>
                    <th class="text-capitalize">Nama Lengkap</th>
                    <th class="text-capitalize">Aksi</th>
                </tr>

                @foreach ($admin as $item)
                    <tr>
                        <td>{{$loop->iteration + $admin->firstItem() - 1}}</td>
                        <td><b>{{$item->username}}</b></td>
                        <td>{{$item->nama}}</td>

                        <td>
                            <form action="{{ route('admin.destroy', [$item->idadmin]) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Lanjutkan proses?')" class="badge badge-btn badge-danger border-0">
                                    <i class="fa fa-trash"></i> 
                                </button>
                            </form>

                            <!-- Button trigger modal -->
                            <button type="button" class="badge badge-btn badge-primary border-0" data-toggle="modal" data-target="#editadmin{{$item->idadmin}}">
                              <i class="fa fa-edit"></i> Ubah
                            </button>

                            <form action="{{ route('reset.admin', [$item->idadmin]) }}" method="post" class="d-inline">
                                @csrf
                                <button type="submit" onclick="return confirm('Lanjutkan proses reset')" class="badge badge-btn badge-secondary border-0">
                                    Reset Password
                                </button>
                            </form>
                            
                        </td>
                        
                    </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="editadmin{{$item->idadmin}}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                    <div class="modal-header">
                                            <h5 class="modal-title"><b>Ubah Data Mobil </b></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                        </div>
                                        <form action="{{ route('admin.update', [$item->idadmin]) }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class='form-group'>
                                                    <label for='fornama'>Nama Lengkap</label>
                                                    <input type='text' name='nama' id='fornama' class='form-control form-control-sm text-capitalize' value="{{$item->nama}}" placeholder='masukan Nama Lengkap'>
                                                </div>
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">success changes</button>
                                            </div>
                                        </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </table>
        </div>  

        <div class="card-footer">
            {{$admin->links('vendor.pagination.bootstrap-4')}}
        </div>

    </div>    

</div>


@endsection

@section('myscript')
    <script>
        $('.yearpicker').yearpicker();

        $(document).ready(function() {
            $("#warnamobil").select2({
                tags: true
            });
        });

    </script>
@endsection