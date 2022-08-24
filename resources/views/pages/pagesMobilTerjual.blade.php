@extends('layout.layoutAdmin')

@section('activekumobilterjual')
    activeku
@endsection

@section('judul')
    <i class="fa fa-dollar-sign"></i> Data Mobil (Terjual)
@endsection

@section('content')
<div class="container">
    
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
                            <div class="badge badge-success">TERJUAL</div>                            
                        </td>
                        
                    </tr>
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