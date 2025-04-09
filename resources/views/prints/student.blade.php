<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Identitas Peserta Didik - {{ $student->nama_lengkap }}</title>
    <style>
        @page {
            size: A4;
            margin: 1cm 2cm;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Times New Roman', Times, serif;
        }

        body {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 20px;
            font-size: 15px;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header img {
            height: 90px;
            width: auto;
        }
        .header .school-info {
            width: 60%;
        }
        .ministry {
            font-weight: bold;
            font-size: 14px;
        }
        hr {
            height: 0;
            border: none;
            border-top: 1px solid #212121;
            padding: 0.4px 0;
            border-bottom: 1px solid #212121;
            margin: 5px 0;
        }
        .school-name {
            font-family: 'Times New Roman', Times, serif;
            font-weight: bold;
            font-size: 22px;
            line-height: 1.1;
        }
        .school-address {
            font-family: 'Times New Roman', Times, serif;
            font-style: italic;
            font-size: 14px;
        }

        .identity-section {
            margin-bottom: 20px;
        }

        .photo-placeholder {
            width: 3cm;
            border: 1px solid #000;
            height: 4cm;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .identity-table {
            width: 100%;
            border-collapse: collapse;
        }

        .identity-table td:first-child {
            width: 25px;
        }

        .identity-table td:nth-child(2) {
            width: 200px;
        }

        .identity-table td:nth-child(3) {
            width: 1px;
            padding-left: 5px;
            padding-right: 5px;
        }

        .identity-table td {
            /* padding: 5px; */
            border: none;
        }

        .footer {
            margin-top: 40px;
            display: flex;
            gap: 100px;
        }

        .signature-wrapper {
            font-size: 14px;
        }
        .signature-name {
            margin-top: 70px;
            font-weight: bold;
        }

        @media print {
            body {
                width: 100%;
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-left">
            <img src="{{ url('/assets/img/logo2.png') }}" alt="Logo1">
        </div>

        <div class="school-info">
            <div class="ministry">KEMENTERIAN AGAMA REPUBLIK INDONESIA</div>
            <div class="school-name">MTSS NU TASYWIQUTH THULLAB SALAFIYAH TBS KUDUS</div>
            <div class="school-address">JL. KH. TURAICHAN ADJHURI NO. 23<br>Kecamatan Kota Kudus, Kabupaten Kudus - Jawa Tengah</div>
        </div>

        <div class="logo-right">
            <img src="{{ url('/html/assets/images/logo/logo2.png') }}" alt="Logo2">
        </div>
    </div>

    <hr>

    <h2 style="text-align:center; margin-bottom:10px; font-size: 18px; font-family: 'Times New Roman', Times, serif;">IDENTITAS PESERTA DIDIK</h2>

    <div class="identity-section">
        <div class="identity-details">
            <table class="identity-table">
                <tr>
                    <td>1.</td>
                    <td>Nama Peserta Didik</td>
                    <td>:</td>
                    <td>{{ $student->nama_lengkap }}</td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>NIS</td>
                    <td>:</td>
                    <td>{{ $student->nis }}</td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td>NISN</td>
                    <td>:</td>
                    <td>{{ $student->nisn }}</td>
                </tr>
                <tr>
                    <td>4.</td>
                    <td>Tempat Tanggal Lahir</td>
                    <td>:</td>
                    <td>{{ $student->tempat_lahir }}, {{ $student->tanggal_lahir }}</td>
                </tr>
                <tr>
                    <td>5.</td>
                    <td>Jenis Kelamin</td>
                    <td>:</td>
                    <td>{{ $student->jenis_kelamin }}</td>
                </tr>
                <tr>
                    <td>6.</td>
                    <td>Agama</td>
                    <td>:</td>
                    <td>{{ $student->agama }}</td>
                </tr>
                <tr>
                    <td>7.</td>
                    <td>Anak ke</td>
                    <td>:</td>
                    <td>{{ $student->anak_ke }}</td>
                </tr>
                <tr>
                    <td>8.</td>
                    <td>Alamat Peserta Didik</td>
                    <td>:</td>
                    <td>{{ isset($relationSiswa) ? $relationSiswa->alamat : '-' }}</td>
                </tr>
                <tr>
                    <td>9.</td>
                    <td>Nomor Telepon Rumah/HP</td>
                    <td>:</4td>
                    <td>{{ $student->no_hp }}</td>
                </tr>
                <tr>
                    <td>10.</td>
                    <td>Sekolah Asal</td>
                    <td>:</td>
                    <td>{{ $student->asal_sekolah }}</td>
                </tr>
                <tr>
                    <td>11.</td>
                    <td>Diterima di sekolah ini</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>a. Di kelas</td>
                    <td>:</td>
                    <td>
                        @php 
                            $class = '-';
                            if (isset($student->kelas_7))
                                $class = '7 ' . $student->kelas_7;
                            else if (isset($student->kelas_8))
                                $class = '8 ' . $student->kelas_8;
                            else if (isset($student->kelas_9))
                                $class = '9 ' . $student->kelas_9;
                        @endphp
                        {{ $class }}
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>b. Pada tahun</td>
                    <td>:</td>
                    <td>{{ $student->tahun_mutasi }}</td>
                </tr>
                <tr>
                    <td>12.</td>
                    <td>Nama Orang Tua</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>a. Ayah</td>
                    <td>:</td>
                    <td>{{ $relationAyah->nama }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td>b. Ibu</td>
                    <td>:</td>
                    <td>{{ $relationIbu->nama }}</td>
                </tr>
                <tr>
                    <td>13.</td>
                    <td>Alamat Orang Tua</td>
                    <td>:</td>
                    <td>{{ $relationAyah->alamat }}</td>
                </tr>
                <tr>
                    <td>14.</td>
                    <td>Pekerjaan Orang Tua</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>a. Ayah</td>
                    <td>:</td>
                    <td>{{ $relationAyah->pekerjaan }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td>b. Ibu</td>
                    <td>:</td>
                    <td>{{ $relationIbu->pekerjaan }}</td>
                </tr>
                <tr>
                    <td>15.</td>
                    <td>Nama Wali Siswa</td>
                    <td>:</td>
                    <td>{{ $relationWali->nama }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Pekerjaan Wali</td>
                    <td>:</td>
                    <td>{{ $relationWali->pekerjaan }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Alamat Wali Siswa</td>
                    <td>:</td>
                    <td>{{ $relationWali->alamat }}</td>
                </tr>                       
            </table>
        </div>
    </div>


    <div class="footer">
        <div class="photo-placeholder">
            Foto 3x4
        </div>

        <div class="signature-wrapper">
            <div>Kudus, {{ \Carbon\Carbon::today()->isoFormat('D MMMM Y') }}</div>
            <div class="signature">Kepala Madrasah</div>
            <div class="signature-name">SALIM, S.Ag., M.Pd.</div>
            <div>NIP. 19690217200641009</div>
        </div>
    </div>
</body>
</html>