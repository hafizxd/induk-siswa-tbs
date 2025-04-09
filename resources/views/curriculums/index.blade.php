@extends('layouts.app')

@push('style')
    <style>
        th {
            white-space: nowrap !important;
        }

        .nested-table tr:last-child td {
            border-bottom: 1px solid #3e5fce;
        }
    </style>
@endpush

@section('content')
    <ol class="breadcrumb p-l-0">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Kurikulum</li>
    </ol>

    <div class="row">
        <div class="col-md-12 project-list">
            <div class="card">
                <div class="row">
                    <div class="col-md-6 d-flex mt-2 p-0">
                        <h4>Data Kurikulum</h4>
                    </div>
                    <div class="col-md-6 p-0">
                        <button class="btn btn-primary btn-sm ms-2" type="button" data-bs-toggle="modal" data-bs-target="#mdlCreate"><i class="fa fa-plus-circle"></i> Tambah</button>
                        <div id="mdlCreate" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                            <form method="POST" action="{{ route('curriculums.store') }}">
                                @csrf
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="mySmallModalLabel">Tambah Kurikulum</h4>
                                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group col-sm-10">
                                                {!! Form::label('name', 'Nama Kurikulum :', ['style' => 'font-weight: bold;']) !!}
                                                {!! Form::text('name', null, ['id' => 'name', 'class' => 'form-control']) !!}
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
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    @if($errors->any())
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Kurikulum</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($curriculums as $curriculum)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td><b>{{ $curriculum->name }}</b></td>
                                        <td class="d-flex gap-1">
                                            <button class="btn btn-outline-warning btn-xs rounded" data-bs-toggle="modal" data-bs-target="#mdlEdit{{ $curriculum->id }}"><i class="fa fa-edit"></i></button>
                                            <form method="POST" action="{{ route('curriculums.delete', $curriculum->id) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-outline-danger btn-xs rounded" type="submit"><i class="fa fa-trash-o"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="2">
                                            <table class="table table-sm table-striped nested-table">
                                                <thead>
                                                    <tr>
                                                        <th>Parameter Nilai</th>
                                                        <th>No. Urut Parameter</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($curriculum->curriculumScoreCols as $col) 
                                                        <form method="POST" action="{{ route('curriculums.cols.update', ['curId' => $curriculum->id, 'colId' => $col->id]) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <tr>
                                                                <td>
                                                                    <input class="form-control form-control-sm" type="text" name="name" value="{{ $col->name }}">
                                                                </td>
                                                                <td>
                                                                    <input class="form-control form-control-sm" style="width: 100px;" type="number" name="order_no" value="{{ $col->order_no }}">
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex gap-1">
                                                                        <button type="submit" class="btn btn-outline-primary btn-xs rounded"><i class="fa fa-check"></i></button>
                                                                        <button class="btn btn-outline-danger btn-xs rounded" type="button" onclick="document.querySelector('#delete{{ $col->id }}').submit()"><i class="fa fa-trash-o"></i></button>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </form>

                                                        {{-- For deleting col --}}
                                                        <form method="POST" id="delete{{ $col->id }}" action="{{ route('curriculums.cols.delete', ['curId' => $curriculum->id, 'colId' => $col->id]) }}">
                                                            @method('DELETE')
                                                            @csrf
                                                        </form>
                                                        {{-- For deleting col --}}

                                                    @endforeach
                                                    <form method="POST" action="{{ route('curriculums.cols.store', $curriculum->id) }}">
                                                        @csrf
                                                        <tr>
                                                            <td>
                                                                <input class="form-control form-control-sm" type="text" name="name" placeholder="Masukkan nama parameter nilai">
                                                            </td>
                                                            <td>
                                                                <input class="form-control form-control-sm" style="width: 100px;" name="order_no" type="number" placeholder="Masukkan no. urut">
                                                            </td>
                                                            <td>
                                                                <button type="submit" class="btn btn-outline-primary btn-xs rounded"><i class="fa fa-check"></i></button>
                                                            </td>
                                                        </tr>
                                                    </form>
                                                </tbody>
                                            </table>
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

{{-- Modal Edit --}}

@foreach ($curriculums as $curriculum)
<div id="mdlEdit{{ $curriculum->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <form method="POST" action="{{ route('curriculums.update', $curriculum->id) }}">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mySmallModalLabel">Edit Kurikulum</h4>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="form-group col-sm-10">
                        {!! Form::label('name', 'Nama Kurikulum :', ['style' => 'font-weight: bold;']) !!}
                        {!! Form::text('name', $curriculum->name, ['id' => 'name', 'class' => 'form-control']) !!}
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
@endforeach

@endsection

@push('script')
    <script>
        $(document).ready(function() {
            
        });
    </script>
@endpush
