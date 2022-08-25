@extends('layout.layoutAdmin')

@section('activekumobilmasuk')
    activeku
@endsection

@section('judul')
    <i class="fa fa-car"></i> Data Mobil Masuk
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6"></div>
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
    

    @php
        $perangkat = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
                    
        if($perangkat) {
            $halaman = "api";
            $target = "";
        }else {
            $halaman = "web";
            $target = "_blank";
        }
    @endphp
    <div class="card">
        <div class="card-body table-responsive">
            
            <table class="table table-striped table-hover table-bordered table-sm">
                <tr>
                    <th width="10px">No</th>
                    <th class="text-capitalize">Gambar</th>
                    <th class="text-capitalize">kode plat</th>
                    <th class="text-capitalize">nama mobil</th>
                    <th class="text-capitalize">harga mobil</th>
                    <th class="text-capitalize">tahun</th>
                    <th class="text-capitalize">warna</th>
                    <th class="text-capitalize">Type Mobil</th>
                    <th class="text-capitalize">Detail</th>
                    <th class="text-capitalize">Aksi</th>
                </tr>

                @foreach ($mobil as $item)
                    <tr>
                        <td>{{$loop->iteration + $mobil->firstItem() - 1}}</td>
                        <td class="text-center"><img src="{{url("images", $item->gambar)}}" class="rounded border" width="70px" alt=""></td>
                        <td><b>{{$item->kodeplat}}</b></td>
                        <td>{{$item->namamobil}}</td>
                        <td>Rp{{number_format($item->hargamobilbeli, 0,",",".")}}</td>
                        <td>{{$item->tahun}}</td>
                        <td>{{$item->warna}}</td>
                        <td class="text-capitalize">{{$item->typemobil}}</td>

                        <td>
                            <button type="button" class="badge badge-btn badge-primary border-0" data-toggle="modal" data-target="#editmobil{{$item->idmobil}}">
                              <i class="fa fa-user"></i> Detail Supplier
                            </button>
                        </td>

                        <td>
                            <form action="{{ route('mobilmasuk.proses', [$item->idmobil]) }}" method="post" class="d-inline">
                                @csrf
                                <button type="submit" onclick="return confirm('Lanjutkan proses?')" class="btn btn-success btn-block btn-sm">
                                    <i class="fa fa-sign"></i> PROSES
                                </button>
                            </form>
                        </td>
                        
                    </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="editmobil{{$item->idmobil}}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                    <div class="modal-header">
                                            <h5 class="modal-title"><b>Ubah Data Mobil </b></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class='form-group'>
                                                <label for='fornamamobil'>NIK</label>
                                                <input type='text' disabled name='namamobil' id='fornamamobil' class='form-control form-control-sm' value="{{$item->nik}}" placeholder='masukan nama mobil'>
                                            </div>

                                            <div class='form-group'>
                                                <label for='fornamamobil'>Nama Supplier</label>
                                                <input type='text' disabled name='namamobil' id='fornamamobil' class='form-control form-control-sm' value="{{$item->nama}}" placeholder='masukan nama mobil'>
                                            </div>

                                            <div class='form-group'>
                                                <label for='fornamamobil'>Jenis Kelamin</label>
                                                <input type='text' disabled name='namamobil' id='fornamamobil' class='form-control form-control-sm' value="@if ($item->jeniskelamin == 'l')Laki-Laki
                                                @elseif($item->jeniskelamin == 'p')Perempuan
                                                @endif" placeholder='masukan nama mobil'>
                                            </div>

                                            <div class='form-group'>
                                                <label for='fornamamobil'>Alamat</label>
                                                <input type='text' disabled name='namamobil' id='fornamamobil' class='form-control form-control-sm' value="{{$item->alamat}}" placeholder='masukan nama mobil'>
                                            </div>

                                            <div class='form-group'>
                                                <label for='fornamamobil'>Nomor HP/WA</label>
                                                <input type='text' disabled name='namamobil' id='fornamamobil' class='form-control form-control-sm' value="{{$item->hp}}" placeholder='masukan nama mobil'>
                                            </div>

                                            <div class='form-group'>
                                                <label for='fornamamobil'>Tempat, Tgl. Lahir</label>
                                                <input type='text' disabled name='namamobil' id='fornamamobil' class='form-control form-control-sm' value="{{$item->tempatlahir.", ".date('d F Y', strtotime($item->tanggallahir))}}" placeholder='masukan nama mobil'>
                                            </div>
                                            
                                            
                                        </div>

                                        @php
                                            $kata = (String) ($item->hp);
                                            $nohp = substr($kata, 0,2);
                                            if($nohp == "08") {
                                                $nohp = "62".substr($kata,1,13);
                                            }
                                        @endphp
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <a href="https://{{$halaman}}.whatsapp.com/send?phone={{ $nohp }}&text=*Hallo {{$item->nama}}*,%0ASaya Tertarik dengan Mobil :%0A*{{ strtoupper($item->namamobil).'* %0ADengan Plat : %0A*'.strtoupper($item->kodeplat) }}*, %0A%0A Apakah Masih Tersedia?" class="btn btn-success text-bold" target="{{$target}}">
                                                 Chat Via WhatsApp
                                            </a>
                                        </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </table>
        </div>  

        <div class="card-footer">
            {{$mobil->links('vendor.pagination.bootstrap-4')}}
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