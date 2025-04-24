<!DOCTYPE html>
<html>
<head>
    <title>Data Stok</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Data Stok Barang</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Supplier</th>
                <th>User</th>
                <th>Tanggal</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stok as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->barang->barang_nama ?? '-' }}</td>
                <td>{{ $item->supplier->supplier_nama ?? '-' }}</td>
                <td>{{ $item->user->nama ?? '-' }}</td>
                <td>{{ $item->stok_tanggal }}</td>
                <td>{{ $item->stok_jumlah }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>