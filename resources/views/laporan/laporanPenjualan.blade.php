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
    

    <h2 style="margin: 0 0; padding:0 0">Laporan Penjualan Mobil</h2>
    <small>Priode : {{date('d/m/Y',strtotime($tanggalawal))." s/d ".date('d/m/Y',strtotime($tanggalakhir))}}</small><br>

    <table style="border-collapse: collapse;" width="100%" border='1'>
        <tr>
            <th width="10px">No</th>
            <th class="text-capitalize">Gambar</th>
            <th class="text-capitalize">Plat Mobil</th>
            <th class="text-capitalize">Nama Mobil</th>
            <th class="text-capitalize">Warna</th>
            <th class="text-capitalize">Tahun Mobil</th>
            <th class="text-capitalize">Harga Beli</th>
            <th class="text-capitalize">Ket</th>
            <th class="text-capitalize">Tanggal Beli</th>
        </tr>

        @foreach ($penjualan as $item)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td style="text-align:center;padding: 5px 0px"><img src="{{url("images", $item->gambar)}}" class="rounded border" width="70px" alt=""></td>
                <td nowrap><b>{{$item->nik}}</b></td>
                <td >{{$item->namamobil}}</td>
                <td nowrap>{{$item->warna}}</td>
                <td style="text-align: center">{{$item->tahun}}</td>
                <td>Rp{{number_format($item->hargabeli, 0, ",",".")}}</td>
                <td nowrap>{{$item->ket}}</td>
                <td style="text-align: center">{{date('d F Y',strtotime($item->tanggal))}}</td>

            </tr>
        @endforeach
    </table>


</body>
</html>