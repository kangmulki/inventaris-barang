@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title" style="color: #000">Tambah Data Petugas</h4>

            <form action="{{ route('petugas.store') }}" method="POST" enctype="multipart/form-data" class="forms-sample">
                @csrf
                <div class="form-group">
                    <label for="exampleInputName1">Nama Petugas</label>
                    <input type="text" class="form-control  @error('name') is-invalid @enderror" name="name"
                        value="{{ old('name') }}" placeholder="Nama Lengkap Petugas" id="putih"
                        style="color: #000; background-color: #f5f5f5;">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail3">Email</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" placeholder="Masukan Email" id="putih"
                        style="color: #000; background-color: #f5f5f5;">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail3">Password</label>
                    <input type="text" class="form-control @error('password') is-invalid @enderror" name="password"
                        placeholder="Massukan Password" id="putih" style="color: #000; background-color: #f5f5f5;">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail3">Konfirmasi Password</label>
                    <input type="text" class="form-control @error('password') is-invalid @enderror"
                        placeholder="Masukan Konfirmasi Password" name="password_confirmation" id="putih"
                        style="color: #000; background-color: #f5f5f5;">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                <a href="{{ route('petugas.index') }}" class="btn btn-dark">Kembali</a>
            </form>
        </div>
    </div>
@endsection
