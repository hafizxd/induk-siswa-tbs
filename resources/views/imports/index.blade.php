@extends('layouts.app')
@section('content')
    <ol class="breadcrumb p-l-0">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item">Import</li>
        <li class="breadcrumb-item Active">Import Siswa</li>
    </ol>

    <div class="row">
        <div class="col-md-12 project-list">
            <div class="card">
                <div class="row">
                    <div class="col-md-6 d-flex mt-2 p-0">
                        <h4>Import Siswa</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h5 style="margin: 0;">Tambah Data Baru</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <form class="" method="POST" action="{{ route('import.students.upload') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="">Pilih File Excel :</label>
                                <div class="d-flex align-items-center gap-2">
                                    <input type="file" name="file" class="form-control" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">

                                    <button type="submit" class="btn btn-primary d-flex gap-2"><i class="fa fa-upload"></i>Upload</button>
                                </div>
                                @if ($errors->any())
                                    <div class="text-danger mt-1">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li><br>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>

                        </form>
                        <a class="success-link" style="text-align: center;" href="{{ route('export.student.template') }}"><i class="fa fa-download"></i> Download Template</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 style="margin: 0;">Tambah Baru / Update Data yang Sudah Ada</h5>
                    <span class="mb-0 pb-0 text-gray">(* Proses memakan waktu lebih lama)</span>
                    <span class="mb-0 pb-0 text-gray">(* Parameter NIS harap tidak diubah jika update data)</span>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <form class="" method="POST" action="{{ route('import.students.upload.update') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="">Pilih File Excel :</label>
                                <div class="d-flex align-items-center gap-2">
                                    <input type="file" name="file_update" class="form-control" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">

                                    <button type="submit" class="btn btn-primary d-flex gap-2"><i class="fa fa-upload"></i>Upload</button>
                                </div>
                                @error('file_update')
                                    <div class="text-danger mt-1">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li><br>
                                            @endforeach
                                        </ul>
                                    </div>
                                @enderror
                            </div>

                            <a class="success-link" href="#" data-bs-toggle="modal" data-bs-target="#mdlTemplate"><i class="fa fa-download"></i> Download Template</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="mdlTemplate" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <form method="GET" action="{{ route('export.student') }}">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="mySmallModalLabel">Filter Data Template</h4>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
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
                                <div class="col-sm-2 text-center">-</div>
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
                                <div class="col-sm-2 text-center">-</div>
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

                        <div class="form-group">
                            <label for="">Kelas - Kelompok</label>
                            <div class="row" style="align-items: center;">
                                <select id="class" class="selectpicker form-control">
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
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-success" type="submit"><i class="fa fa-download"></i> Download</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
