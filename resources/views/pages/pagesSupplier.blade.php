@extends('layout.layoutAdmin')

@section('activekusupplier')
    activeku
@endsection

@section('judul')
    <i class="fa fa-car"></i> Data Supplier
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
                    <th class="text-capitalize">Email</th>
                    <th class="text-capitalize">Nama Lengkap</th>
                    <th class="text-capitalize">Tanggal Buat</th>
                </tr>

                @foreach ($supplier as $item)
                    <tr>
                        <td>{{$loop->iteration + $supplier->firstItem() - 1}}</td>
                        <td><b>{{$item->email}}</b></td>
                        <td>{{$item->nama}}</td>
                        <td>
                            {{ date('d F Y', strtotime($item->created_at))}}
                        </td>
                        
                    </tr>
                    
                @endforeach
            </table>
        </div>  

        <div class="card-footer">
            {{$supplier->links('vendor.pagination.bootstrap-4')}}
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