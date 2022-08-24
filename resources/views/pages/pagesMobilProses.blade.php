@extends('layout.layoutAdmin')

@section('activekumobilproses')
    activeku
@endsection

@section('judul')
    <i class="fa fa-car"></i> Data Mobil diproses
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
                    <th class="text-capitalize">Aksi 1</th>
                    <th class="text-capitalize">Aksi 2</th>
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
                            <form action="{{ route('proses.cancel', [$item->idmobil]) }}" method="post" class="d-inline">
                                @csrf
                                <button type="submit" onclick="return confirm('Lanjutkan proses cancel?')" class="badge badge-btn badge-danger border-0">
                                    <i class="fa fa-times"></i> Cancel
                                </button>
                            </form>
                        </td>
                        <td>

                            <!-- Button trigger modal -->
                            <button type="button" class="badge badge-btn badge-success border-0" data-toggle="modal" data-target="#editmobil{{$item->idmobil}}">
                              <i class="fa fa-check"></i> PROSES BELI
                            </button>
                            
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
                                        <form action="{{ route('proses.sah', [$item->idmobil]) }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">

                                                <div class='form-group'>
                                                    <label for='forhargamobilbeli{{$item->idmobil}}'>Harga Mobil Dibeli</label>
                                                    <input type='number' name='hargamobilbeli' id='forhargamobilbeli{{$item->idmobil}}' class='form-control form-control-sm' value="{{$item->hargamobilbeli}}" placeholder='masukan harga mobil'>
                                                    <p>Jumlah : <font id="reviewbeli{{$item->idmobil}}"></font></p>
                                                </div>

                                                <div class='form-group'>
                                                    <label for='forhargamobil{{$item->idmobil}}'>Harga Mobil Yang Akan Dijual</label>
                                                    <input type='number' name='hargamobil' id='forhargamobil{{$item->idmobil}}' class='form-control form-control-sm' value="{{$item->hargamobil}}" placeholder='masukan harga mobil'>
                                                    <p>Jumlah : <font id="review{{$item->idmobil}}"></font></p>
                                                </div>

                                                <script type="text/javascript">

                                                    var rupiah{{$item->idmobil}} = document.getElementById('forhargamobil{{$item->idmobil}}');

                                                    var rupiahbeli{{$item->idmobil}} = document.getElementById('forhargamobilbeli{{$item->idmobil}}');

                                                    var tampil{{$item->idmobil}} = document.getElementById('review{{$item->idmobil}}');

                                                    var tampilbeli{{$item->idmobil}} = document.getElementById('reviewbeli{{$item->idmobil}}');

                                                    rupiah{{$item->idmobil}}.addEventListener('keyup', function(e){
                                                        tampil{{$item->idmobil}}.innerHTML = formatRupiah{{$item->idmobil}}(this.value, 'Rp');
                                                    });

                                                    tampil{{$item->idmobil}}.innerHTML = formatRupiah{{$item->idmobil}}(rupiah{{$item->idmobil}}.value, 'Rp');

                                                    rupiahbeli{{$item->idmobil}}.addEventListener('keyup', function(e){
                                                        tampilbeli{{$item->idmobil}}.innerHTML = formatRupiah{{$item->idmobil}}(this.value, 'Rp');
                                                    });
                                                    
                                                    tampilbeli{{$item->idmobil}}.innerHTML = formatRupiah{{$item->idmobil}}(rupiahbeli{{$item->idmobil}}.value, 'Rp');




                                                    function formatRupiah{{$item->idmobil}}(angka, prefix){
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
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Proses</button>
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