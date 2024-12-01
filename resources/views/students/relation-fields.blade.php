@php
    // $TYPE is a must param
    $prefixType = strtolower($type);
    $displayType = ucwords(strtolower($type));
@endphp

<h4 class="mt-5 mb-4 d-flex align-items-center">
    <span class="px-3 py-2 badge badge-primary">Data Diri {{ $displayType }}</span>
    <hr style="flex-grow: 1; height: 1px; background-color: #3e5fce;">
</h4>
<div class="row">
    <div class="col-sm-6">
        <!-- Nama Field -->
        <div class="form-group col-sm-10">
            {!! Form::label('nama', 'Nama ' . $displayType . ':', ['style' => 'font-weight: bold;']) !!}
            {!! Form::text($prefixType . '[nama]', null, ['class' => 'form-control', 'maxlength' => 35, 'maxlength' => 35]) !!}
            @error($prefixType . '.nama')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        @if ($type == "AYAH" || $type == "IBU")
        <!-- Status Field -->
        <div class="form-group col-sm-10">
            {!! Form::label('status', 'Status ' . $displayType . ':', ['style' => 'font-weight: bold;']) !!}
            {!! Form::text($prefixType . '[status]', null, ['class' => 'form-control', 'maxlength' => 35, 'maxlength' => 35]) !!}
            @error($prefixType . '.status')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        @endif

        <!-- Kewarganegaraan Field -->
        <div class="form-group col-sm-10">
            {!! Form::label('kewarganegaraan', 'Kewarganegaraan ' . $displayType . ':', ['style' => 'font-weight: bold;']) !!}
            {!! Form::text($prefixType . '[kewarganegaraan]', null, ['class' => 'form-control', 'maxlength' => 35, 'maxlength' => 35]) !!}
            @error($prefixType . '.kewarganegaraan')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <!-- Nik Field -->
        <div class="form-group col-sm-10">
            {!! Form::label('nik', 'NIK ' . $displayType . ':', ['style' => 'font-weight: bold;']) !!}
            {!! Form::text($prefixType . '[nik]', null, ['class' => 'form-control', 'maxlength' => 35, 'maxlength' => 35]) !!}
            @error($prefixType . '.nik')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tempat Lahir Field -->
        <div class="form-group col-sm-10">
            {!! Form::label('tempat_lahir', 'Tempat Lahir ' . $displayType . ':', ['style' => 'font-weight: bold;']) !!}
            {!! Form::text($prefixType . '[tempat_lahir]', null, ['class' => 'form-control', 'maxlength' => 35, 'maxlength' => 35]) !!}
            @error($prefixType . '.tempat_lahir')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tanggal Lahir Field -->
        <div class="form-group col-sm-10">
            {!! Form::label('tanggal_lahir', 'Tanggal Lahir:', ['style' => 'font-weight: bold;']) !!}
            {!! Form::text($prefixType . '[tanggal_lahir]', null, ['class' => 'form-control datepicker-here', 'id' => 'tanggal_lahir']) !!}
            @error($prefixType . '.tanggal_lahir')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <!-- Pendidikan Field -->
        <div class="form-group col-sm-10">
            {!! Form::label('pendidikan', 'Pendidikan ' . $displayType . ':', ['style' => 'font-weight: bold;']) !!}
            {!! Form::text($prefixType . '[pendidikan]', null, ['class' => 'form-control', 'maxlength' => 35, 'maxlength' => 35]) !!}
            @error($prefixType . '.pendidikan')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <!-- Pekerjaan Field -->
        <div class="form-group col-sm-10">
            {!! Form::label('pekerjaan', 'Pekerjaan ' . $displayType . ':', ['style' => 'font-weight: bold;']) !!}
            {!! Form::text($prefixType . '[pekerjaan]', null, ['class' => 'form-control', 'maxlength' => 35, 'maxlength' => 35]) !!}
            @error($prefixType . '.pekerjaan')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <!-- Penghasilan Field -->
        <div class="form-group col-sm-10">
            {!! Form::label('penghasilan', 'Penghasilan ' . $displayType . ':', ['style' => 'font-weight: bold;']) !!}
            {!! Form::number($prefixType . '[penghasilan]', null, ['class' => 'form-control']) !!}
            @error($prefixType . '.penghasilan')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <!-- Nomor Hp Field -->
        <div class="form-group col-sm-10">
            {!! Form::label('nomor_hp', 'Nomor HP ' . $displayType . ':', ['style' => 'font-weight: bold;']) !!}
            {!! Form::text($prefixType . '[nomor_hp]', null, ['class' => 'form-control', 'maxlength' => 15, 'maxlength' => 15]) !!}
            @error($prefixType . '.nomor_hp')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        @if($type == "AYAH")
            <!-- Tinggal Luar Negeri Field -->
            <div class="form-group col-sm-10">
                {!! Form::label('tinggal_luar_negeri', 'Tinggal Luar Negeri ' . $displayType . ':', ['style' => 'font-weight: bold;']) !!}
                {!! Form::text($prefixType . '[tinggal_luar_negeri]', null, ['class' => 'form-control', 'maxlength' => 35, 'maxlength' => 35]) !!}
                @error($prefixType . '.tinggal_luar_negeri')
                <p class="text-danger">{{ $message }}</p>
            @enderror
            </div>

            <!-- Kepemilikan Rumah Field -->
            <div class="form-group col-sm-10">
                {!! Form::label('kepemilikan_rumah', 'Kepemilikan Rumah ' . $displayType . ':', ['style' => 'font-weight: bold;']) !!}
                {!! Form::text($prefixType . '[kepemilikan_rumah]', null, ['class' => 'form-control', 'maxlength' => 35, 'maxlength' => 35]) !!}
                @error($prefixType . '.kepemilikan_rumah')
                <p class="text-danger">{{ $message }}</p>
            @enderror
            </div>
        @endif
    </div>
    <div class="col-sm-6">
        <!-- Provinsi Field -->
        <div class="form-group col-sm-10">
            {!! Form::label('provinsi', 'Provinsi ' . $displayType . ':', ['style' => 'font-weight: bold;']) !!}
            {!! Form::text($prefixType . '[provinsi]', null, ['class' => 'form-control', 'maxlength' => 20, 'maxlength' => 20]) !!}
            @error($prefixType . '.provinsi')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <!-- Kota Field -->
        <div class="form-group col-sm-10">
            {!! Form::label('kota', 'Kota ' . $displayType . ':', ['style' => 'font-weight: bold;']) !!}
            {!! Form::text($prefixType . '[kota]', null, ['class' => 'form-control', 'maxlength' => 20, 'maxlength' => 20]) !!}
            @error($prefixType . '.kota')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <!-- Kecamatan Field -->
        <div class="form-group col-sm-10">
            {!! Form::label('kecamatan', 'Kecamatan ' . $displayType . ':', ['style' => 'font-weight: bold;']) !!}
            {!! Form::text($prefixType . '[kecamatan]', null, ['class' => 'form-control', 'maxlength' => 20, 'maxlength' => 20]) !!}
            @error($prefixType . '.kecamatan')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <!-- Desa Field -->
        <div class="form-group col-sm-10">
            {!! Form::label('desa', 'Desa ' . $displayType . ':', ['style' => 'font-weight: bold;']) !!}
            {!! Form::text($prefixType . '[desa]', null, ['class' => 'form-control', 'maxlength' => 20, 'maxlength' => 20]) !!}
            @error($prefixType . '.desa')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <!-- Rt Field -->
        <div class="form-group col-sm-10">
            {!! Form::label('rt', 'RT ' . $displayType . ':', ['style' => 'font-weight: bold;']) !!}
            {!! Form::text($prefixType . '[rt]', null, ['class' => 'form-control', 'maxlength' => 5, 'maxlength' => 5]) !!}
            @error($prefixType . '.rt')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <!-- Rw Field -->
        <div class="form-group col-sm-10">
            {!! Form::label('rw', 'RW ' . $displayType . ':', ['style' => 'font-weight: bold;']) !!}
            {!! Form::text($prefixType . '[rw]', null, ['class' => 'form-control', 'maxlength' => 5, 'maxlength' => 5]) !!}
            @error($prefixType . '.rw')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <!-- Kode Pos Field -->
        <div class="form-group col-sm-10">
            {!! Form::label('kode_pos', 'Kode Pos ' . $displayType . ':', ['style' => 'font-weight: bold;']) !!}
            {!! Form::text($prefixType . '[kode_pos]', null, ['class' => 'form-control', 'maxlength' => 8, 'maxlength' => 8]) !!}
            @error($prefixType . '.kode_pos')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <!-- Alamat Field -->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('alamat', 'Alamat ' . $displayType . ':', ['style' => 'font-weight: bold;']) !!}
            {!! Form::textarea($prefixType . '[alamat]', null, ['class' => 'form-control']) !!}
            @error($prefixType . '.alamat')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
