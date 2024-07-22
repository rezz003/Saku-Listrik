<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Data tagihan') }}
    </h2>
</x-slot>

<div class="d-flex align-items-center justify-content-between mt-5 " style="width:92%;">
    <div class="align-self-center ">
    </div>
    <!-- search input -->
    <form action="{{ route('tagihan.search') }}" method="GET" class="input-group w-25 input-group-sm">
        <input type="search" name="search" class="form-control" placeholder="nomor kwh" aria-label="Example text with button addon" aria-describedby="button-addon1">
        <button class="btn btn-outline-secondary" type="submit" id="button-addon1">Cari</button>
    </form>
</div>


<div class="container d-flex justify-content-center">
    <table class="table  w-70 center">
        <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Id Tagihan</th>
            <th scope="col">Id Penggunaan</th>
            <th scope="col">Nomor Kwh</th>
            <th scope="col">Tanggal Tagihan</th>
            <th scope="col">Jumlah Kwh</th>
            <th scope="col">Total Tagihan</th>
            <th scope="col">Status Tagihan</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tagihanData as $tagihan)
    <tr>
        <th scope="row">{{ $loop->iteration }}</th>
        <td>{{ $tagihan->id_tagihan }}</td>
        <td>{{ $tagihan->id_penggunaan }}</td>
        <td>{{ $tagihan->pelanggan->nomor_kwh }}</td>
        <td>{{ $tagihan->tanggal_tagihan }}</td>
        <td>{{ $tagihan->jumlah_kwh }}</td>
        <td>{{ "Rp " . number_format($tagihan->total_tagihan, 2, ',', '.') }}</td>
        <td>{{ $tagihan->status }}</td>
        <td>
            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $tagihan->id_tagihan }}">Edit</button>
            <button class="btn btn-danger delete-tagihan" data-id="{{ $tagihan->id_tagihan }}">Hapus</button>
        </td>
    </tr>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal{{ $tagihan->id_tagihan }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit Tagihan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tagihan.update', $tagihan->id_tagihan) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="tanggal_tagihan" class="form-label">Tanggal Tagihan</label>
                            <input type="date" class="form-control" id="tanggal_tagihan" name="tanggal_tagihan" value="{{ $tagihan->tanggal_tagihan }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_kwh" class="form-label">Jumlah Kwh</label>
                            <input type="number" class="form-control" id="jumlah_kwh" name="jumlah_kwh" value="{{ $tagihan->jumlah_kwh }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="total_tagihan" class="form-label">Total Tagihan</label>
                            <input type="number" class="form-control" id="total_tagihan" name="total_tagihan" value="{{ $tagihan->total_tagihan }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="Belum Dibayar" {{ $tagihan->status == 'Belum Dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
                                <option value="Lunas" {{ $tagihan->status == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<!-- alert konfirmasi delete -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.delete-tagihan').forEach(button => {
        button.addEventListener('click', function () {
            var id = this.getAttribute('data-id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data tagihan ini akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        });
    });
</script>

@foreach($tagihanData as $tagihan)
    <form id="delete-form-{{ $tagihan->id_tagihan }}" action="{{ route('tagihan.destroy', $tagihan->id_tagihan) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endforeach
</x-app-layout>
