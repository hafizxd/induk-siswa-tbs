@extends('students.edit.layout')
@section('tab-content')
<div>
    <ul class="nav nav-tabs border-tab nav-primary" id="info-tab" role="tablist">
        <li class="nav-item" style="flex-grow:1;">
            <a class="nav-link @if(Route::currentRouteName() == 'students.edit.grade' && request()->route('class') == 7) active @endif" 
                id="info-home-tab"
                href="{{ route('students.edit.grade', ['id' => $student->id, 'class' => 7]) }}" 
                role="tab" aria-controls="info-home" aria-selected="false">
                    <i class="icofont icofont-read-book"></i>Kelas VII
            </a>
        </li>

        <li class="nav-item" style="flex-grow:1;">
            <a class="nav-link @if(Route::currentRouteName() == 'students.edit.grade' && request()->route('class') == 8) active @endif" 
                id="profile-info-tab"
                href="{{ route('students.edit.grade', ['id' => $student->id, 'class' => 8]) }}" 
                role="tab" aria-controls="info-profile" aria-selected="false">
                    <i class="icofont icofont-read-book"></i>Kelas VIII
            </a>
        </li>

        <li class="nav-item" style="flex-grow:1;">
            <a class="nav-link @if(Route::currentRouteName() == 'students.edit.grade' && request()->route('class') == 9) active @endif" 
                id="profile-info-tab"
                href="{{ route('students.edit.grade', ['id' => $student->id, 'class' => 9]) }}" 
                role="tab" aria-controls="info-profile" aria-selected="false">
                    <i class="icofont icofont-read-book"></i>Kelas IX
            </a>
        </li>

        <li class="nav-item" style="flex-grow:1;">
            <a class="nav-link @if(Route::currentRouteName() == 'students.edit.grade.ujian') active @endif" 
                id="profile-info-tab"
                href="{{ route('students.edit.grade.ujian', ['id' => $student->id]) }}" 
                role="tab" aria-controls="info-profile" aria-selected="false">
                    <i class="icofont icofont-read-book"></i>Ujian
            </a>
        </li>
    </ul>

    <div class="tab-content" id="info-tabContent">
        <div class="tab-pane fade show active" id="info-home" role="tabpanel" aria-labelledby="info-home-tab">
            @yield('tab-tab-content')
        </div>
    </div>
</div>

@endsection