@extends('layouts.app')
@section('content')
    <ol class="breadcrumb p-l-0">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Import</li>
    </ol>

    <div class="row">
        <div class="col-md-12 project-list">
            <div class="card">
                <div class="row">
                    <div class="col-md-6 d-flex mt-2 p-0">
                        <h4>Import Excel Baru</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div >
                        <form class="d-flex flex-column justify-center me-4 mt-4" method="POST" action="{{ route('import.upload') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="">Pilih File Excel :</label>
                                <input type="file" name="file" class="form-control" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                @if ($errors->any())
                                    <div class="text-danger mt-1">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>

                            <input type="submit" value="Upload" class="btn btn-primary mt-1">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
