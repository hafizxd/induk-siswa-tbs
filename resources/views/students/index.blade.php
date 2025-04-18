@extends('layouts.app')

@push('style')
    <style>
        th {
            white-space: nowrap !important;
        }
    </style>
@endpush

@section('content')
    <ol class="breadcrumb p-l-0">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Siswa</li>
    </ol>

    <div class="row">
        <div class="col-md-12 project-list">
            <div class="card">
                <div class="row">
                    <div class="col-md-6 d-flex mt-2 p-0">
                        <h4>Data Siswa</h4>
                    </div>
                    <div class="col-md-6 p-0">
                        <a href="{{ route('students.create') }}" class="btn btn-primary btn-sm ms-2"><i class="fa fa-plus-circle"></i> Tambah</a>
                        <button onclick="exportPage()" class="btn btn-success btn-sm ms-2" style="float: right;"><i class="fa fa-download"></i> Export</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="filter">
                        <h6 class="text-primary">Filter</h6>
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="">Tahun Masuk</label>
                                    <div class="row" style="align-items: center;">
                                        <div class="col-sm-5">
                                            <select id="tahunMasukStart" class="selectpicker form-control">
                                                <option value="">-- Pilih Tahun Masuk Awal --</option>
                                                @for($i= intval(date('Y')); $i > 2000; $i--) 
                                                    <option value="{{ $i }}">{{ $i }}</option>   
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-sm-1 text-center">-</div>
                                        <div class="col-sm-5">
                                            <select id="tahunMasukEnd" class="selectpicker form-control">
                                                <option value="">-- Pilih Tahun Masuk Akhir --</option>
                                                @for($i= intval(date('Y')); $i > 2000; $i--) 
                                                    <option value="{{ $i }}">{{ $i }}</option>   
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="">Tahun Mutasi</label>
                                    <div class="row" style="align-items: center;">
                                        <div class="col-sm-5">
                                            <select id="tahunMutasiStart" class="selectpicker form-control">
                                                <option value="">-- Pilih Tahun Mutasi Awal --</option>
                                                @for($i= intval(date('Y')); $i > 2000; $i--) 
                                                    <option value="{{ $i }}">{{ $i }}</option>   
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-sm-1 text-center">-</div>
                                        <div class="col-sm-5">
                                            <select id="tahunMutasiEnd" class="selectpicker form-control">
                                                <option value="">-- Pilih Tahun Mutasi Akhir --</option>
                                                @for($i= intval(date('Y')); $i > 2000; $i--) 
                                                    <option value="{{ $i }}">{{ $i }}</option>   
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="">Kelas - Kelompok</label>
                                    <div class="row" style="align-items: center;">
                                        <select id="class" onchange="reloadDatatable()" class="selectpicker form-control">
                                            <option value="">-- Pilih Kelas --</option>
                                            <option value="7-A">7-A</option>
                                            <option value="7-B">7-B</option>
                                            <option value="7-C">7-C</option>
                                            <option value="8-A">8-A</option>
                                            <option value="8-B">8-B</option>
                                            <option value="8-C">8-C</option>
                                            <option value="9-A">9-A</option>
                                            <option value="9-B">9-B</option>
                                            <option value="9-C">9-C</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <table class="display cell-border stripe" id="mytable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>NIS</th>
                                    <th style="min-width: 200px;">Nama Siswa</th>
                                    <th>NISN</th>
                                    <th>NIK</th>
                                    <th>Tahun Masuk</th>
                                    <th>Tahun Mutasi</th>
                                    <th>Status Mutasi</th>
                                    <th>Kelas 7 - Absen</th>
                                    <th>Kelas 8 - Absen</th>
                                    <th>Kelas 9 - Absen</th>
                                    <th>Tempat Lahir</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Status Asal Pendaftar</th>
                                    <th>Asal Sekolah</th>
                                    <th>Prasekolah</th>
                                    <th>Nama Kepala Keluarga</th>
                                    <th>Yang Membiayai</th>
                                    <th>Kewarganegaraan</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Nomor KIP</th>
                                    <th>Nomor KK</th>
                                    <th>Nomor HP Siswa</th>
                                    <th>Nomor Test</th>
                                    <th>Pondok Pesantren</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end me-4 mt-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#mytable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('students.datatables') }}",
                    type: "GET",
                    data: function (d) {
                        d.masukStart = $('#tahunMasukStart').val();
                        d.masukEnd = $('#tahunMasukEnd').val();
                        d.mutasiStart = $('#tahunMutasiStart').val();
                        d.mutasiEnd = $('#tahunMutasiEnd').val();
                        d.class = $('#class').val();
                    },
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'nis', name: 'nis' },
                    { data: 'nama_lengkap', name: 'nama_lengkap' },
                    { data: 'nisn', name: 'nisn' },
                    { data: 'nik', name: 'nik' },
                    { data: 'tahun_masuk', name: 'tahun_masuk' },
                    { data: 'tahun_mutasi', name: 'tahun_mutasi' },
                    { data: 'status_mutasi', name: 'status_mutasi' },
                    { data: 'kelas_abs_7', name: 'kelas_abs_7' },
                    { data: 'kelas_abs_8', name: 'kelas_abs_8' },
                    { data: 'kelas_abs_9', name: 'kelas_abs_9' },
                    { data: 'tempat_lahir', name: 'tempat_lahir' },
                    { data: 'tanggal_lahir', name: 'tanggal_lahir' },
                    { data: 'status_pendaftar', name: 'status_pendaftar' },
                    { data: 'asal_sekolah', name: 'asal_sekolah' },
                    { data: 'prasekolah', name: 'prasekolah' },
                    { data: 'nama_kepala_keluarga', name: 'nama_kepala_keluarga' },
                    { data: 'yang_membiayai', name: 'yang_membiayai' },
                    { data: 'kewarganegaraan', name: 'kewarganegaraan' },
                    { data: 'jenis_kelamin', name: 'jenis_kelamin' },
                    { data: 'nomor_kip', name: 'nomor_kip' },
                    { data: 'nomor_kk', name: 'nomor_kk' },
                    { data: 'nomor_hp', name: 'nomor_hp' },
                    { data: 'nomor_test', name: 'nomor_test' },
                    { data: 'pondok_pesantren', name: 'pondok_pesantren' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                columnDefs: [
                    { target: [0, 5, 6, 8, 9, 10], className: 'text-center' }
                ],
                order: [
                    [5, 'desc'],
                    [10, 'asc'],
                    [9, 'asc'],
                    [8, 'asc'],
                ],
                scrollX: true,
                fixedColumns: {
                    leftColumns: 3,
                    rightColumns: 1
                },
                pageLength: 10
            });

            $("#tahunMasukStart").change(function () {
                let val = $("#tahunMasukEnd").val();
                if ($(this).val() != "") {
                    if (val == "" || parseInt(val, 10) < $(this).val()) {
                        $("#tahunMasukEnd").val($(this).val()).trigger("change");
                    }
                }

                reloadDatatable()
            })

            $("#tahunMasukEnd").change(function () {
                let val = $("#tahunMasukStart").val();
                if ($(this).val() != "") {
                    if (val == "" || parseInt(val, 10) > $(this).val()) {
                        $("#tahunMasukStart").val($(this).val()).trigger("change");
                    }
                }

                reloadDatatable()
            })

            $("#tahunMutasiStart").change(function () {
                let val = $("#tahunMutasiEnd").val();
                if ($(this).val() != "") {
                    if (val == "" || parseInt(val, 10) < $(this).val()) {
                        $("#tahunMutasiEnd").val($(this).val()).trigger("change");
                    }
                }

                reloadDatatable()
            })

            $("#tahunMutasiEnd").change(function () {
                let val = $("#tahunMutasiStart").val();
                if ($(this).val() != "") {
                    if (val == "" || parseInt(val, 10) > $(this).val()) {
                        $("#tahunMutasiStart").val($(this).val()).trigger("change");
                    }
                }

                reloadDatatable()
            })
        });

        function reloadDatatable() {
            $('#mytable').DataTable().ajax.reload()
        }

        function exportPage() {
            masukStart = $("#tahunMasukStart").val();
            masukEnd = $("#tahunMasukEnd").val();
            mutasiStart = $("#tahunMutasiStart").val();
            mutasiEnd = $("#tahunMutasiEnd").val();
            classKel = $("#class").val();

            window.location = "{{ route('export.student') }}?masukStart="+masukStart+"&masukEnd="+masukEnd+"&mutasiStart="+mutasiStart+"&mutasiEnd="+mutasiEnd+"&class="+classKel
        }
    </script>
@endpush
