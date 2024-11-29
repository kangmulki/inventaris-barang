@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title" style="color: #000">Tambah Data</h4>

            <form action="{{ route('barangmasuk.store') }}" method="POST" enctype="multipart/form-data" class="forms-sample">
                @csrf
                <div class="form-group">
                    <label for="" class="form-label">Nama Barang</label>
                    <select name="id_barang" class="form-control" id=""
                        style="color: #000; background-color: #f5f5f5;">
                        <option selected disabled>- Pilih Barang -</option>
                        </option>
                        @foreach ($pusat as $data)
                            <option value="{{ $data->id }}">
                                {{ $data->nama }} - ({{ $data->merek }})
                            </option>
                        @endforeach
                    </select>
                </div>
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
                    <label for="exampleInputPassword4">Tanggal Masuk</label>
                    <input type="date" class="form-control @error('tgl_masuk') is-invalid @enderror"
                        id="exampleInputPassword4" placeholder="Tanggal Masuk" name="tgl_masuk"
                        style="color: #000; background-color: #f5f5f5;">
                    @error('tgl_masuk')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword4">Keterangan</label>
                    <input type="text" class="form-control @error('ket') is-invalid @enderror" id="exampleInputPassword4"
                        placeholder="Keterangan" name="ket" style="color: #000; background-color: #f5f5f5;">
                    @error('ket')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                <a href="{{ route('barangmasuk.index') }}" class="btn btn-dark">Kembali</a>
            </form>
        </div>
    </div>
@endsection
