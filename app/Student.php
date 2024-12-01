<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    public $table = 'students';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'abs_9',
        'kelas_9',
        'abs_8',
        'kelas_8',
        'abs_7',
        'kelas_7',
        'tahun_masuk',
        'tahun_mutasi',
        'status_mutasi',
        'status_pendaftar',
        'nomor_test',
        'nisn',
        'nik',
        'nis',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'asal_sekolah',
        'prasekolah',
        'nama_kepala_keluarga',
        'yang_membiayai',
        'kewarganegaraan',
        'jenis_kelamin',
        'agama',
        'anak_ke',
        'jumlah_saudara',
        'cita_cita',
        'kebutuhan_khusus',
        'nomor_kip',
        'nomor_kk',
        'nomor_hp',
        'pondok_pesantren'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'abs_9' => 'string',
        'kelas_9' => 'string',
        'abs_8' => 'string',
        'kelas_8' => 'string',
        'abs_7' => 'string',
        'kelas_7' => 'string',
        'tahun_masuk' => 'string',
        'tahun_mutasi' => 'string',
        'status_mutasi' => 'string',
        'status_pendaftar' => 'string',
        'nomor_test' => 'string',
        'nisn' => 'string',
        'nik' => 'string',
        'nis' => 'string',
        'nama_lengkap' => 'string',
        'tempat_lahir' => 'string',
        'tanggal_lahir' => 'date',
        'asal_sekolah' => 'string',
        'prasekolah' => 'string',
        'nama_kepala_keluarga' => 'string',
        'yang_membiayai' => 'string',
        'kewarganegaraan' => 'string',
        'jenis_kelamin' => 'string',
        'agama' => 'string',
        'anak_ke' => 'integer',
        'jumlah_saudara' => 'integer',
        'cita_cita' => 'string',
        'kebutuhan_khusus' => 'string',
        'nomor_kip' => 'string',
        'nomor_kk' => 'string',
        'nomor_hp' => 'string',
        'pondok_pesantren' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'abs_9' => 'nullable|string|max:20',
        'kelas_9' => 'nullable|string|max:20',
        'abs_8' => 'nullable|string|max:20',
        'kelas_8' => 'nullable|string|max:20',
        'abs_7' => 'nullable|string|max:20',
        'kelas_7' => 'nullable|string|max:20',
        'tahun_masuk' => 'nullable|string|max:4',
        'tahun_mutasi' => 'nullable|string|max:4',
        'status_mutasi' => 'nullable|string|max:10',
        'status_pendaftar' => 'nullable|string|max:20',
        'nomor_test' => 'nullable|string|max:20',
        'nisn' => 'nullable|string|max:20',
        'nik' => 'nullable|string|max:20',  
        'nis' => 'required|string|max:20',
        'nama_lengkap' => 'required|string|max:20',
        'tempat_lahir' => 'nullable|string|max:20',
        'tanggal_lahir' => 'nullable',
        'asal_sekolah' => 'nullable|string|max:35',
        'prasekolah' => 'nullable|string|max:35',
        'nama_kepala_keluarga' => 'nullable|string|max:35',
        'yang_membiayai' => 'nullable|string|max:10',
        'kewarganegaraan' => 'nullable|string|max:10',
        'jenis_kelamin' => 'nullable|string|max:10',
        'agama' => 'nullable|string|max:10',
        'anak_ke' => 'nullable|numeric',
        'jumlah_saudara' => 'nullable|numeric',
        'cita_cita' => 'nullable|string|max:10',
        'kebutuhan_khusus' => 'nullable|string|max:20',
        'nomor_kip' => 'nullable|string|max:35',
        'nomor_kk' => 'nullable|string|max:35',
        'nomor_hp' => 'nullable|string|max:35',
        'pondok_pesantren' => 'nullable|string|max:35',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',

        'siswa.provinsi' => 'nullable|string|max:20',
        'siswa.kota' => 'nullable|string|max:20',
        'siswa.kecamatan' => 'nullable|string|max:20',
        'siswa.desa' => 'nullable|string|max:20',
        'siswa.rt' => 'nullable|string|max:5',
        'siswa.rw' => 'nullable|string|max:5',
        'siswa.kode_pos' => 'nullable|string|max:8',
        'siswa.alamat' => 'nullable|string',

        'ayah.nama' => 'nullable|string|max:35',
        'ayah.status' => 'nullable|string|max:35',
        'ayah.kewarganegaraan' => 'nullable|string|max:35',
        'ayah.nik' => 'nullable|string|max:35',
        'ayah.tempat_lahir' => 'nullable|string|max:35',
        'ayah.tanggal_lahir' => 'nullable',
        'ayah.pendidikan' => 'nullable|string|max:35',
        'ayah.pekerjaan' => 'nullable|string|max:35',
        'ayah.penghasilan' => 'nullable|numeric',
        'ayah.nomor_hp' => 'nullable|string|max:15',
        'ayah.tinggal_luar_negeri' => 'nullable|string|max:35',
        'ayah.kepemilikan_rumah' => 'nullable|string|max:35',
        'ayah.provinsi' => 'nullable|string|max:20',
        'ayah.kota' => 'nullable|string|max:20',
        'ayah.kecamatan' => 'nullable|string|max:20',
        'ayah.desa' => 'nullable|string|max:20',
        'ayah.rt' => 'nullable|string|max:5',
        'ayah.rw' => 'nullable|string|max:5',
        'ayah.kode_pos' => 'nullable|string|max:8',
        'ayah.alamat' => 'nullable|string',

        'ibu.nama' => 'nullable|string|max:35',
        'ibu.status' => 'nullable|string|max:35',
        'ibu.kewarganegaraan' => 'nullable|string|max:35',
        'ibu.nik' => 'nullable|string|max:35',
        'ibu.tempat_lahir' => 'nullable|string|max:35',
        'ibu.tanggal_lahir' => 'nullable',
        'ibu.pendidikan' => 'nullable|string|max:35',
        'ibu.pekerjaan' => 'nullable|string|max:35',
        'ibu.penghasilan' => 'nullable|numeric',
        'ibu.nomor_hp' => 'nullable|string|max:15',
        'ibu.provinsi' => 'nullable|string|max:20',
        'ibu.kota' => 'nullable|string|max:20',
        'ibu.kecamatan' => 'nullable|string|max:20',
        'ibu.desa' => 'nullable|string|max:20',
        'ibu.rt' => 'nullable|string|max:5',
        'ibu.rw' => 'nullable|string|max:5',
        'ibu.kode_pos' => 'nullable|string|max:8',
        'ibu.alamat' => 'nullable|string',

        'wali.nama' => 'nullable|string|max:35',
        'wali.kewarganegaraan' => 'nullable|string|max:35',
        'wali.nik' => 'nullable|string|max:35',
        'wali.tempat_lahir' => 'nullable|string|max:35',
        'wali.tanggal_lahir' => 'nullable',
        'wali.pendidikan' => 'nullable|string|max:35',
        'wali.pekerjaan' => 'nullable|string|max:35',
        'wali.penghasilan' => 'nullable|numeric',
        'wali.nomor_hp' => 'nullable|string|max:15',
        'wali.provinsi' => 'nullable|string|max:20',
        'wali.kota' => 'nullable|string|max:20',
        'wali.kecamatan' => 'nullable|string|max:20',
        'wali.desa' => 'nullable|string|max:20',
        'wali.rt' => 'nullable|string|max:5',
        'wali.rw' => 'nullable|string|max:5',
        'wali.kode_pos' => 'nullable|string|max:8',
        'wali.alamat' => 'nullable|string',
    ];

    /**
     * Export Headings
     *
     * @var array
     */
    public static $excelHeadings = [
        "ABS 9",
        "KELAS 9",
        "ABS 8",
        "KELAS 8",
        "ABS 7",
        "KELAS 7",
        "TAHUN MASUK",
        "TAHUN MUTASI",
        "STATUS MUTASI",
        "STATUS PENDAFTAR ASAL",
        "NOMOR TEST",
        "NISN",
        "NIK",
        "NIS",
        "NAMA LENGKAP SISWA",
        "TEMPAT LAHIR SISWA",
        "TANGGAL LAHIR SISWA",
        "ASAL SEKOLAH",
        "PRASEKOLAH",
        "NAMA KEPALA KELUARGA",
        "YANG MEMBIAYAI SEKOLAH",
        "KEWARGANEGARAAN",
        "JENIS KELAMIN",
        "AGAMA",
        "ANAK KE",
        "JUMLAH SAUDARA",
        "CITA CITA",
        "KEBUTUHAN KHUSUS",
        "NOMOR KIP",
        "NOMOR KK",
        "NOMOR HP SISWA",

        "NAMA LENGKAP AYAH",
        "STATUS AYAH",
        "KEWARGANEGARAAN AYAH",
        "NIK AYAH",
        "TEMPAT LAHIR AYAH",
        "TANGGAL LAHIR AYAH",
        "PENDIDIKAN TERAKHIR AYAH",
        "PEKERJAAN UTAMA AYAH",
        "PENGHASILAN RATA RATA AYAH",
        "NOMOR HP AYAH",
        "TINGGAL LUAR NEGERI AYAH",
        "KEPEMILIKAN RUMAH AYAH",
        "PROVINSI AYAH",
        "KABUPATEN/KOTA AYAH",
        "KECAMATAN AYAH",
        "KELURAHANDESA AYAH",
        "RT AYAH",
        "RW AYAH",
        "KODE POS AYAH",
        "ALAMAT AYAH",

        "NAMA LENGKAP IBU",
        "STATUS IBU",
        "KEWARGANEGARAAN IBU",
        "NIK IBU",
        "TEMPAT LAHIR IBU",
        "TANGGAL LAHIR IBU",
        "PENDIDIKAN TERAKHIR IBU",
        "PEKERJAAN UTAMA IBU",
        "PENGHASILAN RATA RATA IBU",
        "NOMOR HP IBU",
        "PROVINSI IBU",
        "KABUPATEN/KOTA IBU",
        "KECAMATAN IBU",
        "KELURAHANDESA IBU",
        "RT IBU",
        "RW IBU",
        "KODE POS IBU",
        "ALAMAT IBU",

        "NAMA LENGKAP WALI",
        "KEWARGANEGARAAN WALI",
        "NIK WALI",
        "TEMPAT LAHIR WALI",
        "TANGGAL LAHIR WALI",
        "PENDIDIKAN TERAKHIR WALI",
        "PEKERJAAN UTAMA WALI",
        "PENGHASILAN RATA RATA WALI",
        "NOMOR HP WALI",
        "PROVINSI WALI",
        "KABUPATEN/KOTA WALI",
        "KECAMATAN WALI",
        "KELURAHANDESA WALI",
        "RT WALI",
        "RW WALI",
        "KODE POS WALI",
        "ALAMAT WALI",

        "PROVINSI SISWA",
        "KABUPATEN/KOTA SISWA",
        "KECAMATAN SISWA",
        "KELURAHANDESA SISWA",
        "RT SISWA",
        "RW SISWA",
        "KODE POS SISWA",
        "ALAMAT SISWA",

        "PONDOK PESANTREN",
        "",
        "NILAI SEMESTER 1",
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function relationInfos()
    {
        return $this->hasMany(\App\RelationInfo::class, 'student_id');
    }

    public function scores()
    {
        return $this->hasMany(\App\Score::class, 'student_id');
    }
}
