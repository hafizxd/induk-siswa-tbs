@extends('students.edit.layout')
@section('tab-content')
    {!! Form::open(['route' => ['grades.update', ['type' => request()->route('type'), 'id' => $student->id]]]) !!}
    @method('PUT')
    
    <div class="row">
        @php 
            $breakpoint = ceil(count($subjects) / 2); 
            list($leftSubjects, $rightSubjects) = $subjects->chunk($breakpoint);
        @endphp

        <div class="col-sm-6">
            @foreach ($leftSubjects as $subject)
                @php 
                    $val = count($subject->scoreSubjects) > 0 ? $subject->scoreSubjects[0]->nilai : '';
                @endphp
                <div class="form-group col-sm-10">
                    {!! Form::label('scores['.$subject->id.']', $subject->name, ['style' => 'font-weight: bold;']) !!}
                    {!! Form::number('scores['.$subject->id.']', $val, ['class' => 'form-control', 'maxlength' => 20, 'maxlength' => 20]) !!}
                    @error('scores['.$subject->id.']')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach
        </div>

        <div class="col-sm-6">
            @foreach ($rightSubjects as $subject)
                @php 
                    $val = count($subject->scoreSubjects) > 0 ? $subject->scoreSubjects[0]->nilai : '';
                @endphp
                <div class="form-group col-sm-10">
                    {!! Form::label('scores['.$subject->id.']', $subject->name, ['style' => 'font-weight: bold;']) !!}
                    {!! Form::number('scores['.$subject->id.']', $val, ['class' => 'form-control', 'maxlength' => 20, 'maxlength' => 20]) !!}
                    @error('scores['.$subject->id.']')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach
        </div>
    </div>

    <!-- Submit Field -->
    <div class="form-group col-sm-12 mt-5 d-flex justify-content-end gap-2">
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
        {!! Form::submit('Simpan', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
@endsection