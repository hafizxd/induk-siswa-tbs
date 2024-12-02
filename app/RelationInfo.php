<?php

namespace App;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class RelationInfo
 * @package App\Models
 * @version August 29, 2024, 10:32 am UTC
 *
 * @property \App\Student $student
 * @property integer $student_id
 * @property string $type
 * @property string $nama
 * @property string $status
 * @property string $kewarganegaraan
 * @property string $nik
 * @property string $tempat_lahir
 * @property string $pendidikan
 * @property string $pekerjaan
 * @property number $penghasilan
 * @property string $nomor_hp
 * @property string $tinggal_luar_negeri
 * @property string $kepemilikan_rumah
 * @property string $provinsi
 * @property string $kota
 * @property string $kecamatan
 * @property string $desa
 * @property string $rt
 * @property string $rw
 * @property string $kode_pos
 * @property string $alamat
 */
class RelationInfo extends Model
{
    use SoftDeletes;

    public $table = 'relation_infos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'student_id',
        'type',
        'nama',
        'status',
        'kewarganegaraan',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'pendidikan',
        'pekerjaan',
        'penghasilan',
        'nomor_hp',
        'tinggal_luar_negeri',
        'kepemilikan_rumah',
        'provinsi',
        'kota',
        'kecamatan',
        'desa',
        'rt',
        'rw',
        'kode_pos',
        'alamat'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'student_id' => 'integer',
        'type' => 'string',
        'nama' => 'string',
        'status' => 'string',
        'kewarganegaraan' => 'string',
        'nik' => 'string',
        'tempat_lahir' => 'string',
        'tanggal_lahir' => 'date',
        'pendidikan' => 'string',
        'pekerjaan' => 'string',
        'penghasilan' => 'float',
        'nomor_hp' => 'string',
        'tinggal_luar_negeri' => 'string',
        'kepemilikan_rumah' => 'string',
        'provinsi' => 'string',
        'kota' => 'string',
        'kecamatan' => 'string',
        'desa' => 'string',
        'rt' => 'string',
        'rw' => 'string',
        'kode_pos' => 'string',
        'alamat' => 'string'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function student()
    {
        return $this->belongsTo(\App\Student::class, 'student_id');
    }
}
