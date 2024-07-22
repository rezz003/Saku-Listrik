<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="container mt-5">
  <div class="row">
    <div class="col">
      <!-- card tarif -->
       <a href="{{ url('/tarif') }}">
      <div class="card mt-5" style="width: 18rem;">
        <div class="card-body">
          <h5 class="card-title">Tarif</h5>
          <h6>{{$tarifCount}} Tipe</h6>
        </div>
      </div>
      </a>
      <!-- end card tarif -->
    </div>
    <div class="col-6">
      <!-- card pelanggan -->
       <a href="{{url('/pelanggan')}}">
      <div class="card mt-5">
        <div class="card-body">
          <h5 class="card-title">Pelanggan</h5>
          <h6>{{$pelangganCount}} Pelanggan</h6>
        </div>
      </div>
      </a>
      <!-- end card pelanggan -->
    </div>
    <div class="col">
       <!-- card penggunaan -->
        <a href="{{url('/penggunaan')}}">
       <div class="card mt-5" style="width: 18rem;">
        <div class="card-body">
          <h5 class="card-title">Penggunaan</h5>
          <h6>{{$penggunaanCount}} penggunaan</h6>
        </div>
      </div>
      </a>
      <!-- end card penggunaan -->
    </div>
  </div>
  <div class="row">
    <div class="col">
       <!-- card tagihan -->
        <a href="{{url('/tagihan')}}">
       <div class="card mt-5" style="width: 18rem;">
        <div class="card-body">
          <h5 class="card-title">Tagihan</h5>
          <h6>{{$tagihanCount}} Tagihan</h6>
        </div>
      </div>
      </a>
      <!-- end card tagihan -->
    </div>
    <div class="col-5">
      <!-- card pembayaran -->
       <a href="{{url('/pembayaran')}}">
      <div class="card mt-5">
        <div class="card-body">
          <h5 class="card-title">Pembayaran</h5>
          <h6>{{$pembayaranCount}} pembayaran</h6>
        </div>
      </div>
      </a>
      <!-- end card pembayaran --> 
    </div>
    <div class="col">
       <!-- card customer -->
        <a href="{{url('/customer')}}">
       <div class="card mt-5" style="width: 18rem;">
        <div class="card-body">
          <h5 class="card-title">customer Account</h5>
          <h6>{{$customerCount}} account</h6>
        </div>
      </div>
      </a>
      <!-- end card customer -->
    </div>
  </div>
</div>





 
</x-app-layout>


