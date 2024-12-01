@extends('layouts.app')
@section('content')
    <ol class="breadcrumb p-l-0">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Export</li>
    </ol>

    <div class="row">
        <div class="col-md-12 project-list">
            <div class="card">
                <div class="row">
                    <div class="col-md-6 d-flex mt-2 p-0">
                        <h4>Export Excel</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div >
                        <form class="d-flex flex-column justify-center me-4 mt-4" method="POST" action="{{ route('export.download') }}" enctype="multipart/form-data">
                            @csrf

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
                                    <button type="button" onclick="exportPage()" class="btn btn-success btn-sm ms-2" style="float: right;">Export</a>
                                </div>
                            </div>

                            <input type="submit" value="Download" class="btn btn-primary mt-1">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
