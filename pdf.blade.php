<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }
        th {
            background-color: #e0e0e0;
            text-align: center;
        }
        td {
            text-align: left;
        }
        h3 {
            text-align: center;
        }
    </style>
</head>
<body>

<h3>Laporan Transaksi Peminjaman Barang</h3>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Transaksi</th>
            <th>Instansi</th>
            <th>Nama Perwakilan</th>
            <th>Kontak</th>
            <th>Barang</th>
            <th>Jumlah</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transaksis as $t)
        <tr>
            <td style="text-align:center">{{ $loop->iteration }}</td>
            <td>{{ $t->kode_transaksi }}</td>
            <td>{{ $t->instansi?->nama_ins ?? '-' }}</td>
            <td>{{ $t->nama_perwakilan ?? '-' }}</td>
            <td>{{ $t->kontak ?? '-' }}</td>

            {{-- BARANG --}}
            <td>
                @foreach($t->barangs as $barang)
                    • {{ $barang->nama_brg }}<br>
                @endforeach
            </td>

            {{-- JUMLAH --}}
            <td style="text-align:center">
                @foreach($t->barangs as $barang)
                    {{ $barang->pivot->jumlah_pinjam }}<br>
                @endforeach
            </td>

            <td>{{ $t->tanggal_pinjam }}</td>
            <td>{{ $t->tanggal_kembali ?? '-' }}</td>
            <td style="text-align:center">{{ ucfirst($t->status) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
