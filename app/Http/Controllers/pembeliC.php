<?php

namespace App\Http\Controllers;

use App\Models\pembeliM;
use App\Models\mobilM;
use Illuminate\Http\Request;

class pembeliC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mobil = mobilM::where('idketerangan', 1)->get();

        $keyword = empty($request->keyword)?"":$request->keyword;
       
        $tampil = pembeliM::where(function ($query) use ($keyword){
            $query->where('nama', 'like', "$keyword%")
                  ->orWhere('nik', 'like', "$keyword%");
        })->orderBy('created_at', 'desc')
        ->paginate(15);

        $tampil->appends($request->only(['limit', 'keyword']));

        return view('pages.pagesPembeli', [
            'pembeli' => $tampil,
            'mobil' => $mobil,
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
            $nik = $request->nik;
            $nama = $request->nama;
            $hp = $request->hp;
            $alamat = $request->alamat;
            $jeniskelamin = $request->jeniskelamin;
            $tempatlahir = $request->tempatlahir;
            $tanggallahir = $request->tanggallahir;

            $tampung = new pembeliM;
            $tampung->nik = $nik;
            $tampung->nama = $nama;
            $tampung->jeniskelamin = $jeniskelamin;
            $tampung->alamat = $alamat;
            $tampung->hp = $hp;
            $tampung->tempatlahir = $tempatlahir;
            $tampung->tanggallahir = $tanggallahir;
            $tampung->save();

            if($tampung) {
                return redirect()->back()->with('success', 'Identitas berhasil ditambahkan')->withInput();
            }

        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pembeliM  $pembeliM
     * @return \Illuminate\Http\Response
     */
    public function show(pembeliM $pembeliM, $nik)
    {
        $request->validate([
            'nama' => 'required',
            'hp' => 'required|max:13|min:11|string',
            'jeniskelamin' => 'required',
            'alamat' => 'required',
            'tempatlahir' => 'required',
            'tanggallahir' => 'required|date'
        ],[
            'required' => 'Tidak boleh kosong',
            'min:11' => 'Harap masukan nomor hp/wa dengan benar',
            'max:13' => 'Harap masukan nomor hp/wa dengan benar',
            'date' => 'Masukan tanggal dengan benar',
            'numeric' => 'Hanya boleh angka',
        ]);


        try{
            // $nik = $request->nik;
            $nama = $request->nama;
            $hp = $request->hp;
            $alamat = $request->alamat;
            $jeniskelamin = $request->jeniskelamin;
            $tempatlahir = $request->tempatlahir;
            $tanggallahir = $request->tanggallahir;

            $update = pembeliM::where('nik', $nik)->update([
                'nama' => $nama,
                'jeniskelamin' => $jeniskelamin,
                'alamat' => $alamat,
                'hp' => $hp,
                'tempatlahir' => $tempatlahir,
                'tanggallahir' => $tanggallahir,
            ]);

            if($tampung) {
                return redirect()->back()->with('success', 'Identitas berhasil ditambahkan')->withInput();
            }


        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pembeliM  $pembeliM
     * @return \Illuminate\Http\Response
     */
    public function edit(pembeliM $pembeliM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\pembeliM  $pembeliM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pembeliM $pembeliM)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pembeliM  $pembeliM
     * @return \Illuminate\Http\Response
     */
    public function destroy(pembeliM $pembeliM, $nik)
    {
        try{
            $destroy = pembeliM::where('nik', $nik)->delete();
            if($destroy) {
                return redirect('location')->with('toast_success', 'success');
            }
        }catch(\Throwable $th){
            return redirect('location')->with('toast_error', 'Terjadi kesalahan');
        }
    }
}
