@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title" style="color: #000">Tambah Data Petugas</h4>

            <form action="{{ route('petugas.update', $petugas->id) }}" method="POST" enctype="multipart/form-data"
                class="forms-sample">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="exampleInputName1">Nama Petugas</label>
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="Nama Lengkap Petugas"
                        name="name" id="putih" style="color: #000; background-color: #f5f5f5;"
                        value="{{ $petugas->name }}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail3">Email</label>
                    <input type="text" class="form-control" id="exampleInputEmail3" placeholder="Masukan Email"
                        name="email" id="putih" style="color: #000; background-color: #f5f5f5;"
                        value="{{ $petugas->email }}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail3">Password</label>
                    <input type="text" class="form-control" id="exampleInputEmail3"
                        placeholder="Massukan Password Yang Baru (jika ada)" name="password" id="putih"
                        style="color: #000; background-color: #f5f5f5;">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail3">Konfirmasi Password</label>
                    <input type="text" class="form-control" id="exampleInputEmail3"
                        placeholder="Masukan Konfirmasi Password Yang Baru (jika ada)" name="password_confirmation"
                        id="putih" style="color: #000; background-color: #f5f5f5;">
                </div>
                <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                <a href="{{ route('petugas.index') }}" class="btn btn-dark">Kembali</a>
            </form>
        </div>
    </div>
@endsection
