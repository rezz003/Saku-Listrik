<!DOCTYPE html>
<html>
<head>
    <title>Data Pembayaran</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Data Pembayaran</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Id Tagihan</th>
                <th>Id Pelanggan</th>
                <th>Id User</th>
                <th>Tanggal Pembayaran</th>
                <th>Biaya Admin</th>
                <th>Total Bayar</th>
                <th>Bukti Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembayaranData as $pembayaran)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pembayaran->id_tagihan }}</td>
                <td>{{ $pembayaran->id_pelanggan }}</td>
                <td>{{ $pembayaran->id_user }}</td>
                <td>{{ $pembayaran->tanggal_pembayaran }}</td>
                <td>{{ $pembayaran->biaya_admin }}</td>
                <td>{{ $pembayaran->total_bayar }}</td>
                <td>
                    @if($pembayaran->bukti_pembayaran)
                        <img src="{{ asset('storage/' . $pembayaran->bukti_pembayaran) }}" alt="Bukti Pembayaran" style="width: 100px; height: auto;">
                    @else
                        Tidak ada bukti pembayaran
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
