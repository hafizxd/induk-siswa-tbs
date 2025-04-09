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
        <li class="breadcrumb-item"><a href="{{ route('periods.index') }}">Periode</a></li>
        <li class="breadcrumb-item active">Assign Mata Pelajaran</li>
    </ol>

    <div class="row">
        <div class="col-md-12 project-list">
            <div class="card">
                <div class="row">
                    <div class="col-md-6 d-flex mt-2 p-0">
                        <h4>Assign Mata Pelajaran</h4>
                    </div>
                    <div class="col-md-6 mt-2 p-0">
                        <h4 style="text-align: right;">Periode {{ $period->class }} - {{ $period->year . '/' . ((int)$period->year + 1) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body px-5 py-5">
                    <div>
                        <label for="">Copy dari periode :</label>
                        <form action="{{ route('periods.detail.subject.copy', $period->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <select class="form-select" name="copy_period_id" id="duplicatePeriod">
                                            @foreach($periodOpts as $option)
                                                <option value="{{ $option->id }}">{{ $option->class }} - {{ $option->year . '/' . ((int)$option->year + 1) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <button type="submit" class="btn btn-primary rounded"><i class="fa fa-copy"></i> Copy</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="d-flex gap-2 my-2">
                        <hr style="flex-grow: 1; height: 1px; background-color: #2e2e2e;">
                        <span>Atau Assign Manual</span>
                        <hr style="flex-grow: 1; height: 1px; background-color: #2e2e2e;">
                    </div>

                    <div>
                        <form action="{{ route('periods.detail.subject.assign', $period->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-5">
                                <label>Mata Pelajaran pada Periode Ini :</label>
                                
                                @php 
                                    if(count($assignedSubjects) > 0) {
                                        $breakpoint = ceil(count($assignedSubjects) / 2);
                                        $chunks = $assignedSubjects->chunk($breakpoint);
                                        $leftSubjects = $chunks->get(0, collect());
                                        $rightSubjects = $chunks->get(1, collect());
                                    } else {
                                        $leftSubjects = [];
                                        $rightSubjects = [];
                                    }
                                    $rowNum = 1;
                                @endphp
    
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Mapel</th>
                                                    <th>Aktif ?</th>
                                                    <th>Parameter Nilai ?</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($leftSubjects as $subject)
                                                    <tr>
                                                        <td>{{ $rowNum++ }}.</td>
                                                        <td>{{ $subject->name }} @if($subject->type == "UJIAN") <span class="badge badge-light text-primary">Ujian</span> @endif</td>
                                                        <td class="icon-state">
                                                            <label class="switch">
                                                                <input type="checkbox" name="subject[{{ $subject->id }}]" checked><span class="switch-state"></span>
                                                            </label>
                                                        </td>
                                                        <td class="icon-state">
                                                            <label class="switch">
                                                                <input type="checkbox" name="is_col_instantiate[{{ $subject->id }}]" @if($subject->pivot->is_col_instantiate == 1) checked @endif><span class="switch-state"></span>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">Tidak ada data</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
    
                                    <div class="col-md-6">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Mapel</th>
                                                    <th>Aktif ?</th>
                                                    <th>Parameter Nilai ?</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($rightSubjects as $subject)
                                                    <tr>
                                                        <td>{{ $rowNum++ }}.</td>
                                                        <td>{{ $subject->name }} @if($subject->type == "UJIAN") <span class="badge badge-light text-primary">Ujian</span> @endif</td>
                                                        <td class="icon-state">
                                                            <label class="switch">
                                                                <input type="checkbox" name="subject[{{ $subject->id }}]" checked><span class="switch-state"></span>
                                                            </label>
                                                        </td>
                                                        <td class="icon-state">
                                                            <label class="switch">
                                                                <input type="checkbox" name="is_col_instantiate[{{ $subject->id }}]" @if($subject->pivot->is_col_instantiate == 1) checked @endif><span class="switch-state"></span>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
    
                            <div>
                                <label>Assign Mata Pelajaran Baru :</label>
                                    @php 
                                        if(count($unassignedSubjects) > 0) {
                                            $breakpoint = ceil(count($unassignedSubjects) / 2);
                                            $chunks = $unassignedSubjects->chunk($breakpoint);
                                            $leftSubjects = $chunks->get(0, collect());
                                            $rightSubjects = $chunks->get(1, collect());
                                        } else {
                                            $leftSubjects = [];
                                            $rightSubjects = [];
                                        }
                                        $rowNum = 1;
                                    @endphp
        
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Mapel</th>
                                                        <th>Aktif ?</th>
                                                        <th>Parameter Nilai ?</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($leftSubjects as $subject)
                                                        <tr>
                                                            <td>{{ $rowNum++ }}.</td>
                                                            <td>{{ $subject->name }} @if($subject->type == "UJIAN") <span class="badge badge-light text-primary">Ujian</span> @endif</td>
                                                            <td class="icon-state">
                                                                <label class="switch">
                                                                    <input type="checkbox" name="subject[{{ $subject->id }}]"><span class="switch-state"></span>
                                                                </label>
                                                            </td>
                                                            <td class="icon-state">
                                                                <label class="switch">
                                                                    <input type="checkbox" name="is_col_instantiate[{{ $subject->id }}]"><span class="switch-state"></span>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="text-center">Tidak ada data</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
        
                                        <div class="col-md-6">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Mapel</th>
                                                        <th>Aktif ?</th>
                                                        <th>Parameter Nilai ?</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($rightSubjects as $subject)
                                                        <tr>
                                                            <td>{{ $rowNum++ }}.</td>
                                                            <td>{{ $subject->name }} @if($subject->type == "UJIAN") <span class="badge badge-light text-primary">Ujian</span> @endif</td>
                                                            <td class="icon-state">
                                                                <label class="switch">
                                                                    <input type="checkbox" name="subject[{{ $subject->id }}]"><span class="switch-state"></span>
                                                                </label>
                                                            </td>
                                                            <td class="icon-state">
                                                                <label class="switch">
                                                                    <input type="checkbox" name="is_col_instantiate[{{ $subject->id }}]"><span class="switch-state"></span>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                            </div>

                            <div class="d-flex justify-content-center mt-4">
                                <button type="submit" class="btn btn-primary rounded"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection