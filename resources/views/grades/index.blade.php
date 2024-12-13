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
        <li class="breadcrumb-item active">Nilai</li>
    </ol>

    <div class="row">
        <div class="col-md-12 project-list">
            <div class="card">
                <div class="row">
                    <div class="col-md-6 d-flex mt-2 p-0">
                        <h4>Data Nilai</h4>
                    </div>
                    <div class="col-md-6 p-0">
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
                        <table class="display cell-border nowrap stripe" id="mytable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    @foreach ($subjects as $subject)
                                        <th>{{ $subject->name }}</th>
                                    @endforeach
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
                    url: "{{ route('grades.datatables', request()->route('type')) }}",
                    type: "POST",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
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
                    @foreach ($subjects as $subject)
                        { data: '{{ $subject->name }}', name: '{{ $subject->name }}', searchable: false },
                    @endforeach
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                columnDefs: [
                    { target: [0], className: 'text-center' }
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

            window.location = "{{ route('export.index') }}?masukStart="+masukStart+"&masukEnd="+masukEnd+"&mutasiStart="+mutasiStart+"&mutasiEnd="+mutasiEnd+"&class="+classKel
        }
    </script>
@endpush
