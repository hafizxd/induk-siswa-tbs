<?php

namespace App\Imports;

use App\Student;
use App\Subject;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Str;

class StudentUpdateImport implements OnEachRow, WithEvents, WithChunkReading, WithStartRow, WithHeadingRow
{
    use Importable, RegistersEventListeners;

    private static $arrSubjectId;
    
    public function onRow(Row $row)
    {
        if (!isset($row["nis"]) || !isset($row["nama_lengkap_siswa"])) {
            return null;
        }

        $student = Student::updateOrCreate([
            "nis" => $row["nis"],
            "nama_lengkap" => $row["nama_lengkap_siswa"],
        ], [
            "abs_9" => $row["abs_9"],
            "kelas_9" => $row["kelas_9"],
            "abs_8" => $row["abs_8"],
            "kelas_8" => $row["kelas_8"],
            "abs_7" => $row["abs_7"],
            "kelas_7" => $row["kelas_7"],
            "tahun_masuk" => $row["tahun_masuk"],
            "tahun_mutasi" => $row["tahun_mutasi"],
            "status_mutasi" => $row["status_mutasi"],
            "status_pendaftar" => $row["status_pendaftar_asal"],
            "nomor_test" => $row["nomor_test"],
            "nisn" => $row["nisn"],
            "nik" => $row["nik"],
            "tempat_lahir" => $row["tempat_lahir_siswa"],
            "tanggal_lahir" => $row["tanggal_lahir_siswa"],
            "asal_sekolah" => $row["asal_sekolah"],
            "prasekolah" => $row["prasekolah"],
            "nama_kepala_keluarga" => $row["nama_kepala_keluarga"],
            "yang_membiayai" => $row["yang_membiayai_sekolah"],
            "kewarganegaraan" => $row["kewarganegaraan"],
            "jenis_kelamin" => $row["jenis_kelamin"],
            "agama" => $row["agama"],
            "anak_ke" => $row["anak_ke"],
            "jumlah_saudara" => $row["jumlah_saudara"],
            "cita_cita" => $row["cita_cita"],
            "kebutuhan_khusus" => $row["kebutuhan_khusus"],
            "nomor_kip" => $row["nomor_kip"],
            "nomor_kk" => $row["nomor_kk"],
            "nomor_hp" => $row["nomor_hp_siswa"],
            "pondok_pesantren" => $row["pondok_pesantren"]
        ]);

        $student->relationInfos()->updateOrCreate([
            'type' => 'AYAH',
        ], [
            'nama' => $row['nama_lengkap_ayah'],
            'status' => $row['status_ayah'],
            'kewarganegaraan' => $row['kewarganegaraan_ayah'],
            'nik' => $row['nik_ayah'],
            'tempat_lahir' => $row['tempat_lahir_ayah'],
            'tanggal_lahir' => $row['tanggal_lahir_ayah'],
            'pendidikan' => $row['pendidikan_terakhir_ayah'],
            'pekerjaan' => $row['pekerjaan_utama_ayah'],
            'penghasilan' => $row['penghasilan_rata_rata_ayah'],
            'nomor_hp' => $row['nomor_hp_ayah'],
            'tinggal_luar_negeri' => $row['tinggal_luar_negeri_ayah'],
            'kepemilikan_rumah' => $row['kepemilikan_rumah_ayah'],
            'provinsi' => $row['provinsi_ayah'],
            'kota' => $row['kabupatenkota_ayah'],
            'kecamatan' => $row['kecamatan_ayah'],
            'desa' => $row['kelurahandesa_ayah'],
            'rt' => $row['rt_ayah'],
            'rw' => $row['rw_ayah'],
            'kode_pos' => $row['kode_pos_ayah'],
            'alamat' => $row['alamat_ayah'],
        ]);

        $student->relationInfos()->updateOrCreate([
            'type' => 'IBU',
        ], [
            'nama' => $row['nama_lengkap_ibu'],
            'status' => $row['status_ibu'],
            'kewarganegaraan' => $row['kewarganegaraan_ibu'],
            'nik' => $row['nik_ibu'],
            'tempat_lahir' => $row['tempat_lahir_ibu'],
            'tanggal_lahir' => $row['tanggal_lahir_ibu'],
            'pendidikan' => $row['pendidikan_terakhir_ibu'],
            'pekerjaan' => $row['pekerjaan_utama_ibu'],
            'penghasilan' => $row['penghasilan_rata_rata_ibu'],
            'nomor_hp' => $row['nomor_hp_ibu'],
            'provinsi' => $row['provinsi_ibu'],
            'kota' => $row['kabupatenkota_ibu'],
            'kecamatan' => $row['kecamatan_ibu'],
            'desa' => $row['kelurahandesa_ibu'],
            'rt' => $row['rt_ibu'],
            'rw' => $row['rw_ibu'],
            'kode_pos' => $row['kode_pos_ibu'],
            'alamat' => $row['alamat_ibu'],
        ]);

        $student->relationInfos()->updateOrCreate([
            'type' => 'WALI',
        ], [
            'nama' => $row['nama_lengkap_wali'],
            'kewarganegaraan' => $row['kewarganegaraan_wali'],
            'nik' => $row['nik_wali'],
            'tempat_lahir' => $row['tempat_lahir_wali'],
            'tanggal_lahir' => $row['tanggal_lahir_wali'],
            'pendidikan' => $row['pendidikan_terakhir_wali'],
            'pekerjaan' => $row['pekerjaan_utama_wali'],
            'penghasilan' => $row['penghasilan_rata_rata_wali'],
            'nomor_hp' => $row['nomor_hp_wali'],
            'provinsi' => $row['provinsi_wali'],
            'kota' => $row['kabupatenkota_wali'],
            'kecamatan' => $row['kecamatan_wali'],
            'desa' => $row['kelurahandesa_wali'],
            'rt' => $row['rt_wali'],
            'rw' => $row['rw_wali'],
            'kode_pos' => $row['kode_pos_wali'],
            'alamat' => $row['alamat_wali'],
        ]);

        $student->relationInfos()->updateOrCreate([
            'type' => 'SISWA',
        ], [
            'provinsi' => $row['provinsi_siswa'],
            'kota' => $row['kabupatenkota_siswa'],
            'kecamatan' => $row['kecamatan_siswa'],
            'desa' => $row['kelurahandesa_siswa'],
            'rt' => $row['rt_siswa'],
            'rw' => $row['rw_siswa'],
            'kode_pos' => $row['kode_pos_siswa'],
            'alamat' => $row['alamat_siswa'],
        ]);

        $score = $student->scores()->updateOrCreate([
            'semester' => 1,
        ], [
            'nilai_semester' => $row['nilai_semester_1'],
        ]);

        // "CT" Column to int = 98
        $arrScoreSubjects = [];
        foreach (self::$arrSubjectId as $key => $subject) {
            $studentScore = $row[$subject['header']];
            if (!isset($studentScore)) {
                continue;
            }
 
            $arrScoreSubjects[] = [
                'subject_id' => $subject['id'],
                'nilai' => $studentScore
            ];
        }

        $score->scoreSubjects()->updateOrCreate(['subject_id' => $arrScoreSubjects['subject_id']], $arrScoreSubjects);
    }

    public static function beforeSheet(BeforeSheet $event)
    {
        // "CT" Column to int = 98
        $colIndex = 98;
        $arrSubjectId = [];

        while (true) {
            $cellValue = $event->sheet->getCellByColumnAndRow($colIndex, 1)->getValue();
            if (!isset($cellValue)) {
                break;
            }

            $subject = Subject::firstOrCreate(['name' => $cellValue]);
            $arrSubjectId[] = [
                'header' => Str::slug($cellValue, '_'),
                'id' => $subject->id
            ];

            $colIndex++;
        }

        self::$arrSubjectId = $arrSubjectId;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
