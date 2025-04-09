@extends('layouts.app')
@section('content')
    <ol class="breadcrumb p-l-0">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item">Import</li>
        <li class="breadcrumb-item Active">Import Nilai</li>
    </ol>

    <div class="row">
        <div class="col-md-12 project-list">
            <div class="card">
                <div class="row">
                    <div class="col-md-6 d-flex mt-2 p-0">
                        <h4>Import Nilai</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 style="margin: 0;">Pilih Periode dan Kelas</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <form class="" method="GET" action="{{ route('import.grades.index') }}" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="">Pilih Periode dan Kelas yang akan diimport :</label>
                                <select name="period_id" class="js-example-basic-single form-control">
                                    @foreach ($periods as $key => $period)
                                        <optgroup label="{{ $key . '/' . ((int)$key + 1) }}">
                                            @foreach ($period as $class) 
                                                <option value="{{ $class->id }}">{{ $class->class }} - {{ $class->year . '/' . ((int)$class->year + 1) }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary d-flex gap-2 mt-2"><i class="fa fa-arrow-circle-o-right"></i>Pilih</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $('.js-example-basic-single').select2();
    </script>
@endpush