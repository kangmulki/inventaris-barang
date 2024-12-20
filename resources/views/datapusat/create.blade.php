@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title" style="color: #000">Tambah Data</h4>

            <form action="{{ route('datapusat.store') }}" method="POST" enctype="multipart/form-data" class="forms-sample">
                @csrf
                <div class="form-group">
                    <label for="exampleInputName1">Nama Barang</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="exampleInputName1"
                        placeholder="Nama Barang" name="nama" id="putih"
                        style="color: #000; background-color: #f5f5f5;">
                    @error('nama')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail3">Merek</label>
                    <input type="text" class="form-control @error('merek') is-invalid @enderror" id="exampleInputEmail3"
                        placeholder="Merek" name="merek" id="putih" style="color: #000; background-color: #f5f5f5;">
                    @error('merek')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail3">Foto</label>
                    <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto"
                        id="putih" style="color: #000; background-color: #f5f5f5;" accept="image/*">
                    @error('foto')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                <a href="{{ route('datapusat.index') }}" class="btn btn-dark">Kembali</a>
            </form>
        </div>
    </div>
@endsection
