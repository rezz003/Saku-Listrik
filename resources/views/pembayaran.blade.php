<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary" style="height: 100px;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar w/ text</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{url('/dashboard')}}">Home</a>
                    </li>
                </ul>
                <ul class="navbar-nav mx-5">
                    <li class="nav-item dropdown mx-5">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('/profile') }}">{{ __('Profile') }}</a></li>
                            <li><a class="dropdown-item" href="{{ url('/logout') }}">
                                <form method="POST" action="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                    @csrf
                                    {{ __('Log Out') }}
                                </form>
                            </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="d-flex justify-content-center mt-3">
    <div class="card w-50 ">
      <div class="card-header text-center">
        Form Pembayaran
      </div>
      <div class="card-body">
        <h5 class="card-title">Cek Kebenaran Data Anda</h5>
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
            <button type="button" class="btn btn-danger" id="cancelPayment">Cancel</button>
        </form>
    </div>
    </div>
    </div>
     
   


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.getElementById('cancelPayment').addEventListener('click', function() {
            window.location.href = "{{ url('dashboard') }}";
        });
    </script>
</body>
</html>
