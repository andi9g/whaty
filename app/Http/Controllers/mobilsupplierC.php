<?php

namespace App\Http\Controllers;

use App\Models\mobilM;
use App\Models\keteranganM;
use PDF;
use Illuminate\Http\Request;

class mobilsupplierC extends Controller
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
        ->join('supplier', 'supplier.idsupplier', '=', 'mobil.idsupplier')
        ->join('detailsupplier', 'detailsupplier.idsupplier', '=', 'mobil.idsupplier')
        ->where(function ($query) use ($keyword) {
            $query->where('mobil.kodeplat', 'like', "$keyword%")
                  ->orWhere('mobil.tahun', 'like', "$keyword%")
                  ->orWhere('mobil.namamobil', 'like', "$keyword%")
                  ->orWhere('mobil.typemobil', 'like', "$keyword%");
        })
        ->where('mobil.idsupplier', '!=', 0)
        ->where('keterangan.idketerangan', 2)
        ->orderBy('mobil.created_at', 'desc')
        ->select('detailsupplier.*','supplier.*','mobil.*', 'keterangan.ket')
        ->paginate(15);

        $tampil->appends($request->only(['limit', 'keyword']));

        $keterangan = keteranganM::get();

        $warna = mobilM::groupBy('warna')->select('warna')->get();

        return view('pages.pagesMobilMasuk', [
            'mobil' => $tampil,
            'keterangan' => $keterangan,
            'warna' => $warna,
        ]);
    }

    public function proses(Request $request, $idmobil)
    {
        try{
            $update = mobilM::where('idmobil', $idmobil)->update([
                'idketerangan' => 3,
            ]);

            if ($update) {
                return redirect('mobilmasuk')->with('success', 'data berhasil di proses');
            }

        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    public function mobilproses(Request $request)
    {
        // dd($request->keyword);
        $keyword = empty($request->keyword)?"":$request->keyword;

        $tampil = mobilM::join('keterangan', 'keterangan.idketerangan', '=', 'mobil.idketerangan')
        ->join('supplier', 'supplier.idsupplier', '=', 'mobil.idsupplier')
        ->where(function ($query) use ($keyword) {
            $query->where('mobil.kodeplat', 'like', "$keyword%")
                  ->orWhere('mobil.tahun', 'like', "$keyword%")
                  ->orWhere('mobil.namamobil', 'like', "$keyword%")
                  ->orWhere('mobil.typemobil', 'like', "$keyword%");
        })
        ->where('mobil.idsupplier', '!=', 0)
        ->where('keterangan.idketerangan', 3)
        ->orderBy('mobil.created_at', 'desc')
        ->select('supplier.*','mobil.*', 'keterangan.ket')
        ->paginate(15);

        $tampil->appends($request->only(['limit', 'keyword']));

        $keterangan = keteranganM::get();

        $warna = mobilM::groupBy('warna')->select('warna')->get();

        return view('pages.pagesMobilProses', [
            'mobil' => $tampil,
            'keterangan' => $keterangan,
            'warna' => $warna,
        ]);
    }

    public function prosescancel(Request $request, $idmobil)
    {
        try{
            
            $cancel = mobilM::where('idmobil', $idmobil)->update([
                'idketerangan' => 2
            ]);

            if ($cancel) {
                return redirect()->back()->with('success', 'Data berhasil di cancel');
            }

        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }           
    }

    public function prosessah(Request $request, $idmobil)
    {
        $request->validate([
            'hargamobil' => 'required|numeric',
            'hargamobilbeli' => 'required|numeric',
        ]);
        
        
        try{
            $hargamobil = $request->hargamobil;
            $hargamobilbeli = $request->hargamobilbeli;
        
            $update = mobilM::where('idmobil', $idmobil)->update([
                'hargamobil' => $hargamobil,
                'hargamobilbeli' => $hargamobilbeli,
                'idketerangan' => 1
            ]);

            if($update) {
                return redirect('proses')->with('toast_success', 'success');
            }
        }catch(\Throwable $th){
            return redirect('proses')->with('toast_error', 'Terjadi kesalahan');
        }
    }

    public function terbeli(Request $request)
    {
        // dd($request->keyword);
        $keyword = empty($request->keyword)?"":$request->keyword;

        $tampil = mobilM::join('keterangan', 'keterangan.idketerangan', '=', 'mobil.idketerangan')
        ->join('supplier', 'supplier.idsupplier', '=', 'mobil.idsupplier')
        ->join('detailsupplier', 'detailsupplier.idsupplier', '=', 'mobil.idsupplier')
        ->where(function ($query) use ($keyword) {
            $query->where('mobil.kodeplat', 'like', "$keyword%")
                  ->orWhere('mobil.tahun', 'like', "$keyword%")
                  ->orWhere('mobil.namamobil', 'like', "$keyword%")
                  ->orWhere('mobil.typemobil', 'like', "$keyword%");
        })
        ->where('mobil.idsupplier', '!=', 0)
        ->where('keterangan.idketerangan', 1)
        ->orderBy('mobil.updated_at', 'desc')
        ->select('detailsupplier.*','supplier.*','mobil.*', 'keterangan.ket')
        ->paginate(15);

        $tampil->appends($request->only(['limit', 'keyword']));

        $keterangan = keteranganM::get();

        $warna = mobilM::groupBy('warna')->select('warna')->get();

        return view('pages.pagesMobilTerbeli', [
            'mobil' => $tampil,
            'keterangan' => $keterangan,
            'warna' => $warna,
        ]);
    }


    public function cetak(Request $request)
    {
        $request->validate([
            'tanggalawal' => 'required',
            'tanggalakhir' => 'required',
        ]);
        
        
        // try{
            $tanggalawal = $request->tanggalawal;
            $tanggalakhir = $request->tanggalakhir;

            $tampil = mobilM::join('keterangan', 'keterangan.idketerangan', '=', 'mobil.idketerangan')
            ->join('supplier', 'supplier.idsupplier', '=', 'mobil.idsupplier')
            ->join('detailsupplier', 'detailsupplier.idsupplier', '=', 'mobil.idsupplier')
            ->whereBetween('mobil.updated_at', [$tanggalawal, $tanggalakhir])
            ->where('mobil.idsupplier', '!=', 0)
            ->where(function ($query) {
                $query->where('keterangan.idketerangan', 1)
                      ->orWhere('keterangan.idketerangan', 5);
            })
            ->orderBy('mobil.updated_at', 'desc')
            ->select('detailsupplier.*','supplier.*', 'keterangan.ket','mobil.*')
            ->get();
            
            $pdf = PDF::loadView('laporan.laporanPembelian', [
                'penjualan' => $tampil,
                'tanggalawal' => $tanggalawal,
                'tanggalakhir' => $tanggalakhir,
            ])->setPaper('a4', 'landscape');

            return $pdf->stream();

        // }catch(\Throwable $th){
        //     return redirect('penjualan')->with('toast_error', 'Terjadi kesalahan');
        // }
    }
    
}
