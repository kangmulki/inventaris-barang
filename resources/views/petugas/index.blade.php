@extends('layouts.admin')
@section('content')
    <center>
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h2>Halaman Data Petugas</h2>
                    </div>
                </div>
            </div>
        </div>
    </center>
    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <h4 class="card-title" style="color: #000">
                Daftar Petugas
            </h4>

            {{-- INI UNTUK BAGIAN BUTTON EXPORT --}}
            {{-- <div class="row mt-3 mr-2" style="gap: 10px">
                <a href="{{ route('petugas.index', ['download_pdf']) }}" class="btn btn-danger ">Buat PDF</a>
                <a href="{{ route('petugas.index', ['download_excel' => true]) }}" class="btn btn-success"
                    type="submit">Buat
                    EXCEL</a>
            </div> --}}

            <a href="{{ route('petugas.create') }}" class="btn btn-info mt-3" style="float: right;">Tambah Data</a>

            {{-- <input type="text" class="form-control" id="exampleInputName1" placeholder="Nama Barang" name="nama" id="putih" style="color: #000; background-color: #f5f5f5;"> --}}
            Cari Nama : <input type="text" placeholder=" cari nama petugas" class="mt-3 mb-2" id="myInput"
                style="color: #000; background-color: #f5f5f5;  border-color: #000; ">
            <div class="table-responsive">
                <table class="table" id="example">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Petuags</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($petugas as $data)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->email }}</td>
                                <td>
                                    <form action="{{ route('petugas.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('petugas.edit', $data->id) }}" class="btn btn-success">Ubah</a>
                                        {{-- <a href="{{ route('petugas.show', $data->id) }}" class="btn btn-warning">Show</a> --}}
                                        <a href="{{ route('petugas.destroy', $data->id) }}" type="submit"
                                            class="btn btn-danger" data-confirm-delete="true">
                                            Hapus
                                        </a>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
