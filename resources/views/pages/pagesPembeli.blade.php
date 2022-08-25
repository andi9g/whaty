@extends('layout.layoutAdmin')

@section('activekupembeli')
    activeku
@endsection

@section('judul')
    <i class="fa fa-car"></i> Data pembeli
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">

            <button type="button" class="btn btn-primary my-2" data-toggle="modal" data-target="#exampleModal">
                Tambah Data Pembeli
            </button>
            
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><b>Tambah Data Pembeli</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <form action="{{ route('pembeli.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class='form-group'>
                                <label for='fornik'>NIK</label>
                                <input type='number' name='nik' id='fornik' class='form-control @error("nik")
                                    is-invalid
                                @enderror' placeholder='masukan nik'>
                                @error('nik')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                
                            <div class='form-group'>
                                <label for='fornama' class="text-capitalize">nama</label>
                                <input type='text' name='nama' id='fornama' class='form-control @error("nama")
                                    is-invalid
                                @enderror' placeholder='masukan nama'>
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                
                            <div class='form-group'>
                                <label for='forhp'>Nomor Hp/WA</label>
                                <input type='number' name='hp' id='forhp' class='form-control @error("hp")
                                    is-invalid
                                @enderror' placeholder='masukan nomor hp/wa'>
                                @error('hp')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class='form-group'>
                                <label for='forjeniskelamin' class='text-capitalize @error("jeniskelamin")
                                    is-invalid
                                @enderror'>jeniskelamin</label>
                                <select name='jeniskelamin' required id='forjeniskelamin' class='form-control'>
                                    <option value=''>Pilih</option>
                                    <option value='l'>Laki-laki</option>
                                    <option value='p'>Perempuan</option>
                                <select>
                            </div>
                
                            <div class='form-group'>
                                <label for='foralamat' class="text-capitalize">alamat</label>
                                <textarea name="alamat" id="" placeholder="alamat" class="form-control @error('alamat')
                                    is-invalid
                                @enderror" cols="30" rows="3"></textarea>
                                
                                @error('alamat')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                
                            <div class='form-group'>
                                <label for='fortempatlahir' class="text-capitalize">tempat lahir</label>
                                <input type='text' name='tempatlahir' id='fortempatlahir' class='form-control @error("tempatlahir")
                                    is-invalid
                                @enderror' placeholder='tempat lahir'>
                                @error('tempatlahir')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                
                            <div class='form-group'>
                                <label for='fortanggallahir' class="text-capitalize">tanggal lahir</label>
                                <input type='date' name='tanggallahir' id='fortanggallahir' class='form-control @error("tanggallahir")
                                    is-invalid
                                @enderror' placeholder='masukan tanggallahir'>
                                @error('tanggallahir')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Tambah Data Pembeli</button>
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
                    <th class="text-capitalize">NIK</th>
                    <th class="text-capitalize">Nama Lengkap</th>
                    <th class="text-capitalize">Alamat</th>
                    <th class="text-capitalize">Aksi</th>
                    <th class="text-capitalize">Aksi 2</th>
                </tr>

                @foreach ($pembeli as $item)
                    <tr>
                        <td>{{$loop->iteration + $pembeli->firstItem() - 1}}</td>
                        <td><b>{{$item->nik}}</b></td>
                        <td>{{$item->nama}}</td>
                        <td>{{$item->alamat}}</td>

                        <td>
                            <form action="{{ route('pembeli.destroy', [$item->nik]) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Lanjutkan proses?')" class="badge badge-btn badge-danger border-0">
                                    <i class="fa fa-trash"></i> 
                                </button>
                            </form>

                            <!-- Button trigger modal -->
                            <button type="button" class="badge badge-btn badge-primary border-0" data-toggle="modal" data-target="#editadmin{{$item->nik}}">
                              <i class="fa fa-edit"></i> Ubah
                            </button>
                            
                        </td>

                        <td class="text-center">
                            <!-- Button trigger modal -->
                            <button type="button" class="badge border-0 badge-success w-100 badge-btn" data-toggle="modal" data-target="#pembelian{{$item->nik}}">
                              <b>BELI MOBIL</b>
                            </button>
                            
                        </td>
                        
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="pembelian{{$item->nik}}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Proses Beli</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                </div>

                                <form action="{{ route('penjualan.update', [$item->nik]) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Data Mobil Tersedia</label>
                                        <select required id="select2{{$item->nik}}" onchange="pilihmobil{{$item->nik}}(this)" class="form-control w-100" style="width:100%" name="mobil">
                                            <option value="">Pilih Mobil</option>
                                            @foreach ($mobil as $m)
                                                <option value="{{$m->idmobil."_".$m->hargamobil}}">{{$m->namamobil." - ".$m->warna." - ".$m->tahun}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class='form-group'>
                                        <label for='forhargamobil{{$item->nik}}' required class='text-capitalize'>harga mobil</label>
                                        <input type='text' name='hargamobil' readonly id='forhargamobil{{$item->nik}}' class='form-control'>
                                    </div>

                                    <div class='form-group'>
                                        <label for='forhargamobilbeli{{$item->nik}}' required class='text-capitalize'>harga yang dibeli</label>
                                        <input type='number' name='hargamobilbeli' onkeyup="ketikharga{{$item->nik}}(this)" onchange="ketikharga{{$item->nik}}(this)" onClick="ketikharga{{$item->nik}}(this)" id='forhargamobilbeli{{$item->nik}}' class='form-control'>
                                        <p for="" id="keteranganharga{{$item->nik}}"></p>
                                    </div>

                                    <script>
                                        function pilihmobil{{$item->nik}}(value) {
                                            let val = value.value.split("_")[1];
                                            
                                            if(val != "") {
                                                document.getElementById('forhargamobil{{$item->nik}}').value=formatRupiah{{$item->nik}}(val, "Rp");
                                                document.getElementById('forhargamobilbeli{{$item->nik}}').value=val;
                                            }else {
                                                ocument.getElementById('forhargamobil{{$item->nik}}').value=""
                                            }
                                        }

                                        function ketikharga{{$item->nik}}(nilai) {
                                            var harga = nilai.value;
                                            document.getElementById('keteranganharga{{$item->nik}}').innerHTML = formatRupiah{{$item->nik}}(harga, "Rp")
                                        }

                                        function formatRupiah{{$item->nik}}(angka, prefix){
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
                                        <label for='fortanggal' class='text-capitalize'>tanggal beli</label>
                                        <input type='date' name='tanggal' id='fortanggal' class='form-control' placeholder='masukan tanggal'>
                                    </div>
                                    
                                      <script>
                                        $(document).ready(function() {
                                            $('#select2{{$item->nik}}').select2();
                                        });
                                      </script>


                                    <div class='form-group'>
                                        <label for='forpembayaran' class='text-capitalize'>pembayaran</label>
                                        <select required name='pembayaran' onchange="pilih{{$item->nik}}(this)" class='form-control'>
                                            <option value=''>Pilih</option>
                                            <option value="cash">Cash</option>
                                            <option value="kredit">kredit</option>
                                        <select>
                                    </div>

                                    <div id="kredit{{$item->nik}}" hidden disabled>
                                        <div class='form-group'>
                                            <label for='fornilai' class='text-capitalize'>nilai</label>
                                            <input type='number'  name='nilai' id='fornilai' class='form-control' placeholder='masukan nilai'>
                                        </div>
        
                                        <div class='form-group'>
                                            <label for='forLama' class='text-capitalize'>Lama</label>
                                            <select name='lama'  id='forLama' class='form-control'>
                                                <option value=''>Pilih</option>
                                                <option value='bulan'>Bulan</option>
                                                <option value='tahun'>Tahun</option>
                                            <select>
                                        </div>
                                    </div>

                                    <script>
                                        function pilih{{$item->nik}}(pilih) {
                                            var pil = pilih.value;
                                            var kredit = document.getElementById('kredit{{$item->nik}}');
                                            if(pil == 'cash') {
                                                kredit.disabled=true;
                                                kredit.hidden=true;
                                            }else if(pil == 'kredit') {
                                                kredit.disabled=false;
                                                kredit.hidden=false;
                                            }else {
                                                kredit.disabled=true;
                                                kredit.hidden=true;
                                            }
                                        }
                                    </script>


                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Proses Pembelian</button>
                                </div>

                            </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="editadmin{{$item->nik}}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                    <div class="modal-header">
                                            <h5 class="modal-title"><b>Ubah Data Mobil </b></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                        </div>
                                        <form action="{{ route('pembeli.update', [$item->nik]) }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class='form-group'>
                                                    <label for='fornama' class="text-capitalize">nama</label>
                                                    <input type='text' value="{{$item->nama}}" name='nama' id='fornama' class='form-control @error("nama")
                                                        is-invalid
                                                    @enderror' placeholder='masukan nama'>
                                                    @error('nama')
                                                        <div class="invalid-feedback">
                                                            {{$message}}
                                                        </div>
                                                    @enderror
                                                </div>
                                    
                                                <div class='form-group'>
                                                    <label for='forhp'>Nomor Hp/WA</label>
                                                    <input type='number' value="{{$item->hp}}" name='hp' id='forhp' class='form-control @error("hp")
                                                        is-invalid
                                                    @enderror' placeholder='masukan nomor hp/wa'>
                                                    @error('hp')
                                                        <div class="invalid-feedback">
                                                            {{$message}}
                                                        </div>
                                                    @enderror
                                                </div>
                                                
                                                <div class='form-group'>
                                                    <label for='forjeniskelamin' class='text-capitalize @error("jeniskelamin")
                                                        is-invalid
                                                    @enderror'>jeniskelamin</label>
                                                    <select name='jeniskelamin' required id='forjeniskelamin' class='form-control'>
                                                        <option value=''>Pilih</option>
                                                        <option value='l' @if ($item->jeniskelamin == 'l')
                                                            selected
                                                        @endif>Laki-laki</option>
                                                        <option value='p' @if ($item->jeniskelamin == 'p')
                                                            selected
                                                        @endif>Perempuan</option>
                                                    <select>
                                                </div>
                                    
                                                <div class='form-group'>
                                                    <label for='foralamat' class="text-capitalize">alamat</label>
                                                    <textarea name="alamat" id="" placeholder="alamat" class="form-control @error('alamat')
                                                        is-invalid
                                                    @enderror" cols="30" rows="3">{{$item->alamat}}</textarea>
                                                    
                                                    @error('alamat')
                                                        <div class="invalid-feedback">
                                                            {{$message}}
                                                        </div>
                                                    @enderror
                                                </div>
                                    
                                                <div class='form-group'>
                                                    <label for='fortempatlahir' class="text-capitalize">tempat lahir</label>
                                                    <input type='text' value="{{$item->tempatlahir}}" name='tempatlahir' id='fortempatlahir' class='form-control @error("tempatlahir")
                                                        is-invalid
                                                    @enderror' placeholder='tempat lahir'>
                                                    @error('tempatlahir')
                                                        <div class="invalid-feedback">
                                                            {{$message}}
                                                        </div>
                                                    @enderror
                                                </div>
                                    
                                                <div class='form-group'>
                                                    <label for='fortanggallahir' class="text-capitalize">tanggal lahir</label>
                                                    <input type='date' value="{{$item->tanggallahir}}" name='tanggallahir' id='fortanggallahir' class='form-control @error("tanggallahir")
                                                        is-invalid
                                                    @enderror' placeholder='masukan tanggallahir'>
                                                    @error('tanggallahir')
                                                        <div class="invalid-feedback">
                                                            {{$message}}
                                                        </div>
                                                    @enderror
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
            {{$pembeli->links('vendor.pagination.bootstrap-4')}}
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