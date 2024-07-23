<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Data Pembayaran') }}
    </h2>
</x-slot>

<div class="container d-flex justify-content-between align-items-center mt-5">
    <a href="{{ route('pembayaran.download') }}" class="btn btn-primary">Download PDF</a>
</div>

<div class="container d-flex justify-content-center">
<table class="table mt-5 w-70 center">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Id Tagihan</th>
      <th scope="col">Id Pelanggan</th>
      <th scope="col">Id User</th>
      <th scope="col">Tanggal Pembayaran</th>
      <th scope="col">Biaya Admin</th>
      <th scope="col">Total Bayar</th>
      <th scope="col">Bukti Bayar</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
      @foreach($pembayaranData as $pembayaran)
        @php
            $tagihan = $pembayaran->tagihan;
        @endphp
    <tr>
      <th scope="row">{{ $loop->iteration + ($pembayaranData->currentPage() - 1) * $pembayaranData->perPage() }} </th>
      <td>{{ $pembayaran->id_tagihan }}</td>
      <td>{{ $pembayaran->id_pelanggan }}</td>
      <td>{{ $pembayaran->id_user }}</td>
      <td>{{ $pembayaran->tanggal_pembayaran }}</td>
      <td>{{ $pembayaran->biaya_admin }}</td>
      <td>{{ $pembayaran->total_bayar }}</td>
      <td>
          @if($pembayaran->bukti_pembayaran)
          <img src="{{ asset('storage/' . $pembayaran->bukti_pembayaran) }}" alt="Bukti Pembayaran" style="width: 300px; height: auto;">
            @else
            Tidak ada bukti pembayaran
            @endif
      </td>
      <td>
        <button class="btn btn-danger delete-pembayaran" data-id="{{ $pembayaran->id_pembayaran }}">Hapus</button>
        @if($tagihan->status == 'Lunas')
            <button class="btn btn-success" disabled>Lunas</button>
        @else
            <form action="{{ route('pembayaran.confirm', $pembayaran->id_pembayaran) }}" method="POST" style="display: inline;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-warning">Konfirmasi</button>
            </form>
        @endif
    </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>


<div class="container d-flex justify-content-center mt-4">
        {{ $pembayaranData->links() }}
    </div>

<!-- alert konfirmasi delete -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.delete-pembayaran').forEach(button => {
        button.addEventListener('click', function () {
            var id = this.getAttribute('data-id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data pembayaran ini akan dihapus!",
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

@foreach($pembayaranData as $pembayaran)
    <form id="delete-form-{{ $pembayaran->id_pembayaran }}" action="{{ route('pembayaran.destroy', $pembayaran->id_pembayaran) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endforeach
</x-app-layout>
