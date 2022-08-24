@extends('layout.layoutAdmin')

@section('activekupenjualan')
    activeku
@endsection

@section('judul')
    <i class="fa fa-dollar-sign"></i> Data Penjualan
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#cetakLaporan">
              Cetak Laporan
            </button>
            
            <!-- Modal -->
            <div class="modal fade" id="cetakLaporan" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Laporan Penjualan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                        
                        <form action="{{ route('cetak.penjualan') }}" method="get" target="_blank">
                        <div class="modal-body">
                            <div class='form-group'>
                                <label for='fortanggalawal' class='text-capitalize'>Tanggal Awal</label>
                                <input type='date' name='tanggalawal' id='fortanggalawal' class='form-control' placeholder='masukan tanggalawal'>
                            </div>

                            <div class='form-group'>
                                <label for='fortanggalakhir' class='text-capitalize'>Tanggal Akhir</label>
                                <input type='date' name='tanggalakhir' id='fortanggalakhir' class='form-control' placeholder='masukan tanggalakhir'>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Cetak</button>
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
                    <th class="text-capitalize">NIK</th>
                    <th class="text-capitalize">Nama Lengkap</th>
                    <th class="text-capitalize">Plat Mobil</th>
                    <th class="text-capitalize">Nama Mobil</th>
                    <th class="text-capitalize">Warna</th>
                    <th class="text-capitalize">Type Mobil</th>
                    <th class="text-capitalize">Tahun Mobil</th>
                    <th class="text-capitalize">Ket</th>
                    <th class="text-capitalize">Tanggal Beli</th>
                </tr>

                @foreach ($penjualan as $item)
                    <tr>
                        <td>{{$loop->iteration + $penjualan->firstItem() - 1}}</td>
                        <td class="text-center"><img src="{{url("images", $item->gambar)}}" class="rounded border" width="70px" alt=""></td>
                        <td><b>{{$item->nik}}</b></td>
                        <td>{{$item->nama}}</td>
                        <td><b>{{$item->kodeplat}}</b></td>
                        <td>{{$item->namamobil}}</td>
                        <td>{{$item->warna}}</td>
                        <td>{{$item->typemobil}}</td>
                        <td>{{$item->tahun}}</td>
                        <td>{{$item->ket}}</td>
                        <td>{{date('d F Y',strtotime($item->tanggal))}}</td>

                    </tr>
                @endforeach
            </table>
        </div>  

        <div class="card-footer">
            {{$penjualan->links('vendor.pagination.bootstrap-4')}}
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