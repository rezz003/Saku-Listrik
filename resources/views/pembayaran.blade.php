<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <p>Cek data anda terlebih dahulu</p>
        <p>Nomor Kwh : {{ $tagihan->pelanggan->nomor_kwh }}</p>
        <p>Jumlah Kwh : {{ $tagihan->jumlah_kwh }}</p>
        <p>Nama Pelanggan : {{ $tagihan->pelanggan->nama_pelanggan }}</p>
        <p>Total Tagihan : {{ $tagihan->total_tagihan }}</p>
        <hr>
        <form action="{{ route('pembayaran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_tagihan" value="{{ $tagihan->id_tagihan }}">
            <input type="hidden" name="id_pelanggan" value="{{ $tagihan->pelanggan->id_pelanggan }}">
            <input type="hidden" name="id_user" value="{{ Auth::user()->id }}"> 
            <input type="hidden" name="tanggal_pembayaran" value="{{ now() }}">
            <input type="hidden" name="total_tagihan" value="{{ $tagihan->total_tagihan }}">
            <div class="mb-3">
                <label for="biaya_admin" class="form-label">Biaya Admin</label>
                <input type="number" name="biaya_admin" value="2500" class="form-control" readonly>
            </div>
            <div class="mb-3">
                <label for="total_bayar" class="form-label">Total Bayar</label>
                <input type="number" name="total_bayar" value="{{ $tagihan->total_tagihan + 2500 }}" class="form-control" readonly>
            </div>
            <div class="mb-3">
                <label for="bukti_pembayaran" class="form-label">Bukti Pembayaran</label>
                <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
