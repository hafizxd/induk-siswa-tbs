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
        <li class="breadcrumb-item"><a href="#">Data Master</a></li>
        <li class="breadcrumb-item active">Periode</li>
    </ol>

    <div class="row">
        <div class="col-md-12 project-list">
            <div class="card">
                <div class="row">
                    <div class="col-md-6 d-flex mt-2 p-0">
                        <h4>Data Periode</h4>
                    </div>
                    <div class="col-md-6 p-0">
                        <button class="btn btn-primary btn-sm ms-2" type="button" data-bs-toggle="modal" data-bs-target="#mdlCreate"><i class="fa fa-plus-circle"></i> Tambah</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            @if (count($periods) > 0)
                @php $indexLoop = 1; @endphp
                @foreach ($periods as $year => $classes) 
                    {{-- Conditional class --}}
                    @php
                        if ($indexLoop == 1)
                            $cardTheme = 'primary';
                        else 
                            $cardTheme = 'dark';

                        $indexLoop++;
                    @endphp

                    <div class="card card-absolute b-t-{{ $cardTheme }} border-3">
                        <div class="card-header bg-{{ $cardTheme }}">
                            <h5 class="text-white">{{ $year . '/' . ((int)$year + 1) }}</h5>
                        </div>

                        <div class="card-body pt-5">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Kelas</th>
                                        <th>Kurikulum</th>
                                        <th>Parameter Nilai</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($classes as $class)
                                        <form method="POST" action="{{ route('periods.update', $class->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <tr>
                                                <td>{{ $class->class }}</td>
                                                <td>
                                                    <select name="curriculum_id" class="form-select form-control-sm">
                                                        @foreach ($curriculums as $curriculum)
                                                            <option value="{{ $curriculum->id }}" @if($class->curriculum_id == $curriculum->id) selected @endif>{{ $curriculum->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <ul>
                                                        @foreach ($class->curriculum->curriculumScoreCols as $col)
                                                            <li>{{ $col->name }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <button type="submit" class="btn btn-xs rounded btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Simpan"><i class="fa fa-check"></i></button>
                                                        <div>
                                                            <a href="{{ route('periods.detail.subject.index', $class->id) }}" class="btn btn-xs btn-outline-success rounded" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Assign mata pelajaran"><i class="fa fa-plus-square-o"></i></a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </form>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="card">
                    <p class="text-center">Tidak ada data periode</p>
                </div>
            @endif
        </div>
    </div>

    <div id="mdlCreate" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <form action="{{ route('periods.store') }}" method="POST">
            @csrf
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title" id="mySmallModalLabel">Tambah Periode</h4>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">    
                        <div class="form-group col-sm-10">
                            <label class="font-bold">Pilih Tahun</label>
                            <select name="year" class="select form-control">
                                @foreach ($yearOptions as $opt)
                                    <option value="{{ $opt }}">{{ $opt . '/' . ((int)$opt + 1) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-sm-10">
                            <label class="font-bold">Pilih Kurikulum</label>
                            <select name="curriculum_id" class="select form-control">
                                @foreach ($curriculums as $opt)
                                    <option value="{{ $opt->id }}">{{ $opt->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-sm-10">
                            <label class="font-bold">(opsional) Copy Mata Pelajaran dari Periode:</label>
                            <select name="year_copy" class="select form-control">
                                <option value="">-- Tidak ada --</option>
                                @foreach ($pickedYears as $opt)
                                    <option value="{{ $opt }}">{{ $opt . '/' . ((int)$opt + 1) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script>
        function showSubject(periodId) {
            createOverlay("Proses...");
            $.ajax({
                type  : "GET",
                url   : "",
                success : function(data) {
                    gOverlay.hide();

                    if(data["STATUS"] == "SUCCESS") {
                        Toast.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: data['MESSAGE']
                        })

                        $("#modalAssignSubject").on("show", function() {

                        });

                        $("#modalAssignSubject").modal("show");
                    }
                    else {
                        $('#modalAssignSubject').modal("hide");

                        Toast.fire({
                            icon: "error",
                            title: "Gagal",
                            text: data['MESSAGE']
                        })
                    }
                },
                error : function(error) {
                    gOverlay.hide();
                    Toast.fire({
                        icon: "error",
                        title: "Network/server error\r\n",
                        text: error
                    })
                }
            });
        }
    </script>
@endpush