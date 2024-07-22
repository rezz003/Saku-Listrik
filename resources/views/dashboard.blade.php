<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    <div class="hero d-flex justify-content-center" style="height: 300px; background-color: rgb(58, 58, 138);">
        <img src="{{asset('img/poster-listrik.jpg')}}" alt="" style="height: 200px; width: 30%; border-radius: 12px; margin-top: 20px">
    </div>

    <div class="card-container d-flex justify-content-center" style="margin-top: -41px;">
    <div class="card" style="width: 60%; background-color: rgb(255, 255, 255);">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Cek Tagihan</button>
                
                <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Riwayat Pembayaran</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                <form method="GET" action="{{ route('cek.tagihan') }}" class="input-group mb-3 mt-3 w-50">
                    @csrf
                    <input type="search" id="search" name="search" class="form-control" placeholder="Masukan Nomor Kwh" aria-label="Nomor Kwh" aria-describedby="button-addon2" required>
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Cek Tagihan</button>
                </form>
            </div>
            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
                @if($historyPembayaran->isNotEmpty())
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama Pelanggan</th>
                                <th>Nomor KWH</th>
                                <th>Tanggal Pembayaran</th>
                                <th>Total Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($historyPembayaran as $pembayaranItem)
                                <tr>
                                    <td>{{ $pembayaranItem->pelanggan->nama_pelanggan }}</td>
                                    <td>{{ $pembayaranItem->pelanggan->nomor_kwh }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pembayaranItem->tanggal_pembayaran)->translatedFormat('Y F d') }}</td>
                                    <td>{{ $pembayaranItem->total_bayar }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Belum ada riwayat pembayaran.</p>
                @endif
            </div>
        </div>
    </div>
</div>

    <!-- modal tagihan -->
    @if(isset($searchPerformed) && $searchPerformed)
        <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true" role="dialog" style="display: block;">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tagihan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeModalButton"></button>
                    </div>
                    <div class="modal-body">
                        @if($tagihanData->isNotEmpty())
                            @foreach ($tagihanData as $tagihan)
                                @php
                                    $formattedDate = \Carbon\Carbon::parse($tagihan->tanggal_tagihan)->translatedFormat('Y F d');
                                    $tagihanStatus = $tagihan->status;
                                    $statusClass = 'btn-danger';
                                    if ($tagihan->status == 'Lunas') {
                                        $statusClass = 'btn-success';
                                    } elseif ($tagihan->status == 'Proses') {
                                        $statusClass = 'btn-warning';
                                    }

                                    if ($tagihan->status == 'Dibuat') {
                                        $tagihan->status = 'Belum Dibayar';
                                    } else {
                                        $tagihan->status = $tagihanStatus;
                                    }
                                    $disablePayButton = $tagihan->status == 'Lunas' || $tagihan->status == 'Proses';
                                @endphp
                                <h5>{{ $formattedDate }}</h5>
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td>Nomor KWH</td>
                                            <td>: {{ $tagihan->pelanggan->nomor_kwh }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nama</td>
                                            <td>: {{ $tagihan->pelanggan->nama_pelanggan }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tagihan</td>
                                            <td>: {{ $tagihan->total_tagihan }}</td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>: <button class="btn {{ $statusClass }}">{{ ucfirst($tagihan->status) }}</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="{{ route('pembayaran.create', ['tagihan' => $tagihan->id_tagihan]) }}" class="btn btn-primary @if($disablePayButton) disabled @endif">Bayar Tagihan</a>
                                <hr>
                            @endforeach
                        @else
                            <p>Tidak ada tagihan yang ditemukan.</p>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    
    @if(isset($searchPerformed) && $searchPerformed)
        <script>
            var myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {});
            document.addEventListener('DOMContentLoaded', function () {
                myModal.show();
            });
        </script>
    @endif

    @if(session('success'))
        <script>
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('dashboard') }}";
                }
            });
        </script>
    @endif

    <script>
        document.getElementById('closeModalButton').addEventListener('click', function() {
            window.location.href = "{{ url('dashboard') }}";
        });
    </script>
</body>
</html>
