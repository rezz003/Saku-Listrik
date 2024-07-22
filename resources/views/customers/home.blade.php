<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Dashboard</title>
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
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
            </ul>
            <ul class="navbar-nav mx-5" >
                <li class="nav-item dropdown mx-5 ">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="{{url('/profile')}}">{{ __('Profile') }}</a></li>
                      <li><a class="dropdown-item" href="{{url('/logout')}}">
                      <form method="POST" action="{{ route('logout') }}" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            @csrf
                            {{ __('Log Out') }}
                        </form>
                      </a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                  </li>
            </ul>
          </div>
        </div>
      </nav>

      <div class="hero d-flex justify-content-center " style="height: 300px; background-color: rgb(58, 58, 138);">

        <div class="hero-img" style="height: 200px; width: 30%; background-color: aliceblue; border-radius: 12px; margin-top: 20px;"></div>
        
      </div>

      <div class="card-container d-flex justify-content-center" style="margin-top: -41px;">
      <div class="card" style="width: 60%; background-color: rgb(255, 255, 255);">

        <div>
            <div class="nav nav-tabs " id="nav-tab" role="tablist">
              <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Cek Tagihan</button>
              <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Cek Status Tagihan</button>
              <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Riwayat Pembayaran</button>
            </div>
        </div>
          <div class="tab-content " id="nav-tabContent">
            <div class="tab-pane fade show active d-flex flex-column align-items-center " id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                    <form method="" action=""  class="input-group mb-3 mt-3 w-50">
                        @csrf
                        <input type="search" id="search" name="nomor_kwh" class="form-control" placeholder="Masukan Nomor Kwh" aria-label="Nomor Kwh" aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2" data-bs-toggle="modal" data-bs-target="#exampleModal">Cek Tagihan</button>
                    </form>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">...</div>
            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">...</div>
            <div class="tab-pane fade" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab" tabindex="0">...</div>
          </div>

      </div>
    </div>
     
    <!-- modal tagihan -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tagihan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- @if (isset($tagihanData))
                        @if ($tagihanData->isEmpty())
                            <p>Tidak ada tagihan untuk nomor KWH tersebut.</p>
                        @else
                            @foreach ($tagihanData as $tagihan)
                                <p>Nomor KWH: {{ $tagihan->pelanggan->nomor_kwh }}</p>
                                <p>Nama: {{ $tagihan->pelanggan->nama }}</p>
                                <p>Tagihan: {{ $tagihan->total_tagihan }}</p>
                                <hr>
                            @endforeach
                        @endif
                    @else
                        <p>Silahkan masukkan nomor KWH untuk melihat tagihan.</p>
                    @endif -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
