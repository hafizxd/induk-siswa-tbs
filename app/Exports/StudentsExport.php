<?php

namespace App\Exports;

use App\Student;
use App\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithCustomValueBinder, WithStyles
{
    use Exportable;

    protected $request;
    protected $subjects;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {
        return Student::$excelHeadings;
    }

    public function query()
    {
        $students = Student::query()->with(['relationInfos']);

        if (!empty($this->request->masukStart)) {
            $students->where('tahun_masuk', '>=', $this->request->masukStart);
        }
        if (!empty($this->request->masukEnd)) {
            $students->where('tahun_masuk', '<=', $this->request->masukEnd);
        }
        if (!empty($this->request->mutasiStart)) {
            $students->where('tahun_mutasi', '>=', $this->request->mutasiStart);
        }
        if (!empty($this->request->mutasiEnd)) {
            $students->where('tahun_mutasi', '<=', $this->request->mutasiEnd);
        }
        if (!empty($this->request->class)) {
            $arrClass = explode('-', $this->request->class);
            $kelas = $arrClass[0];
            $kelompok = $arrClass[1];
            $students->where('kelas_'.$kelas, $kelompok)
                ->orderBy('tahun_masuk', 'desc')
                ->orderBy('abs_'.$kelas);
        } else {
            $students->orderBy('tahun_masuk', 'desc')
                ->orderBy('kelas_9')
                ->orderBy('abs_9')
                ->orderBy('kelas_8')
                ->orderBy('abs_8')
                ->orderBy('kelas_7')
                ->orderBy('abs_7');
        }

        return $students;
    }

    public function map($student): array
    {
        $ayah = [];
        $ibu = [];
        $wali = [];
        $siswa = [];
        foreach ($student->relationInfos as $rel) {
            switch ($rel->type) {
                case 'AYAH':
                    $ayah = $rel;
                    break;

                case 'IBU':
                    $ibu = $rel;
                    break;

                case 'WALI':
                    $wali = $rel;
                    break;

                case 'SISWA':
                    $siswa = $rel;
                    break;
            }
        }

        return [
            $student->abs_9,
            $student->kelas_9,
            $student->abs_8,
            $student->kelas_8,
            $student->abs_7,
            $student->kelas_7,
            $student->tahun_masuk,
            $student->tahun_mutasi,
            $student->status_mutasi,
            $student->status_pendaftar,
            $student->nomor_test,
            $student->nisn,
            $student->nik,
            $student->nis,
            $student->nama_lengkap,
            $student->photo_url,
            $student->tempat_lahir,
            isset($student->tanggal_lahir) ? $student->tanggal_lahir->format('d/m/Y') : null,
            $student->asal_sekolah,
            $student->prasekolah,
            $student->nama_kepala_keluarga,
            $student->yang_membiayai,
            $student->kewarganegaraan,
            $student->jenis_kelamin,
            $student->agama,
            $student->anak_ke,
            $student->jumlah_saudara,
            $student->cita_cita,
            $student->kebutuhan_khusus,
            $student->nomor_kip,
            $student->nomor_kk,
            $student->nomor_hp,

            $ayah->nama ?? '',
            $ayah->status ?? '',
            $ayah->kewarganegaraan ?? '',
            $ayah->nik ?? '',
            $ayah->tempat_lahir ?? '',
            isset($ayah->tanggal_lahir) ? $ayah->tanggal_lahir->format('d/m/Y') : null,
            $ayah->pendidikan ?? '',
            $ayah->pekerjaan ?? '',
            $ayah->penghasilan ?? '',
            $ayah->nomor_hp ?? '',
            $ayah->tinggal_luar_negeri ?? '',
            $ayah->kepemilikan_rumah ?? '',
            $ayah->provinsi ?? '',
            $ayah->kota ?? '',
            $ayah->kecamatan ?? '',
            $ayah->desa ?? '',
            $ayah->rt ?? '',
            $ayah->rw ?? '',
            $ayah->kode_pos ?? '',
            $ayah->alamat ?? '',

            $ibu->nama ?? '',
            $ibu->status ?? '',
            $ibu->kewarganegaraan ?? '',
            $ibu->nik ?? '',
            $ibu->tempat_lahir ?? '',
            isset($ibu->tanggal_lahir) ? $ibu->tanggal_lahir->format('d/m/Y') : null,
            $ibu->pendidikan ?? '',
            $ibu->pekerjaan ?? '',
            $ibu->penghasilan ?? '',
            $ibu->nomor_hp ?? '',
            $ibu->provinsi ?? '',
            $ibu->kota ?? '',
            $ibu->kecamatan ?? '',
            $ibu->desa ?? '',
            $ibu->rt ?? '',
            $ibu->rw ?? '',
            $ibu->kode_pos ?? '',
            $ibu->alamat ?? '',

            $wali->nama ?? '',
            $wali->kewarganegaraan ?? '',
            $wali->nik ?? '',
            $wali->tempat_lahir ?? '',
            isset($wali->tanggal_lahir) ? $wali->tanggal_lahir->format('d/m/Y') : null,
            $wali->pendidikan ?? '',
            $wali->pekerjaan ?? '',
            $wali->penghasilan ?? '',
            $wali->nomor_hp ?? '',
            $wali->provinsi ?? '',
            $wali->kota ?? '',
            $wali->kecamatan ?? '',
            $wali->desa ?? '',
            $wali->rt ?? '',
            $wali->rw ?? '',
            $wali->kode_pos ?? '',
            $wali->alamat ?? '',

            $siswa->provinsi ?? '',
            $siswa->kota ?? '',
            $siswa->kecamatan ?? '',
            $siswa->desa ?? '',
            $siswa->rt ?? '',
            $siswa->rw ?? '',
            $siswa->kode_pos ?? '',
            $siswa->alamat ?? '',

            $student->pondok_pesantren,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => [
                'font' => [
                    'bold' => true, 
                    'size' => 10,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'wrapText' => false,
                ],
            ],
        ];
    }
}
