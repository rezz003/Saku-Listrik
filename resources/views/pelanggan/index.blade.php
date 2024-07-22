<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Pelanggan') }}
        </h2>
    </x-slot>
    <div class="container d-flex justify-content-center mt-5">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
          Tambah Pelanggan
        </button>
        <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Form Tambah Pelanggan</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="{{url('/pelanggan')}}" method="post">
                    @csrf
                    <div class="mb-3">
                      <label for="username" class="form-label">username</label>
                      <input type="text" class="form-control" id="username" name="username" style="border-radius: 8px;">
                    </div>
                    <div class="mb-3">
                      <label for="nomor_kwh" class="form-label">Nomor Kwh</label>
                      <input type="number" class="form-control" id="nomor_kwh" name="nomor_kwh" style="border-radius: 8px;">
                    </div>
                    <div class="mb-3">
                      <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                      <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" style="border-radius: 8px;">
                    </div>
                    <div class="mb-3">
                      <label for="alamat" class="form-label">Alamat</label>
                      <input type="text" class="form-control" id="alamat" name="alamat" style="border-radius: 8px;">
                    </div>
                    <div class="mb-3">
                      <label for="id_tarif">Daya</label>
                    <select class="form-select form-select-md w-20" aria-label="Default select example" name='id_tarif'>
                        @foreach($tarifs as $tarif)
                          <option value="{{ $tarif->id_tarif }}" >{{ $tarif->daya }} Watt</option>
                        @endforeach
                    </select>
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

    <div class="container d-flex justify-content-end align-content-end flex-wrap w-75" style="height: 30px;">
        <div>
            <form action="{{ route('pelanggan.index') }}" method="GET">
                <select name="daya" id="daya" class="form-select" onchange="this.form.submit()">
                    <option value="" selected>Pilih Daya</option>
                    @foreach($dayaOptions as $daya)
                        <option value="{{ $daya }}" {{ request('daya') == $daya ? 'selected' : '' }}>{{ $daya }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
    <div class="container d-flex justify-content-center">
    <table class="table mt-2  w-75 center">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Username</th>
      <th scope="col">Nomor Kwh</th>
      <th scope="col">Nama Pelanggan</th>
      <th scope="col">Alamat Pelanggan</th>
      <th scope="col">Daya</th>
      <th scope="col">Action</th>

    </tr>
  </thead>
  <tbody>
      @foreach($pelangganData as $pelanggan)
    <tr>
      <th scope="row">{{ $pelanggan->id_pelanggan }} </th>
      <td>{{ $pelanggan->username }}</td>
      <td>{{ $pelanggan->nomor_kwh }}</td>
      <td>{{ $pelanggan->nama_pelanggan}}</td>
      <td>{{ $pelanggan->alamat}}</td>
      <td>{{$pelanggan->tarif->daya}} Watt</td>
      <td>
      <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $pelanggan->id_pelanggan }}">Edit</button>
      <button class="btn btn-danger delete-pelanggan" data-id="{{ $pelanggan->id_pelanggan }}">Hapus</button>
      </td>
    </tr>
    @endforeach
  </tbody>
  </div>
</table>


<!-- Modal Update -->
@foreach($pelangganData as $pelanggan)
<div class="modal fade" id="editModal{{$pelanggan->id_pelanggan}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="editModalLabel">Form Update Pelanggan</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="{{ route('pelanggan.update', $pelanggan->id_pelanggan) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                      <label for="username" class="form-label">username</label>
                      <input type="text" class="form-control" id="username" name="username" value="{{$pelanggan->username}}" style="border-radius: 8px;">
                    </div>
                    <div class="mb-3">
                      <label for="nomor_kwh" class="form-label">Nomor Kwh</label>
                      <input type="number" class="form-control" id="nomor_kwh" name="nomor_kwh" value="{{$pelanggan->nomor_kwh}}" style="border-radius: 8px;">
                    </div>
                    <div class="mb-3">
                      <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                      <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" value="{{$pelanggan->nama_pelanggan}}" style="border-radius: 8px;">
                    </div>
                    <div class="mb-3">
                      <label for="alamat" class="form-label">Alamat</label>
                      <input type="text" class="form-control" id="alamat" name="alamat" value="{{$pelanggan->alamat}}" style="border-radius: 8px;">
                    </div>
                    <div class="mb-3">
                      <label for="id_tarif">Daya</label>
                    <select class="form-select form-select-md w-20" aria-label="Default select example" name='id_tarif'>
                      <option value="{{$pelanggan->id_tarif}}"  >{{$pelanggan->tarif->daya}} Watt</option>
                        @foreach($tarifs as $tarif)
                          <option value="{{ $tarif->id_tarif }}" >{{ $tarif->daya }} Watt</option>
                        @endforeach
                    </select>
                    </div>
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-warning">Update</button>
                </div>
                </form>
              </div>
            </div>
          </div>
          @endforeach
<!-- Modal Update End -->


<!-- alert konfirmasi delete -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.delete-pelanggan').forEach(button => {
        button.addEventListener('click', function () {
            var id = this.getAttribute('data-id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data pelanggan ini akan dihapus!",
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

@foreach($pelangganData as $pelanggan)
    <form id="delete-form-{{ $pelanggan->id_pelanggan }}" action="{{ route('pelanggan.destroy', $pelanggan->id_pelanggan) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endforeach
</x-app-layout>