@extends('layout.layoutAdmin')

@section('activekuhome')
    activeku
@endsection

@section('judul')
    <i class="fa fa-home"></i> Home
@endsection

@section('content')
<div class="container">
@if (Session::get('posisi')==='supplier')
<div class="row">
    <div class="col-lg-3 col-6">
    
      <div class="small-box bg-secondary">
          <div class="inner">
            <h3>{{$mobildijual}}</h3>
    
            <p class="text-uppercase">Mobil yang Dijual</p>
          </div>
          <div class="icon">
            <i class="ion ion-chart"></i>
          </div>
          <a href="{{ url('jualmobil', []) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
    
      <div class="small-box bg-secondary">
          <div class="inner">
            <h3>{{$mobilproses}}</h3>
    
            <p class="text-uppercase">Mobil yang Terproses</p>
          </div>
          <div class="icon">
            <i class="ion ion-chart"></i>
          </div>
          <a href="{{ url('jualmobil', []) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
    
        <div class="small-box bg-secondary">
            <div class="inner">
              <h3>{{$mobilterjual}}</h3>
      
              <p class="text-uppercase">Mobil yang Terjual</p>
            </div>
            <div class="icon">
              <i class="ion ion-chart"></i>
            </div>
            <a href="{{ url('mobilterjual', []) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
      </div>







</div>
  

@elseif (Session::get('posisi')==='admin')
<div class="row">
    <div class="col-lg-3 col-6">
    
      <div class="small-box bg-secondary">
          <div class="inner">
            <h3>{{$mobil}}</h3>
    
            <p class="text-uppercase">Data Mobil</p>
          </div>
          <div class="icon">
            <i class="ion ion-chart"></i>
          </div>
          <a href="{{ url('mobil', []) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
    
      <div class="small-box bg-success">
          <div class="inner">
            <h3>{{$mobildijual}}</h3>
    
            <p class="text-uppercase">Data Mobil Masuk</p>
          </div>
          <div class="icon">
            <i class="ion ion-chart"></i>
          </div>
          <a href="{{ url('mobilmasuk', []) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
    
        <div class="small-box bg-success">
            <div class="inner">
              <h3>{{$mobilproses}}</h3>
      
              <p class="text-uppercase">Data Mobil Diproses</p>
            </div>
            <div class="icon">
              <i class="ion ion-chart"></i>
            </div>
            <a href="{{ url('proses', []) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
      </div>

    <div class="col-lg-3 col-6">
    
        <div class="small-box bg-secondary">
            <div class="inner">
              <h3>{{$mobilterjual}}</h3>
      
              <p class="text-uppercase">Mobil yang Terjual</p>
            </div>
            <div class="icon">
              <i class="ion ion-chart"></i>
            </div>
            <a href="{{ url('terjual', []) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
      </div>


      <div class="col-lg-3 col-6">
    
        <div class="small-box bg-secondary">
            <div class="inner">
              <h3>{{$supplier}}</h3>
      
              <p class="text-uppercase">Jumlah Supplier</p>
            </div>
            <div class="icon">
              <i class="ion ion-chart"></i>
            </div>
            <a href="{{ url('supplier', []) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
      </div>

      <div class="col-lg-3 col-6">
    
        <div class="small-box bg-secondary">
            <div class="inner">
              <h3>{{$admin}}</h3>
      
              <p class="text-uppercase">Jumlah Admin</p>
            </div>
            <div class="icon">
              <i class="ion ion-chart"></i>
            </div>
            <a href="{{ url('admin', []) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
      </div>







</div>

@endif


</div>


@endsection


