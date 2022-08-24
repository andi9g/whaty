<?php

namespace App\Http\Controllers;

use App\Models\detailsupplierM;
use App\Models\supplierM;
use App\Models\mobilM;
use App\Models\keteranganM;
use Illuminate\Http\Request;

class supplierC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $idsupplier = $request->session()->get('id');

        $data = detailsupplierM::rightJoin('supplier', 'supplier.idsupplier', '=', 'detailsupplier.idsupplier')->select('supplier.nama', 'detailsupplier.*')
        ->where('supplier.idsupplier', $idsupplier)->first();

        return view('pages.pagesIdentitas', [
            'supplier' => $data,
        ]);
    }


    public function updateidentitas(Request $request)
    {
        

        $request->validate([
            'nik' => 'required|min:16|max:16|string',
            'nama' => 'required',
            'hp' => 'required|max:13|min:11|string',
            'jeniskelamin' => 'required',
            'alamat' => 'required',
            'tempatlahir' => 'required',
            'tanggallahir' => 'required|date'
        ],[
            'required' => 'Tidak boleh kosong',
            'min:16' => 'Harap masukan nik dengan benar',
            'min:11' => 'Harap masukan nomor hp/wa dengan benar',
            'max:13' => 'Harap masukan nomor hp/wa dengan benar',
            'date' => 'Masukan tanggal dengan benar',
            'numeric' => 'Hanya boleh angka',
        ]);

        try{
            $idsupplier = $request->session()->get('id');
            $nik = $request->nik;
            $nama = $request->nama;
            $hp = $request->hp;
            $alamat = $request->alamat;
            $jeniskelamin = $request->jeniskelamin;
            $tempatlahir = $request->tempatlahir;
            $tanggallahir = $request->tanggallahir;

            detailsupplierM::where('idsupplier', $idsupplier)->delete();

            $tampung = new detailsupplierM;
            $tampung->idsupplier = $idsupplier;
            $tampung->nik = $nik;
            $tampung->jeniskelamin = $jeniskelamin;
            $tampung->alamat = $alamat;
            $tampung->hp = $hp;
            $tampung->tempatlahir = $tempatlahir;
            $tampung->tanggallahir = $tanggallahir;
            $tampung->save();

            if($tampung) {
                $update = supplierM::where('idsupplier', $idsupplier)->update([
                    'nama' => $nama,
                ]);

                if($update) {
                    return redirect()->back()->with('success', 'Identitas berhasil ditambahkan')->withInput();
                }
            }


        }catch(\Throwable $th){
            return redirect('identitas')->with('toast_error', 'Terjadi kesalahan');
        }

    }

    public function mobil(Request $request)
    {
        $keyword = empty($request->keyword)?"":$request->keyword;
        $idsupplier = $request->session()->get('id');

        $tampil = mobilM::join('keterangan', 'keterangan.idketerangan', '=', 'mobil.idketerangan')
        ->where(function ($query) use ($keyword) {
            $query->where('mobil.kodeplat', 'like', "$keyword%")
                  ->orWhere('mobil.tahun', 'like', "$keyword%")
                  ->orWhere('mobil.namamobil', 'like', "$keyword%")
                  ->orWhere('mobil.typemobil', 'like', "$keyword%");
        })->where(function ($query) {
            $query->where('keterangan.idketerangan', 2)
                  ->orWhere('keterangan.idketerangan', 3);
        })->where('mobil.idsupplier', $idsupplier)
        ->select('mobil.*', 'keterangan.ket')
        ->paginate(15);

        $tampil->appends($request->only(['limit', 'keyword']));

        $keterangan = keteranganM::get();

        $warna = mobilM::groupBy('warna')->select('warna')->get();

        return view('pages.pagesJualMobil', [
            'mobil' => $tampil,
            'keterangan' => $keterangan,
            'warna' => $warna,
        ]);
    }

    public function tambahmobil(Request $request)
    {
        $request->validate([
            'namamobil' => 'required',
            'hargamobil' => 'required|numeric',
            'typemobil' => 'required',
            'tahun' => 'required|numeric',
            'kodeplat' => 'required|unique:mobil,kodeplat',
            'warna' => 'required',
            'gambar' => 'required',
        ]);
        
        // try{

            if ($request->hasFile('gambar')) {
                $originName = $request->file('gambar')->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->file('gambar')->getClientOriginalExtension();

                $format = strtolower($extension);
                if($format == 'jpg' || $format == 'jpeg' || $format == 'png') {
                    $fileName = $fileName.'_'.time().'.'.$extension;
                    
                }else {
                    $fileName= 'none.jpg';
                }

            }else {
                $fileName= 'none.jpg';
            }

            $namamobil = $request->namamobil;
            $hargamobil = $request->hargamobil;
            $typemobil = $request->typemobil;
            $tahun = $request->tahun;
            $kodeplat = $request->kodeplat;
            $warna = $request->warna;
            $gambar = $fileName;
            $idpenjual = $request->session()->get('id');
            $idketerangan = 2;
        
            $store = new mobilM;
            $store->namamobil = $namamobil;
            $store->hargamobil = 0;
            $store->hargamobilbeli = $hargamobil;
            $store->typemobil = $typemobil;
            $store->tahun = $tahun;
            $store->kodeplat = $kodeplat;
            $store->warna = $warna;
            $store->gambar = $gambar;
            $store->idsupplier = $idpenjual;
            $store->idketerangan = $idketerangan;
            $store->save();
            if($store) {
                $upload = $request->file('gambar')->move(\base_path()."/public/images", $gambar);
                return redirect('jualmobil')->with('toast_success', 'success');
            }else {
                return redirect()->back()->with('warning', 'terjadi kesalahan penambahan data')->withInput();
            }
        // }catch(\Throwable $th){
        //     return redirect('jualmobil')->with('toast_error', 'Terjadi kesalahan');
        // }
    }

    public function ubahmobil(Request $request, $idmobil)
    {
        $request->validate([
            'namamobil' => 'required',
            'typemobil' => 'required',
            'hargamobil' => 'required|numeric',
            'tahun' => 'required|numeric',
            'kodeplat' => 'required',
            'warna' => 'required',
            'gambar' => 'required',
        ]);
        
        
        try{

            if ($request->hasFile('gambar')) {
                $originName = $request->file('gambar')->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->file('gambar')->getClientOriginalExtension();

                $format = strtolower($extension);
                if($format == 'jpg' || $format == 'jpeg' || $format == 'png') {
                    $fileName = $fileName.'_'.time().'.'.$extension;
                    $upload = $request->file('gambar')->move(\base_path()."/public/images", $fileName);
                }else {
                    $fileName= 'none';
                }

            }else {
                $fileName= 'none';
            }

            if($fileName == 'none') {
                $gambar = mobilM::where('idmobil', $id)->first()->gambar;
            }

            $namamobil = $request->namamobil;
            $hargamobil = $request->hargamobil;
            $typemobil = $request->typemobil;
            $tahun = $request->tahun;
            $kodeplat = $request->kodeplat;
            $warna = $request->warna;
            $gambar = $gambar;
            $idpenjual = $request->session()->get('id');
            $idketerangan = 2;
        
            $update = mobilM::where('idmobil', $id)->update([
                'namamobil' => $namamobil,
                'hargamobilbeli' => $hargamobil,
                'typemobil' => $typemobil,
                'tahun' => $tahun,
                'kodeplat' => $kodeplat,
                'warna' => $warna,
                'gambar' => $gambar,
                'idsupplier' => $idpenjual,
                'idketerangan' => $idketerangan,
            ]);
            
            if($update) {
                return redirect('jualmobil')->with('toast_success', 'success');
            }
        }catch(\Throwable $th){
            return redirect('jualmobil')->with('toast_error', 'Terjadi kesalahan');
        }
    }

    public function hapusmobil(Request $request, $idmobil)
    {
        $idpenjual = $request->session()->get('id');

        try{
            $destroy = mobilM::where('idsupplier', $idpenjual)->where('idmobil', $idmobil)->delete();
            if($destroy) {
                return redirect('jualmobil')->with('toast_success', 'success');
            }
        }catch(\Throwable $th){
            return redirect('jualmobil')->with('toast_error', 'Terjadi kesalahan');
        }
    }

    public function mobilterjual(Request $request)
    {
        $keyword = empty($request->keyword)?"":$request->keyword;
        $idsupplier = $request->session()->get('id');

        $tampil = mobilM::join('keterangan', 'keterangan.idketerangan', '=', 'mobil.idketerangan')
        ->where(function ($query) use ($keyword) {
            $query->where('mobil.kodeplat', 'like', "$keyword%")
                  ->orWhere('mobil.tahun', 'like', "$keyword%")
                  ->orWhere('mobil.namamobil', 'like', "$keyword%")
                  ->orWhere('mobil.typemobil', 'like', "$keyword%");
        })
        ->where('keterangan.idketerangan', 1)
        ->where('mobil.idsupplier', $idsupplier)
        ->select('mobil.*', 'keterangan.ket')
        ->paginate(15);

        $tampil->appends($request->only(['limit', 'keyword']));

        $keterangan = keteranganM::get();

        $warna = mobilM::groupBy('warna')->select('warna')->get();

        return view('pages.pagesMobilTerjual', [
            'mobil' => $tampil,
            'keterangan' => $keterangan,
            'warna' => $warna,
        ]);
    }
}
