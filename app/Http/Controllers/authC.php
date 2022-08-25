<?php

namespace App\Http\Controllers;

use App\Models\adminM;
use App\Models\supplierM;
use Hash;
use Illuminate\Http\Request;

class authC extends Controller
{

    public function root()
    {
        return redirect('login');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('login');
    }

    public function login(Request $requ)
    {
        return view('pages.pagesLogin');
    }

    public function proseslogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'posisi' => 'required',
        ]);

        try{
            $username = $request->username;
            $password = $request->password;
            $posisi = $request->posisi;

            $login = false;

            if($posisi == 'supplier') {
                $login = supplierM::where('email', $username);

                if($login->count() === 1) {
                    if(Hash::check($password, $login->first()->password)) {
                        $data = $login->first();
                        $request->session()->put('login', true);
                        $request->session()->put('posisi', 'supplier');
                        $request->session()->put('nama', $data->nama);
                        $request->session()->put('id', $data->idsupplier);
                        $unique = 'email';
                        $login = true;
                    }
                }
            }elseif ($posisi == 'admin') {
                $login = adminM::where('username', $username);

                if($login->count() === 1) {
                    if(Hash::check($password, $login->first()->password)) {
                        $data = $login->first();
                        $request->session()->put('login', true);
                        $request->session()->put('posisi', 'admin');
                        $request->session()->put('nama', $data->nama);
                        $request->session()->put('id', $data->idadmin);
                        $unique = 'username';
                        $login = true;
                    }
                }
                
            }else {
                return redirect('login')->with('toast_error', 'password atau username tidak benar');
            }
            
            if($login === true) {
                return redirect('home')->with('success', 'Selamat Datang');
            }else {
                return redirect('login')->with('toast_error', 'password atau '.$unique.' tidak benar');
            }

        }catch(\Throwable $th){
            return redirect('login')->with('toast_error', 'Terjadi kesalahan');
        }
    }

    public function register(Request $request)
    {
        return view('pages.pagesRegister');
    }

    public function prosesregister(Request $request)
    {
        $request->validate([
            'username' => 'required|email|unique:supplier,email',
            'nama' => 'required',
            'password1' => 'required',
            'password2' => 'required',
        ]);
        
        
        try{
            $email = $request->username;
            $nama = $request->nama;
            $password1 = $request->password1;
            $password2 = $request->password2;
        
            if($password1 === $password2) {
                $password = Hash::make($password1);

                $store = new supplierM;
                $store->email = $email;
                $store->nama = $nama;
                $store->password = $password;
                $store->save();

                if($store) {
                    return redirect('login')->with('success', 'Data berhasil dibuat');
                }
            }else {
                return redirect()->back()->with('warning', 'password tidak sama')->withInput();
            }
            
            
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    public function resetpassword(Request $request)
    {
        return view('pages.pagesResetPassword');
    }

    public function prosesresetpassword(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'nama' => 'required',
        ]);
        
        
        try{
            $username = $request->username;
            $nama = $request->nama;
            
            $cek = supplierM::where('email', $username)->where('nama', $nama);

            if($cek->count() === 1) {
                return view('pages.pagesUbahPassword', [
                    'idsupplier' => $cek->first()->idsupplier,
                    'email' => $cek->first()->email,
                ]);
            }else {
                return redirect()->back()->with('toast_error', 'tidak ada data yang ditemukan')->withInput();
            }
        }catch(\Throwable $th){
            return redirect('login')->with('toast_error', 'Terjadi kesalahan');
        }
    }

    public function ubahpassword(Request $request, $email)
    {
        $request->validate([
            'password' => 'required',
        ]);

        try{
            $password = Hash::make($request->password);

            $ubah = supplierM::where('email', $email)->update([
                'password' => $password
            ]);

            if($ubah) {
                return redirect('login')->with('success', 'reset password Berhasil');
            }

        }catch(\Throwable $th){
            return redirect('resetpassword')->with('toast_error', 'Terjadi kesalahan');
        }
    }



}
