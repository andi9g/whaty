<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\detailsupplierM;
use App\Models\supplierM;

class LengkapiIdentitas
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $idsupplier = $request->session()->get('id');

        $cek = detailsupplierM::where('idsupplier', $idsupplier)->count();
        
        if($cek === 1) {
            return $next($request);
        }else {
            return redirect('identitas')->with('warning', 'Harap melengkapi identitas supplier');
        }

    }
}
