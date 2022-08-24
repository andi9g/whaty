<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
    <table width="100%" style="border-bottom: 2px double black;margin-bottom: 5px;padding-bottom: 10px">
        <tr>
            <td width="130px" valign="justify"><img src="{{ url('gambar', ['logo.jpeg']) }}" alt="" width="130px"></td>
            <td align="left" valign="top">
                <table>
                    <tr>
                        <td><h1 style="margin: 0 0; padding:0 0">HEMBAS BARU</h1></td>
                    </tr>
                    <tr>
                        <td><h3 style="margin: 0 0; padding:0 0"></h3></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    

    <h2 style="margin: 0 0; padding:0 0">Laporan Pembelian Mobil Pada Supplier</h2>
    <small>Priode : {{date('d/m/Y',strtotime($tanggalawal))." s/d ".date('d/m/Y',strtotime($tanggalakhir))}}</small><br>

    <table style="border-collapse: collapse;" width="100%" border='1'>
        <tr>
            <th width="10px">No</th>
            <th class="text-capitalize">Gambar</th>
            <th class="text-capitalize">kode plat</th>
            <th class="text-capitalize">nama mobil</th>
            <th class="text-capitalize">harga mobil</th>
            <th class="text-capitalize">tahun</th>
            <th class="text-capitalize">warna</th>
            <th class="text-capitalize">Type Mobil</th>
            <th class="text-capitalize">Tanggal</th>
        </tr>

        @foreach ($penjualan as $item)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td class="text-center"><img src="{{url("images", $item->gambar)}}" class="rounded border" width="70px" alt=""></td>
                <td><b>{{$item->kodeplat}}</b></td>
                <td>{{$item->namamobil}}</td>
                <td>Rp{{number_format($item->hargamobilbeli, 0,",",".")}}</td>
                <td>{{$item->tahun}}</td>
                <td>{{$item->warna}}</td>
                <td class="text-capitalize">{{$item->typemobil}}</td>
                <td style="text-center">{{date('d F Y', strtotime($item->updated_at))}}</td>

            </tr>
        @endforeach
    </table>


</body>
</html>