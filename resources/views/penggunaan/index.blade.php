<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Data Penggunaan') }}
    </h2>
</x-slot>
<div class="container d-flex justify-content-center mt-5">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Tambah Penggunaan
    </button>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Form Tambah Penggunaan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/penggunaan') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="">Pilih Nomor Kwh</label>
                            <select class="form-select form-select-md w-20" aria-label="Default select example" name='id_pelanggan'>
                                @foreach($pelangganData as $pelanggan)
                                    <option value="{{ $pelanggan->id_pelanggan }}">{{ $pelanggan->nomor_kwh }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_penggunaan" class="form-label">Tanggal Penggunaan</label>
                            <input type="datetime-local" id="tanggal_penggunaan" name="tanggal_penggunaan">
                        </div>
                        <div class="mb-3">
                            <label for="meteran_awal" class="form-label">Meteran Awal</label>
                            <input type="number" class="form-control" id="meteran_awal" name="meteran_awal" style="border-radius: 8px;">
                        </div>
                        <div class="mb-3">
                            <label for="meteran_akhir" class="form-label">Meteran Akhir</label>
                            <input type="number" class="form-control" id="meteran_akhir" name="meteran_akhir" style="border-radius: 8px;">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal -->
</div>


<div class="container w-70 d-flex justify-content-between align-items-end" style="height: 100px; text-decoration: underline;">
    <a href="{{url('tagihan')}}">Lihat Tagihan</a>
    <!-- <a href="{{url('tagihan')}}">Lihat Tagihan</a> -->
</div>

<div class="container d-flex justify-content-center">
    <table class="table mt-2 w-70 center">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Id Penggunaan</th>
                <th scope="col">Id Pelanggan</th>
                <th scope="col">Nama Pelanggan</th>
                <th scope="col">Nomor KWH</th>
                <th scope="col">Tanggal Penggunaan</th>
                <th scope="col">Meteran Awal</th>
                <th scope="col">Meteran Akhir</th>
                <th scope="col">Buat Tagihan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penggunaanData as $penggunaan)
                <tr>
                    <th scope="row">{{ $loop->iteration }} </th>
                    <td>{{ $penggunaan->id_penggunaan }}</td>
                    <td>{{ $penggunaan->id_pelanggan }}</td>
                    <td>{{ $penggunaan->pelanggan->nama_pelanggan }}</td>
                    <td>{{ $penggunaan->pelanggan->nomor_kwh }}</td>
                    <td>{{ $penggunaan->tanggal_penggunaan }}</td>
                    <td>{{ $penggunaan->meteran_awal }}</td>
                    <td>{{ $penggunaan->meteran_akhir }}</td>
                    <td>
                        @php
                            $tagihan = $penggunaan->tagihan;
                            $status = $tagihan ? $tagihan->status : null;
                        @endphp
                        @if($status == 'Lunas')
                            <button class="btn btn-success" disabled>Tagihan Sudah Dibayar</button>
                        @elseif($status == 'Proses')
                            <a href="{{url('pembayaran')}}"><button class="btn btn-warning" disabled>Cek Bukti Bayar</button></a>
                        @elseif($status == 'Dibuat')
                            <button class="btn btn-secondary" disabled>Tagihan Sedang Proses</button>
                        @else
                            <form action="{{ route('tagihan.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_pelanggan" value="{{ $penggunaan->id_pelanggan }}">
                                <input type="hidden" name="id_penggunaan" value="{{ $penggunaan->id_penggunaan }}">
                                <input type="datetime-local" name="tanggal_tagihan">
                                <button type="submit" class="btn btn-warning">Buat Tagihan</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</x-app-layout>
