<?php

namespace App\Http\Controllers;

use App\Models\mobilM;
use App\Models\supplierM;
use App\Models\adminM;
use Hash;
use Illuminate\Http\Request;

class indexC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posisi = $request->session()->get('posisi');
        $id = $request->session()->get('id');
        
        // dd($posisi);
        $mobildijual = mobilM::where(function ($query) {
            $query->where('idketerangan', 2)
                  ->orWhere('idketerangan', 3);
        })->count();
        
        $mobil = mobilM::where('idketerangan', 1)->count();
        $mobilterjual = mobilM::where('idketerangan', 5)->count();
        $mobilkredit = mobilM::where('idketerangan', 4)->count();
        $mobilproses = mobilM::where('idketerangan', 3)->count();
        $supplier = supplierM::join('detailsupplier', 'detailsupplier.idsupplier','=','supplier.idsupplier')->count();
        $admin = adminM::count();

        if($posisi == "supplier") {
            $mobildijual = mobilM::where(function ($query) {
                $query->where('idketerangan', 2)
                      ->orWhere('idketerangan', 3);
            })->where('idsupplier', $id)->count();
            $mobilproses = mobilM::where('idketerangan', 3)->where('idsupplier', $id)->count();
            $mobilterjual = mobilM::where('idketerangan', 1)->where('idsupplier', $id)->count();
        }

        return view('pages.pagesHome', [
            'mobil' => $mobil,
            'mobildijual' => $mobildijual,
            'mobilproses' => $mobilproses,
            'mobilterjual' => $mobilterjual,
            'mobilkredit' => $mobilkredit,
            'supplier' => $supplier,
            'admin' => $admin,
        ]);

    }


    public function ubahpassword(Request $request)
    {
        $request->validate([
            'password1' => 'required',
            'password2' => 'required',
        ]);

        try{
            $password1 = $request->password1;
            $password2 = $request->password2;


            if($password1 === $password2) {
                $password = Hash::make($password1);

                $posisi = $request->session()->get('posisi');
                $id = $request->session()->get('id');
    
                if($posisi === 'supplier') {
                    $update = supplierM::where('idsupplier', $id)->update([
                        'password' => $password,
                    ]);
    
                }elseif($posisi === 'admin') {
                    $update = adminM::where('idadmin', $id)->update([
                        'password' => $password,
                    ]);
                }else {
                    return redirect('home')->with('toast_error', 'Terjadi kesalahan');
                }
            }else {
                return redirect('home')->with('toast_error', 'Terjadi kesalahan');
            }

            if($update) {
                $request->session()->flush();
                return redirect('login')->with('success', 'Password berhasil di ubah, silahkan login kembali');
            }

        }catch(\Throwable $th){
            return redirect('home')->with('toast_error', 'Terjadi kesalahan');
        }
    }
}
