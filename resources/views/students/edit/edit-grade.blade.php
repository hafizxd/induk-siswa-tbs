@extends('students.edit.layout-grade')

@push('style')
    <style>
        th {
            background-color: #eee !important;
        }
    </style>
@endpush

@section('tab-tab-content')
<div>
    <h5>Periode {{ $period->class . ' - ' . $period->year . '/' . ((int)$period->year + 1) }}</h5>

    <form action="{{ route('students.update.grade', $student->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <input type="hidden" name="period_id" value="{{ $period->id }}">
        
        @foreach ($subjectPlaceholders as $semester => $val)
            <div class="mb-5">
                <h6 class="text-center text-primary">Semester {{ $semester }}</h6>
                <div class="row">
                    @php 
                        $index = 1;
                    @endphp
            
                    <div class="col-sm-12">
                        <table class="table w-100">
                            <tr>
                                <th style="width: 50px;"></th>
                                <th>Mata Pelajaran</th>
                                @foreach ($period->curriculum->curriculumScoreCols as $col)
                                    <th style="width: 150px;">{{ $col->name }}</th>
                                @endforeach
                            </tr>

                            @foreach ($val as $idSubject => $subject)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>{{ $subject['subject_name'] }}</td>
                                    @foreach ($subject['scores'] as $idCol => $score)
                                        <td><input type="number" name="{{ 'semester['.$semester.']['.$idSubject.']['.$idCol.']' }}" value="{{ $score }}" class="form-control"></td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Submit Field -->
        <div class="form-group col-sm-12 mt-5 d-flex justify-content-center gap-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection