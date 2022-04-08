@extends('mahasiswa.layout')
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="d-flex justify-content-center my-3">
            <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
        </div>
        <div class="float-right">
            <a class="btn btn-success" href="{{ route('mahasiswa.create') }}"> Input Mahasiswa</a>
        </div>

        <div class="float-left my-2">
            <!-- Tugas Praktikum 7 No 3 -->
            <form class="form" method="get" action="{{ route('search') }}">
                <div class="input-group">
                    <input type="search" name="search" class="form-control mr-3 rounded" placeholder="Nama" aria-label="Search" aria-describedby="search-addon" />
                    <button type="submit" class="btn btn-outline-success">Search</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif

<table class="table table-bordered">
    <tr>
        <th>Nim</th>
        <th>Nama</th>
        <th>Kelas</th>
        <th>Jurusan</th>

        <!-- Tugas Praktikum 7 No 1 -->
        <th>Email</th>
        <th>Alamat</th>
        <th>Tanggal Lahir</th>
        <th width="280px">Action</th>
    </tr>
    @foreach ($mahasiswa as $mhs)
    <tr>

        <td>{{ $mhs ->nim }}</td>
        <td>{{ $mhs ->nama }}</td>
        <td>{{ $mhs ->kelas }}</td>
        <td>{{ $mhs ->jurusan }}</td>

        <!-- Tugas Praktikum 7 No 1 -->
        <td>{{ $mhs ->email }}</td>
        <td>{{ $mhs ->alamat }}</td>
        <td>{{ Carbon\Carbon::parse($mhs ->tanggal_lahir)->format('d-m-Y') }}</td>
        <td>
            <form action="{{ route('mahasiswa.destroy',['mahasiswa'=>$mhs->nim]) }}" method="POST">

                <a class="btn btn-info" href="{{ route('mahasiswa.show',$mhs->nim) }}">Show</a>
                <a class="btn btn-primary" href="{{ route('mahasiswa.edit',$mhs->nim) }}">Edit</a>
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
<!-- Tugas Praktikum 7 No 2 -->
{{ $mahasiswa->links() }}

@endsection