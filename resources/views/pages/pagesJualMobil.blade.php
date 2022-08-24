@extends('layout.layoutAdmin')

@section('activekujualmobil')
    activeku
@endsection

@section('judul')
    <i class="fa fa-car"></i> Data Mobil (Dijual)
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary my-2" data-toggle="modal" data-target="#exampleModal">
                Tambah Data Mobil
            </button>
            
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><b>Tambah Data Mobil</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <form action="{{ route('tambah.jualmobil') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class='form-group'>
                                <label for='fornamamobil'>Nama Mobil</label>
                                <input type='text' name='namamobil' id='fornamamobil' class='form-control form-control-sm text-capitalize' placeholder='masukan nama mobil'>
                            </div>
                            <div class='form-group'>
                                <label for='forhargamobil'>Harga Mobil</label>
                                <input type='number' name='hargamobil' id='forhargamobil' class='form-control form-control-sm' placeholder='masukan harga mobil'>
                                <p>Jumlah : <font id="review"></font></p>
                            </div>

                            <script type="text/javascript">
		
                                var rupiah = document.getElementById('forhargamobil');
                                var tampil = document.getElementById('review');
                                rupiah.addEventListener('keyup', function(e){
                                    // tambahkan 'Rp.' pada saat form di ketik
                                    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                                    tampil.innerHTML = formatRupiah(this.value, 'Rp');
                                });
                         
                                /* Fungsi formatRupiah */
                                function formatRupiah(angka, prefix){
                                    var number_string = angka.replace(/[^,\d]/g, '').toString(),
                                    split   		= number_string.split(','),
                                    sisa     		= split[0].length % 3,
                                    rupiah     		= split[0].substr(0, sisa),
                                    ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
                         
                                    // tambahkan titik jika yang di input sudah menjadi angka ribuan
                                    if(ribuan){
                                        separator = sisa ? '.' : '';
                                        rupiah += separator + ribuan.join('.');
                                    }
                         
                                    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                                    return prefix == undefined ? rupiah : (rupiah ? 'Rp' + rupiah : '');
                                }
                            </script>

                            <div class='form-group'>
                                <label for='fortypemobil'>Type Mobil</label>
                                <select name='typemobil' id='fortypemobil' class='form-control form-control-sm'>
                                    <option value=''>Pilih</option>
                                    <option value='manual'>Manual</option>
                                    <option value='matic'>Matic</option>
                                <select>
                            </div>
                            <div class='form-group'>
                                <label for='forkodeplat'>Kode Plat BM</label>
                                <input type='text' name='kodeplat' id='forkodeplat' class='form-control form-control-sm' placeholder='masukan kode plat'>
                            </div>
                            <div class='form-group'>
                                <label for='fortahun'>Tahun</label>
                                <input type='number' name='tahun' id='fortahun' placeholder="masukan tahun" class='form-control form-control-sm yearpicker'>
                            </div>
                            <div class='form-group text-capitalize'>
                                <label for="">Masukan Warna Mobil</label>
                                <select name="warna" style="width: 100%; height: 100px;" required class="form-control text-capitalize" id="warnamobil">
                                    <option value="">Masukan Warna</option>
                                    @foreach ($warna as $w)
                                        <option>{{$w->warna}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class='form-group'>

                                <label for='forgambarmobil'>Gambar Mobil</label>
                                <input type='file' name='gambar' id='forgambarmobil' class='form-control form-control-sm' placeholder='masukan Gambar'>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Tambah Data Mobil</button>
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
                    <th class="text-capitalize">Gambar</th>
                    <th class="text-capitalize">kode plat</th>
                    <th class="text-capitalize">nama mobil</th>
                    <th class="text-capitalize">harga mobil</th>
                    <th class="text-capitalize">tahun</th>
                    <th class="text-capitalize">warna</th>
                    <th class="text-capitalize">Type Mobil</th>
                    <th class="text-capitalize">KET</th>
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
                            @if ($item->idketerangan == 3)
                            <div class="badge badge-success">Sedang Diproses</div>                            
                                
                            @else 
                            <div class="badge badge-warning">Menunggu Konfirmasi</div>                            

                            @endif
                        </td>
                        <td>
                            @if ($item->idketerangan == 2)
                            <form action="{{ route('hapus.jualmobil', [$item->idmobil]) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Lanjutkan proses?')" class="badge badge-btn badge-danger border-0">
                                    <i class="fa fa-trash"></i> 
                                </button>
                            </form>

                            <!-- Button trigger modal -->
                            <button type="button" class="badge badge-btn badge-primary border-0" data-toggle="modal" data-target="#editmobil{{$item->idmobil}}">
                              <i class="fa fa-edit"></i> Ubah
                            </button>
                                
                            @endif
                            
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
                                        <form action="{{ route('ubah.jualmobil', [$item->idmobil]) }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class='form-group'>
                                                    <label for='fornamamobil'>Nama Mobil</label>
                                                    <input type='text' name='namamobil' id='fornamamobil' class='form-control form-control-sm' value="{{$item->namamobil}}" placeholder='masukan nama mobil'>
                                                </div>
                                                <div class='form-group'>
                                                    <label for='forhargamobil{{$item->idmobil}}'>Harga Mobil</label>
                                                    <input type='number' name='hargamobil' id='forhargamobil{{$item->idmobil}}' class='form-control form-control-sm' value="{{$item->hargamobilbeli}}" placeholder='masukan harga mobil'>
                                                    <p>Jumlah : <font id="review{{$item->idmobil}}"></font></p>
                                                </div>

                                                <script type="text/javascript">
		
                                                    var rupiah{{$item->idmobil}} = document.getElementById('forhargamobil{{$item->idmobil}}');
                                                    var tampil{{$item->idmobil}} = document.getElementById('review{{$item->idmobil}}');
                                                    rupiah{{$item->idmobil}}.addEventListener('keyup', function(e){
                                                        // tambahkan 'Rp.' pada saat form di ketik
                                                        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                                                        tampil{{$item->idmobil}}.innerHTML = formatRupiah(this.value, 'Rp');
                                                    });
                                                    
                                                    tampil{{$item->idmobil}}.innerHTML = formatRupiah(rupiah{{$item->idmobil}}.value, 'Rp');
                                                </script>


                                                <div class='form-group'>
                                                    <label for='fortypemobil'>Type Mobil</label>
                                                    <select name='typemobil' id='fortypemobil' class='form-control form-control-sm'>
                                                        <option value=''>Pilih</option>
                                                        <option value='manual' @if ($item->typemobil == 'manual')
                                                            selected
                                                        @endif>Manual</option>
                                                        <option value='matic' @if ($item->typemobil == 'matic')
                                                            selected
                                                        @endif>Matic</option>
                                                    <select>
                                                </div>
                                                <div class='form-group'>
                                                    <label for='forkodeplat'>Kode Plat BM</label>
                                                    <input type='text' name='kodeplat' id='forkodeplat' class='form-control form-control-sm' value="{{$item->kodeplat}}" placeholder='masukan kode plat'>
                                                </div>
                                                <div class='form-group'>
                                                    <label for='fortahun'>Tahun</label>
                                                    <input type='number' name='tahun' id='fortahun' placeholder="masukan tahun" value="" class='form-control form-control-sm yearpicker{{$item->idmobil}}'>
                                                </div>

                                                <script>
                                                    $(".yearpicker{{$item->idmobil}}").yearpicker({
                                                        year: {{$item->tahun}},
                                                    });
                                                </script>
                                                <div class='form-group text-capitalize'>
                                                    <label for="">Masukan Warna Mobil</label>
                                                    <select name="warna" style="width: 100%; height: 100px;" required class="form-control text-capitalize" id="warnamobil{{$item->idmobil}}">
                                                        <option value="">Masukan Warna</option>
                                                        @foreach ($warna as $w)
                                                            <option @if ($w->warna == $item->warna)
                                                                selected
                                                            @endif>{{$w->warna}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <script>
                                                    $("#warnamobil{{$item->idmobil}}").select2({
                                                        tags: true,
                                                    });
                                                </script>


                                                <div class='form-group'>
                    
                                                    <label for='forgambarmobil'>Gambar Mobil</label>
                                                    <input type='file' name='gambar' id='forgambarmobil' class='form-control form-control-sm' placeholder='masukan Gambar'>
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