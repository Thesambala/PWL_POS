<!DOCTYPE html>
<html>
<head>
    <title>Data Level Pengguna</title>
</head>
<body>
    <h1>Data Level Pengguna</h1>

    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Kode Level</th>
            <th>Nama Level</th>
        </tr>

        @if(isset($data) && count($data) > 0) 
            @foreach ($data as $d)
                <tr>
                    <td>{{ $d->level_id }}</td>
                    <td>{{ $d->level_kode }}</td>
                    <td>{{ $d->level_nama }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="3">Tidak ada data</td>
            </tr>
        @endif
    </table>
</body>
</html>