<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Tarif') }}
        </h2>
    </x-slot>
    <div class="container d-flex justify-content-center mt-5">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
          Tambah Tarif
        </button>
    </div>
        
      <div class="container d-flex justify-content-start align-items-end w-50 mt-2 mb-2">
        <a href="{{url('admin/dashboard')}}" style="color: #6b6be2;">Kembali Ke Dashboard</a>
      </div>
    
      <div class="container d-flex justify-content-center">
    <table class="table mt-3 w-50 center">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Daya</th>
      <th scope="col">Tarif Per Kwh</th>
      <th scope="col">Action</th>
      

    </tr>
  </thead>
  <tbody>
      @foreach($tarifs as $tarif)
    <tr>
      <th scope="row">{{ $loop->iteration}} </th>
      <td>{{ $tarif->daya }} Watt</td>
      <td>{{ "Rp " . number_format($tarif->tarifperkwh,2,',','.') }}</td>
      <td>
        <button class="btn btn-danger delete-tarif" data-id="{{ $tarif->id_tarif }}">Hapus</button>
        <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{$tarif->id_tarif}}">Update</button>
      </td>
    </tr>
    @endforeach
  </tbody>
  </div>
</table>



 <!-- Modal -->
 <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Form Tambah Tarif</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="{{url('/tarif')}}" method="post">
                    @csrf
                    <div class="mb-3">
                      <label for="daya" class="form-label">Daya</label>
                      <input type="number" class="form-control" id="daya" name="daya" style="border-radius: 8px;">
                    </div>
                    <div class="mb-3">
                      <label for="tarifperkwh" class="form-label">Tarif Per Kwh</label>
                      <input type="number" class="form-control" id="tarifperkwh" name="tarifperkwh" style="border-radius: 8px;">
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


          <!-- Modal Update -->
          @foreach($tarifs as $tarif)
          <div class="modal fade" id="editModal{{$tarif->id_tarif}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="editModalLabel">Form Tambah Tarif</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="{{route('tarif.update',$tarif->id_tarif)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                      <label for="daya" class="form-label">Daya</label>
                      <input type="number" class="form-control" id="daya" name="daya" value="{{$tarif->daya}}" style="border-radius: 8px;" required>
                    </div>
                    <div class="mb-3">
                      <label for="tarifperkwh" class="form-label">Tarif Per Kwh</label>
                      <input type="number" class="form-control" id="tarifperkwh" name="tarifperkwh" value="{{$tarif->tarifperkwh}}" style="border-radius: 8px;" required>
                    </div>
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
                </form>
              </div>
            </div>
          </div>
          @endforeach
          <!-- End Modal Update -->


<!-- alert konfirmasi delete -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.delete-tarif').forEach(button => {
        button.addEventListener('click', function () {
            var id = this.getAttribute('data-id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Tarif ini akan dihapus!",
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

@foreach($tarifs as $tarif)
    <form id="delete-form-{{ $tarif->id_tarif }}" action="{{ route('tarif.destroy', $tarif->id_tarif) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endforeach

</x-app-layout>






