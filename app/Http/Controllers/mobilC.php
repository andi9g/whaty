<?php

namespace App\Http\Controllers;

use App\Models\mobilM;
use App\Models\keteranganM;
use Illuminate\Http\Request;

class mobilC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request->keyword);
        $keyword = empty($request->keyword)?"":$request->keyword;


        $tampil = mobilM::join('keterangan', 'keterangan.idketerangan', '=', 'mobil.idketerangan')
        ->where(function ($query) use ($keyword) {
            $query->where('mobil.kodeplat', 'like', "$keyword%")
                  ->orWhere('mobil.tahun', 'like', "$keyword%")
                  ->orWhere('mobil.namamobil', 'like', "$keyword%")
                  ->orWhere('mobil.typemobil', 'like', "$keyword%");
        })
        ->where('keterangan.idketerangan', 1)
        ->select('mobil.*', 'keterangan.ket')
        ->paginate(15);

        $tampil->appends($request->only(['limit', 'keyword']));

        $keterangan = keteranganM::get();

        $warna = mobilM::groupBy('warna')->select('warna')->get();

        return view('pages.pagesMobil', [
            'mobil' => $tampil,
            'keterangan' => $keterangan,
            'warna' => $warna,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
        
        try{

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
            $idpenjual = 0;
            $idketerangan = 1;
        
            $store = new mobilM;
            $store->namamobil = $namamobil;
            $store->hargamobil = $hargamobil;
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
                return redirect('mobil')->with('toast_success', 'success');
            }else {
                return redirect()->back()->with('warning', 'terjadi kesalahan penambahan data')->withInput();
            }
        }catch(\Throwable $th){
            return redirect('mobil')->with('toast_error', 'Terjadi kesalahan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\mobilM  $mobilM
     * @return \Illuminate\Http\Response
     */
    public function show(mobilM $mobilM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\mobilM  $mobilM
     * @return \Illuminate\Http\Response
     */
    public function edit(mobilM $mobilM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\mobilM  $mobilM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, mobilM $mobilM, $id)
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
            $idpenjual = 0;
            $idketerangan = 1;
        
            $update = mobilM::where('idmobil', $id)->update([
                'namamobil' => $namamobil,
                'hargamobil' => $hargamobil,
                'typemobil' => $typemobil,
                'tahun' => $tahun,
                'kodeplat' => $kodeplat,
                'warna' => $warna,
                'gambar' => $gambar,
                'idsupplier' => $idpenjual,
                'idketerangan' => $idketerangan,
            ]);
            
            if($update) {
                return redirect('mobil')->with('toast_success', 'success');
            }
        }catch(\Throwable $th){
            return redirect('mobil')->with('toast_error', 'Terjadi kesalahan');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\mobilM  $mobilM
     * @return \Illuminate\Http\Response
     */
    public function destroy(mobilM $mobilM, $id)
    {
        try{
            $destroy = mobilM::where('idmobil', $id)->delete();
            if($destroy) {
                return redirect('mobil')->with('toast_success', 'success');
            }
        }catch(\Throwable $th){
            return redirect('mobil')->with('toast_error', 'Terjadi kesalahan');
        }
    }
}
