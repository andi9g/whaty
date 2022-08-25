<?php

namespace App\Http\Controllers;

use App\Models\mobilM;
use App\Models\detailpembeliM;
use App\Models\pembeliM;
use PDF;
use Illuminate\Http\Request;

class penjualanC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = empty($request->keyword)?"":$request->keyword;

        $tampil = mobilM::join('detailpembeli', 'detailpembeli.idmobil', '=', 'mobil.idmobil')
        ->join('pembeli', 'pembeli.nik', '=', 'detailpembeli.nik')
        ->where('mobil.idketerangan', 5)
        ->where(function ($query) use ($keyword) {
            $query->where('mobil.namamobil', 'like', "$keyword%")
                  ->orWhere('pembeli.nama', 'like', "$keyword%")
                  ->orWhere('mobil.tahun', 'like', "$keyword%");
        })->orderBy('detailpembeli.tanggal', 'desc')
        ->select('mobil.*', 'pembeli.*', 'detailpembeli.*')
        ->paginate(15);

        $tampil->appends($request->only(['limit', 'keyword']));

        return view('pages.pagesPenjualan', [
            'penjualan' => $tampil
        ]);
    }

    public function cetak(Request $request)
    {
        $request->validate([
            'tanggalawal' => 'required',
            'tanggalakhir' => 'required',
        ]);
        
        
        try{
            $tanggalawal = $request->tanggalawal;
            $tanggalakhir = $request->tanggalakhir;
            
            $tampil = mobilM::join('detailpembeli', 'detailpembeli.idmobil', '=', 'mobil.idmobil')
            ->join('pembeli', 'pembeli.nik', '=', 'detailpembeli.nik')
            ->where('mobil.idketerangan', 5)
            ->whereBetween('detailpembeli.tanggal', [$tanggalawal, $tanggalakhir])
            ->orderBy('detailpembeli.tanggal', 'desc')
            ->select('mobil.*', 'pembeli.*', 'detailpembeli.*')
            ->get();

            $pdf = PDF::loadView('laporan.laporanPenjualan', [
                'penjualan' => $tampil,
                'tanggalawal' => $tanggalawal,
                'tanggalakhir' => $tanggalakhir,
            ])->setPaper('a4', 'landscape');

            return $pdf->stream();

        }catch(\Throwable $th){
            return redirect('penjualan')->with('toast_error', 'Terjadi kesalahan');
        }
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
        //
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
    public function update(Request $request, mobilM $mobilM, $nik)
    {
        $request->validate([
            'mobil' => 'required',
            'tanggal' => 'required',
            'pembayaran' => 'required',
            'hargamobilbeli' => 'required',
        ]);
        
        
        try{
            $mobil = explode("_",$request->mobil);
            $mobil = $mobil[0];
            $tanggal = $request->tanggal;
            $pembayaran = $request->pembayaran;
            $hargabeli = $request->hargamobilbeli;
            
            if($pembayaran == "kredit") {
                $pembayaran = $pembayaran." ".$request->nilai." ".$request->lama;
            }
            // dd($request->nilai);

            // dd($pembayaran);

            $store = new detailpembeliM;
            $store->nik = $nik;
            $store->idmobil = $mobil;
            $store->hargabeli = $hargabeli;
            $store->tanggal = $tanggal;
            $store->ket = $pembayaran;
            $store->save();
            if($store) {
                mobilM::where('idmobil', $mobil)->update([
                    'idketerangan' => 5,
                ]);

                return redirect('penjualan')->with('toast_success', 'success');
            }
        }catch(\Throwable $th){
            return redirect('penjualan')->with('toast_error', 'Terjadi kesalahan');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\mobilM  $mobilM
     * @return \Illuminate\Http\Response
     */
    public function destroy(mobilM $mobilM)
    {
        //
    }
}
