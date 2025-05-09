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

class StudentsExportBackup extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithCustomValueBinder, WithStyles
{
    use Exportable;

    protected $request;
    protected $subjects;
    protected $subjectsUjian;
    protected $subjectsJoined;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->subjects = Subject::where('type', 'RAPOR')->select('id', 'name')->get()->toArray();
        $this->subjectsUjian = Subject::where('type', 'UJIAN')->select('id', 'name')->get()->toArray();

        // add two bumper or split between two subjects group
        $arr = array_merge($this->subjects, [
            [ 'id' => null, 'name' => null ],
            [ 'id' => null, 'name' => null ]
        ]);
        $this->subjectsJoined = array_merge($arr, $this->subjectsUjian);
    }

    public function headings(): array
    {
        $subjects = array_column($this->subjects, 'name');
        $subjects[] = '';
        $subjects[] = 'NILAI UJIAN';
        $subjects = array_merge($subjects, array_column($this->subjectsUjian, 'name'));

        return array_merge(Student::$excelHeadings, $subjects);
    }

    public function query()
    {
        $students = Student::query()->with(['relationInfos', 'scores.scoreSubjects']);

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
            $students->where('kelas_'.$kelas, $kelompok);
        }

        return $students;
    }

    public function map($student): array
    {
        $row = $this->wrapStudentArr($student);

        // NANTI GANTI INI KE SEMESTER YG UDAH READY

        $scores = array_fill(0, count($this->subjectsJoined), null);

        if (count($student->scores) > 0) {
            foreach ($student->scores[0]->scoreSubjects as $scoreSubject) {
                $index = array_search($scoreSubject->subject_id, array_column($this->subjectsJoined, 'id'));
                if ($index !== false) {
                    $scores[$index] = $scoreSubject->nilai;
                }
            }

            $scores[count($this->subjects)+1] = $student->scores[0]->nilai_ujian;
        }

        $row = array_merge($row, $scores);

        return $row;
    }

    private function wrapStudentArr($student): array
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

        $score = (count($student->scores) > 0) ? $student->scores[0] : null;

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
            '',
            isset($score) ? $score->nilai_semester_1 : '',
            isset($score) ? $score->nilai_semester_2 : '',
            isset($score) ? $score->nilai_semester_3 : '',
            isset($score) ? $score->nilai_semester_4 : '',
            isset($score) ? $score->nilai_semester_5 : '',
            isset($score) ? $score->nilai_semester_6 : '',
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
