<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Customer') }}
        </h2>
    </x-slot>
    <div class="container d-flex justify-content-center">
    <table class="table mt-5 w-70 center">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Tanggal Dibuat</th>
      <th scope="col">Tanggal Update</th>
    </tr>
  </thead>
  <tbody>
      @foreach($customerData as $customer)
    <tr>
      <th scope="row">{{ $customer->id }} </th>
      <td>{{ $customer->name }}</td>
      <td>{{ $customer->email }}</td>
      <td>{{ $customer->created_at }}</td>
      <td>{{ $customer->updated_at }}</td>
    </tr>
    @endforeach
  </tbody>
  </div>
</table>
</x-app-layout>






