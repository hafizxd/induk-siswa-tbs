@extends('students.edit.layout-grade')
@section('tab-tab-content')
    @php 
        $class = 9;
        if (Route::currentRouteName() == 'students.edit.grade')
            $class = request()->route('class');

    @endphp

    <div style="width: 500px; margin: auto;">
        <p>Nilai kelas {{ $class }} pada Siswa <b>{{ $student->nama_lengkap }}</b> belum di-assign pada suatu Periode. Silahkan assign dibawah ini.</p>

        <form action="{{ route('students.period.assign', $student->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="">Pilih Periode :</label>
                <select name="period_id" class="js-example-basic-single form-control">
                    @foreach ($periods as $period)
                        <option value="{{ $period->id }}">{{ $period->class }} - {{ $period->year . '/' . ((int)$period->year + 1) }}</option>
                    @endforeach
                </select>
    
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary d-flex gap-2 mt-2"><i class="fa fa-arrow-circle-o-right"></i>Assign</button>
                </div>
            </div>
        </form>
    </div>
@endsection