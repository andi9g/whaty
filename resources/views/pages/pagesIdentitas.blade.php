@extends('layout.layoutAdmin')

@section('activekuIdentitas')
    activeku
@endsection

@section('judul')
    <i class="fa fa-user"></i> Identitas Supplier
@endsection

@section('content')
<div class="container">
    
</div>

<div class="container">
    <div class="card">
        <form action="{{ route('ubah.identitas') }}" method="post">
            @csrf
        <div class="card-body">
            <div class='form-group'>
                <label for='fornik'>NIK</label>
                <input type='number' name='nik' id='fornik' class='form-control @error("nik")
                    is-invalid
                @enderror' value="{{empty($supplier->nik)?old('nik'):$supplier->nik}}" placeholder='masukan nik'>
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
                @enderror' value="{{empty($supplier->nama)?old('nama'):$supplier->nama}}" placeholder='masukan nama'>
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
                @enderror' value="{{empty($supplier->hp)?old('hp'):$supplier->hp}}" placeholder='masukan nomor hp/wa'>
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
                    <option value='l' @if ((empty($supplier->jeniskelamin)?old('jeniskelamin'):$supplier->jeniskelamin) == 'l')
                        selected
                    @endif>Laki-laki</option>
                    <option value='p' @if ((empty($supplier->jeniskelamin)?old('jeniskelamin'):$supplier->jeniskelamin) == 'p')
                        selected
                    @endif>Perempuan</option>
                <select>
            </div>

            <div class='form-group'>
                <label for='foralamat' class="text-capitalize">alamat</label>
                <textarea name="alamat" id="" placeholder="alamat" class="form-control @error('alamat')
                    is-invalid
                @enderror" cols="30" rows="3">{{empty($supplier->alamat)?old('alamat'):$supplier->alamat}}</textarea>
                
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
                @enderror' value="{{empty($supplier->tempatlahir)?old('tempatlahir'):$supplier->tempatlahir}}" placeholder='tempat lahir'>
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
                @enderror' value="{{empty($supplier->tanggallahir)?old('tanggallahir'):$supplier->tanggallahir}}" placeholder='masukan tanggallahir'>
                @error('tanggallahir')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>



        </div>  
        <div class="card-footer text-right">
            <button type="submit" class="btn btn-success">Update Data</button>
        </div>

        </form>
    </div>    

</div>


@endsection