@extends('layouts.app')
@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h3>Edit Siswa</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i data-feather="home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Siswa</a></li>
                <li class="breadcrumb-item active"> Edit Siswa</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body px-5">
                    <ul class="nav nav-tabs border-tab nav-primary" id="info-tab" role="tablist">
                        <li class="nav-item" style="flex-grow:1;">
                            <a class="nav-link @if(Route::currentRouteName() == 'students.edit.info') active @endif" 
                                id="info-home-tab"
                                href="{{ route('students.edit.info', $student->id) }}" 
                                role="tab" aria-controls="info-home" aria-selected="false">
                                    <i class="icofont icofont-man-in-glasses"></i>Informasi Siswa
                            </a>
                        </li>

                        <li class="nav-item" style="flex-grow:1;">
                            <a class="nav-link @if(Route::currentRouteName() == 'students.edit.grade' || Route::currentRouteName() == 'students.edit.grade.ujian') active @endif" 
                                id="profile-info-tab"
                                href="{{ route('students.edit.grade', ['id' => $student->id, 'class' => 7]) }}" 
                                role="tab" aria-controls="info-profile" aria-selected="false">
                                    <i class="icofont icofont-read-book"></i>Nilai
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content" id="info-tabContent">
                        <div class="tab-pane fade show active" id="info-home" role="tabpanel" aria-labelledby="info-home-tab">
                            @yield('tab-content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
