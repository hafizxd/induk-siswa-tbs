@extends('layouts.app')

@push('style')
    <style>
        .mytable th, .mytable td {
            text-align: center !important;
            border-right: 1px solid #000;
        }

        thead th, thead td {
            white-space: nowrap !important;
        }
    </style>
@endpush

@php 
    $gradeTypeUrl = strtoupper(request()->route('type'));
@endphp 

@section('content')
    <ol class="breadcrumb p-l-0">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Nilai {{ ucwords(strtolower($gradeTypeUrl)) }}</li>
    </ol>

    <div class="row">
        <div class="col-md-12 project-list">
            <div class="card">
                <div class="row">
                    <div class="col-md-6 d-flex mt-2 p-0">
                        <h4>Data Nilai {{ ucwords(strtolower($gradeTypeUrl)) }} Siswa</h4>
                    </div>
                    <div class="col-md-6 p-0">
                        <form action="{{ route('export.grades', $period->id) }}" method="GET">
                            @if (request()->has('class'))
                                <input type="hidden" name="classes[]" value="{{ strtoupper(request('class')) }}">
                            @endif
                            <button type="submit" class="btn btn-success btn-sm ms-2" style="float: right;"><i class="fa fa-download"></i> Export</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="filter">
                        <h6 class="text-primary">Filter</h6>
                        <form id="filterForm" action="{{ route('grades.index', $gradeTypeUrl) }}" method="GET">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">Periode dan Kelas :</label>
                                        <select name="period_id" onchange="this.form.submit()" class="selectNoCross form-control">
                                            @foreach ($periods as $key => $val)
                                                <optgroup label="{{ $key . '/' . ((int)$key + 1) }}">
                                                    @foreach ($val as $class) 
                                                        <option value="{{ $class->id }}" @if ($class->id == $period->id) selected @endif>{{ $class->class }} - {{ $class->year . '/' . ((int)$class->year + 1) }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
    
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">Kelas - Kelompok</label>
                                        <select name="class" onchange="this.form.submit()" class="selectpicker form-control">
                                            <option value="">-- Pilih Kelas --</option>
                                            @for ($i = ord('A'); $i < ord('O'); $i++)
                                                <option value="{{ chr($i) }}" @if(strtoupper(request('class')) == chr($i)) selected @endif>{{ $period->class }} - {{ chr($i) }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="">
                        <table class="display cell-border stripe mytable" id="mytable">
                            <thead>
                                <tr>
                                    @php
                                        $rowspan = 3;
                                        if ($gradeTypeUrl == 'UJIAN')
                                            $rowspan--;
                                        if (empty($headerTable[2]))
                                            $rowspan--;
                                    @endphp
                                    <th rowspan="{{ $rowspan }}">No.</th>
                                    <th rowspan="{{ $rowspan }}">Nama Siswa</th>
                                    <th rowspan="{{ $rowspan }}">NIS</th>

                                    @php
                                        $firstHeaderIdx = 0;
                                        if ($gradeTypeUrl == 'UJIAN')
                                            $firstHeaderIdx = 1;
                                    @endphp
                                    @foreach ($headerTable[$firstHeaderIdx] as $header)
                                        <th colspan="{{ $header['colspan'] }}">{{ $header['text'] }}</th>
                                    @endforeach

                                    <th rowspan="{{ $rowspan }}">Aksi</th>
                                </tr>

                                @if ($gradeTypeUrl == 'RAPOR')
                                    <tr>
                                        @foreach ($headerTable[1] as $header)
                                            <th colspan="{{ $header['colspan'] }}">{{ $header['text'] }}</th>
                                        @endforeach
                                    </tr>
                                @endif

                                @if (!empty($headerTable[2]))
                                <tr>
                                    @foreach ($headerTable[2] as $header)
                                        <td>{{ $header }}</td>
                                    @endforeach
                                </tr>
                                @endif
                            </thead>
                            <tbody>
                                @php $idx = 1; @endphp
                                @foreach ($students as $student)
                                    <tr>
                                        <td style="text-align: left !important;">{{ $idx++ }}.</td>
                                        <td style="text-align: left !important;">{{ $student->nama_lengkap }}</td>
                                        <td style="text-align: left !important;">{{ $student->nis }}</td>
                                        @foreach ($student->mappedScores as $score)
                                            <td>{{ $score }}</td>
                                        @endforeach
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('print.grade', $student->id) }}" class="btn btn-outline-primary btn-xs rounded" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Print Nilai"><i class="fa fa-print"></i></a>
                                            <a href="{{ route('students.edit.grade', ['id' => $student->id, 'class' => 7]) }}" class="btn btn-outline-warning btn-xs rounded" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="fa fa-edit"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
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
                processing: false,
                serverSide: false,
                ordering: false,
                // columns: [
                //     { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                //     { data: 'action', name: 'action', orderable: false, searchable: false }
                // ],
                columnDefs: [
                    { target: [0, 1, 2, 3], className: 'text-center' }
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

        $('.selectNoCross').select2({});
    </script>
@endpush
