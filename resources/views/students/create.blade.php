@extends('layouts.app')
@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h3>Tambah Siswa</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i data-feather="home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Siswa</a></li>
                <li class="breadcrumb-item active"> Tambah Siswa</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body px-5 py-5">
                    {!! Form::open(['route' => 'students.store']) !!}

                    {{-- <div class="card-header p-0">
                        <h5>Data Diri Siswa</h5>
                    </div> --}}
                    <h4 class="mb-4 d-flex align-items-center">
                        <span class="px-3 py-2 badge badge-primary">Data Diri Siswa</span>
                        <hr style="flex-grow: 1; height: 1px; background-color: #3e5fce;">
                    </h4>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- Nisn Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('nisn', 'NISN:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('nisn', null, ['class' => 'form-control', 'maxlength' => 20, 'maxlength' => 20]) !!}
                                @error('nisn')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nik Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('nik', 'NIK:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('nik', null, ['class' => 'form-control', 'maxlength' => 20, 'maxlength' => 20]) !!}
                                @error('nik')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nis Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('nis', 'NIS (<span style="color: red;">*</span>):', ['style' => 'font-weight: bold;'], false) !!}
                                {!! Form::text('nis', null, ['class' => 'form-control', 'maxlength' => 20, 'maxlength' => 20]) !!}
                                @error('nis')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nama Lengkap Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('nama_lengkap', 'Nama Lengkap (<span style="color: red;">*</span>):',  ['style' => 'font-weight: bold;'], false) !!}
                                {!! Form::text('nama_lengkap', null, ['class' => 'form-control', 'maxlength' => 20, 'maxlength' => 20]) !!}
                                @error('nama_lengkap')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group col-sm-10">
                                {!! Form::label('photo_url', 'URL Foto:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('photo_url', null, ['class' => 'form-control', 'maxlength' => 100]) !!}
                                @error('photo_url')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kelas 9 Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('kelas_9', 'Kelas 9 - Kelompok:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('kelas_9', null, ['class' => 'form-control', 'maxlength' => 20, 'maxlength' => 20]) !!}
                                @error('kelas_9')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Abs 9 Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('abs_9', 'Kelas 9 - Absen:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('abs_9', null, ['class' => 'form-control', 'maxlength' => 20, 'maxlength' => 20]) !!}
                                @error('abs_9')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kelas 8 Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('kelas_8', 'Kelas 8 - Kelompok:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('kelas_8', null, ['class' => 'form-control', 'maxlength' => 20, 'maxlength' => 20]) !!}
                                @error('kelas_8')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Abs 8 Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('abs_8', 'Kelas 8 - Absen:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('abs_8', null, ['class' => 'form-control', 'maxlength' => 20, 'maxlength' => 20]) !!}
                                @error('abs_8')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kelas 7 Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('kelas_7', 'Kelas 7 - Kelompok:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('kelas_7', null, ['class' => 'form-control', 'maxlength' => 20, 'maxlength' => 20]) !!}
                                @error('kelas_7')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Abs 7 Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('abs_7', 'Kelas 7 - Absen:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('abs_7', null, ['class' => 'form-control', 'maxlength' => 20, 'maxlength' => 20]) !!}
                                @error('abs_7')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tahun Masuk -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('tahun_masuk', 'Tahun Masuk:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('tahun_masuk', null, ['class' => 'form-control', 'maxlength' => 4, 'maxlength' => 20]) !!}
                                @error('tahun_masuk')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tahun Mutasi -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('tahun_mutasi', 'Tahun Mutasi:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('tahun_mutasi', null, ['class' => 'form-control', 'maxlength' => 4, 'maxlength' => 20]) !!}
                                @error('tahun_mutasi')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status Mutasi -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('status_mutasi', 'Status Mutasi:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('status_mutasi', null, ['class' => 'form-control', 'maxlength' => 10, 'maxlength' => 10]) !!}
                                @error('status_mutasi')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status Pendaftar Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('status_pendaftar', 'Status Pendaftar:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('status_pendaftar', null, ['class' => 'form-control', 'maxlength' => 20, 'maxlength' => 20]) !!}
                                @error('status_pendaftar')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tempat Lahir Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('tempat_lahir', 'Tempat Lahir:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('tempat_lahir', null, ['class' => 'form-control', 'maxlength' => 20, 'maxlength' => 20]) !!}
                                @error('tempat_lahir')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Lahir Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('tanggal_lahir', 'Tanggal Lahir:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('tanggal_lahir', null, ['class' => 'form-control datepicker-here', 'id' => 'tanggal_lahir']) !!}
                                @error('tanggal_lahir')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6">

                            <!-- Nomor Test Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('nomor_test', 'Nomor Test:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('nomor_test', null, ['class' => 'form-control', 'maxlength' => 20, 'maxlength' => 20]) !!}
                                @error('nomor_test')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Asal Sekolah Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('asal_sekolah', 'Asal Sekolah:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('asal_sekolah', null, ['class' => 'form-control', 'maxlength' => 35, 'maxlength' => 35]) !!}
                                @error('asal_sekolah')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Prasekolah Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('prasekolah', 'Prasekolah:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('prasekolah', null, ['class' => 'form-control', 'maxlength' => 35, 'maxlength' => 35]) !!}
                                @error('prasekolah')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nama Kepala Keluarga Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('nama_kepala_keluarga', 'Nama Kepala Keluarga:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('nama_kepala_keluarga', null, ['class' => 'form-control', 'maxlength' => 35, 'maxlength' => 35]) !!}
                                @error('nama_kepala_keluarga')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Yang Membiayai Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('yang_membiayai', 'Yang Membiayai:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('yang_membiayai', null, ['class' => 'form-control', 'maxlength' => 10, 'maxlength' => 10]) !!}
                                @error('yang_membiayai')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kewarganegaraan Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('kewarganegaraan', 'Kewarganegaraan:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('kewarganegaraan', null, ['class' => 'form-control', 'maxlength' => 10, 'maxlength' => 10]) !!}
                                @error('kewarganegaraan')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jenis Kelamin Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('jenis_kelamin', 'Jenis Kelamin:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::select('jenis_kelamin', ['' => '', 'Laki-laki' => 'Laki-laki', 'Perempuan' => 'Perempuan'], null, ['class' => 'form-control']) !!}
                                @error('jenis_kelamin')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Agama Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('agama', 'Agama:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::select(
                                    'agama',
                                    [
                                        '' => '',
                                        'Islam' => 'Islam',
                                        'Kristen' => 'Kristen',
                                        'Katolik' => 'Katolik',
                                        'Hindu' => 'Hindu',
                                        'Budha' => 'Budha',
                                        'Konghucu' => 'Konghucu'
                                    ],
                                    null,
                                    ['class' => 'form-control']
                                ) !!}
                                @error('agama')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Anak Ke Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('anak_ke', 'Anak Ke:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::number('anak_ke', null, ['class' => 'form-control', 'maxlength' => 2, 'maxlength' => 2]) !!}
                                @error('anak_ke')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>


                            <!-- Jumlah Saudara Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('jumlah_saudara', 'Jumlah Saudara:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::number('jumlah_saudara', null, ['class' => 'form-control', 'maxlength' => 2, 'maxlength' => 2]) !!}
                                @error('jumlah_saudara')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>


                            <!-- Cita Cita Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('cita_cita', 'Cita Cita:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('cita_cita', null, ['class' => 'form-control', 'maxlength' => 10, 'maxlength' => 10]) !!}
                                @error('cita_cita')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kebutuhan Khusus Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('kebutuhan_khusus', 'Kebutuhan Khusus:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('kebutuhan_khusus', null, ['class' => 'form-control', 'maxlength' => 20, 'maxlength' => 20]) !!}
                                @error('kebutuhan_khusus')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nomor Kip Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('nomor_kip', 'Nomor KIP:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('nomor_kip', null, ['class' => 'form-control', 'maxlength' => 35, 'maxlength' => 35]) !!}
                                @error('nomor_kip')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nomor Kk Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('nomor_kk', 'Nomor KK:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('nomor_kk', null, ['class' => 'form-control', 'maxlength' => 35, 'maxlength' => 35]) !!}
                                @error('nomor_kk')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nomor Hp Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('nomor_hp', 'Nomor HP:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('nomor_hp', null, ['class' => 'form-control', 'maxlength' => 35, 'maxlength' => 35]) !!}
                                @error('nomor_hp')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Pondok Pesantren Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('pondok_pesantren', 'Pondok Pesantren:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('pondok_pesantren', null, ['class' => 'form-control', 'maxlength' => 35, 'maxlength' => 35]) !!}
                                @error('pondok_pesantren')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <h4 class="mt-5 mb-4 d-flex align-items-center">
                        <span class="px-3 py-2 badge badge-primary">Data Alamat Siswa</span>
                        <hr style="flex-grow: 1; height: 1px; background-color: #3e5fce;">
                    </h4>
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- Provinsi Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('provinsi', 'Provinsi:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('siswa[provinsi]', null, ['class' => 'form-control', 'maxlength' => 20, 'maxlength' => 20]) !!}
                                @error('siswa')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kota Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('kota', 'Kabupaten / Kota:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('siswa[kota]', null, ['class' => 'form-control', 'maxlength' => 20, 'maxlength' => 20]) !!}
                                @error('siswa')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kecamatan Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('kecamatan', 'Kecamatan:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('siswa[kecamatan]', null, ['class' => 'form-control', 'maxlength' => 20, 'maxlength' => 20]) !!}
                                @error('siswa')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Desa Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('desa', 'Desa:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('siswa[desa]', null, ['class' => 'form-control', 'maxlength' => 20, 'maxlength' => 20]) !!}
                                @error('siswa')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <!-- Rt Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('rt', 'RT:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('siswa[rt]', null, ['class' => 'form-control', 'maxlength' => 5, 'maxlength' => 5]) !!}
                                @error('siswa')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Rw Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('rw', 'RW:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('siswa[rw]', null, ['class' => 'form-control', 'maxlength' => 5, 'maxlength' => 5]) !!}
                                @error('siswa')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kode Pos Field -->
                            <div class="form-group col-sm-10">
                                {!! Form::label('kode_pos', 'Kode Pos:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::text('siswa[kode_pos]', null, ['class' => 'form-control', 'maxlength' => 8, 'maxlength' => 8]) !!}
                                @error('siswa')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Alamat Field -->
                            <div class="form-group col-sm-12 col-lg-12">
                                {!! Form::label('alamat', 'Alamat:', ['style' => 'font-weight: bold;']) !!}
                                {!! Form::textarea('siswa[alamat]', null, ['class' => 'form-control']) !!}
                                @error('siswa')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    @include('students.relation-fields', ['type' => 'AYAH'])
                    @include('students.relation-fields', ['type' => 'IBU'])
                    @include('students.relation-fields', ['type' => 'WALI'])

                    <!-- Submit Field -->
                    <div class="form-group col-sm-12 mt-5 d-flex justify-content-end gap-2">
                        <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
                        {!! Form::submit('Simpan', ['class' => 'btn btn-primary']) !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="text/javascript">
        // $('#tanggal_lahir').datetimepicker({
        //     format: 'YYYY-MM-DD HH:mm:ss',
        //     useCurrent: true,
        //     icons: {
        //         up: "icon-arrow-up-circle icons font-2xl",
        //         down: "icon-arrow-down-circle icons font-2xl"
        //     },
        //     sideBySide: true
        // })
    </script>
@endpush
