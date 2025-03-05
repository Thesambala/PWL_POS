<!DOCTYPE html>
<html>
<head>
    <title>Data User</title>
</head>
<body>
    <h2><b>Data User</b></h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <td>ID</td>
            <td>Username</td>
            <td>Nama</td>
            <td>ID Level Pengguna</td>
        </tr>
        <tr>
            <td>{{ $data->user_id }}</td>
            <td>{{ $data->username }}</td>
            <td>{{ $data->nama }}</td>
            <td>{{ $data->level_id }}</td>
        </tr>
    </table>
</body>
</html>