@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title" style="color: #000">Tambah Data</h4>

            <form action="{{ route('peminjaman.store') }}" method="POST" enctype="multipart/form-data" class="forms-sample">
                @csrf
                <div class="form-group">
                    <label for="" class="form-label">Nama Barang</label>
                    <select name="id_barang" class="form-control" id=""
                        style="color: #000; background-color: #f5f5f5;">
                        <option selected disabled>- Pilih Barang -</option>
                        @foreach ($pusat as $data)
                            <option value="{{ $data->id }}">
                                {{ $data->nama }} - ({{ $data->merek }})
                            </option>
                        @endforeach
                    </select>
                </div>
                {{--   --}}
                <div class="form-group">
                    <label for="exampleInputEmail3">Jumlah</label>
                    <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="exampleInputEmail3"
                        placeholder="Jumlah" name="jumlah" style="color: #000; background-color: #f5f5f5;">
                    @error('jumlah')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword4">Tanggal Pinjam</label>
                    <input type="date" class="form-control @error('tgl_pinjam') is-invalid @enderror"
                        id="exampleInputPassword4" placeholder="Tanggal Pinjam" name="tgl_pinjam"
                        style="color: #000; background-color: #f5f5f5;">
                    @error('tgl_pinjam')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword4">Tanggal Kembali</label>
                    <input type="date" class="form-control @error('tgl_kembali') is-invalid @enderror"
                        id="exampleInputPassword4" placeholder="Tanggal Kembali" name="tgl_kembali"
                        style="color: #000; background-color: #f5f5f5;">
                    @error('tgl_kembali')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword4">Nama Peminjam</label>
                    <input type="text" class="form-control @error('nama_peminjam') is-invalid @enderror"
                        id="exampleInputPassword4" placeholder="Nama Peminjam" name="nama_peminjam"
                        style="color: #000; background-color: #f5f5f5;">
                    @error('nama_peminjam')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                <a href="{{ route('peminjaman.index') }}" class="btn btn-dark">Kembali</a>
            </form>
        </div>
    </div>
@endsection
