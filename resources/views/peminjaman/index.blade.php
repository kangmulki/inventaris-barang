@extends('layouts.admin')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
@endsection
@section('content')
    <center>
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h2>Halaman Data Peminjaman</h2>
                    </div>
                </div>
            </div>
        </div>
    </center>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title" style="color: #000">
                Data Barang Peminjaman
            </h4>

            {{-- INI BAGIAN UNTUK FILTER --}}
            <form action="{{ route('peminjaman.index') }}" method="GET">
                <div class="row ml-2" style="gap: 10px;">
                    <input type="date" class="" name="tanggal_awal" value="{{ request('tanggal_awal') }}" required>
                    <input type="date" class="" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
                        required>
                    <button class="btn btn-primary " type="submit">Filter</button>
                    <a href="{{ route('peminjaman.index') }}" class="btn btn-danger " type="submit">Reset</a>
                </div>
            </form>

            {{-- INI UNTUK BAGIAN BUTTON EXPORT --}}
            <div class="row mt-3 ml-1" style="gap: 10px">
                @if (!$pinjam->isEmpty())
                    <a href="{{ route('peminjaman.index', ['download_pdf' => true, 'tanggal_awal' => request('tanggal_awal'), 'tanggal_akhir' => request('tanggal_akhir')]) }}"
                        class="btn btn-danger ">Buat
                        PDF</a>
                    <a href="{{ route('peminjaman.index', ['download_excel' => true, 'tanggal_awal' => request('tanggal_awal'), 'tanggal_akhir' => request('tanggal_akhir')]) }}"
                        class="btn btn-success " type="submit">Buat EXCEL</a>
                @endif
            </div>


            <a href="{{ route('peminjaman.create') }}" class="btn btn-md btn-info" style="float: right">Tambah Data</a>


            {{-- INI BUAT SEACRH --}}
            Cari : <input type="text" placeholder="cari barang" class="mt-3 mb-2" id="myInput"
                style="color: #000; background-color: #f5f5f5;  border-color: #000; ">

            @if ($pinjam->isEmpty())
                <div class="alert alert-warning mt-3" role="alert">
                    Tidak ada data barang peminjaman ditemukan untuk tanggal yang dipilih.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table" id="example">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Nama Peminjam</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($pinjam as $data)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data->pusat->nama }}</td>
                                    <td>{{ $data->jumlah }}</td>
                                    <td>{{ $data->formatted_tanggal_pinjam }}</td>
                                    <td>{{ $data->formatted_tanggal_kembali }}</td>
                                    <td>{{ $data->nama_peminjam }}</td>
                                    <td>{{ $data->status }}</td>
                                    <td>
                                        <form action="{{ route('peminjaman.destroy', $data->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('peminjaman.edit', $data->id) }}"
                                                class="btn btn-success">Ubah</a>
                                            {{-- <a href="{{ route('peminjaman.show', $data->id) }}"
                                            class="btn btn-warning">Show</a> --}}
                                            <a href="{{ route('peminjaman.destroy', $data->id) }}" type="submit"
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
            @endif
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script> --}}
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script> --}}
    <script>
        new DataTable('#example', {
            layout: {
                topStart: {
                    buttons: [0]
                }
            }
        });
    </script>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endpush