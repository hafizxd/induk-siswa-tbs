<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Nilai - {{ $student->nama_lengkap }}</title>
    <style>
        @page {
            size: A4;
            margin-top: 1cm 2cm;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 20px;
            font-size: 12px;
        }

        .header {
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header .school-info {
            width: 60%;
        }
        .header img {
            height: 90px;
            width: auto;
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
        .student-info {
            font-size: 14px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            line-height: 1.2;
        }
        .student-info p {
            margin: 0;
            padding: 0;
        }
        .student-info td:first-child {
            width: 50px;
        }
        .student-info td:nth-child(2) {
            padding-right: 5px;
            padding-left: 5px;
            width: 1px;
        }
        .student-info td {
            padding-bottom: 4px;
        }
        .title {
            font-weight: bold;
            font-size: 16px;
            text-align: center;
            margin: 10px 0;
        }
        .score-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .score-table th, .score-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        .score-table th {
            font-weight: bold;
            font-size: 12px;
        }
        .score-table td {
            font-size: 12px;
        }
        .group-header {
            font-weight: bold;
            background-color: #e6e6e6;
        }
        .subject-name {
            text-align: left;
            padding-left: 15px !important;
        }
        .footer {
            font-size: 14px;
            margin-top: 40px;
            padding-left: 500px;
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
    {{-- <img class="background-img" src="{{ url('/html/assets/images/logo/logo2.png') }}" alt=""> --}}

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

    <div class="student-info">
        <table>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $student->nama_lengkap }}</td>
            </tr>
            <tr>
                <td>NIS</td>
                <td>:</td>
                <td>{{ $student->nis }}</td>
            </tr>
        </table>
        <table>
            <tr>
                <td>Madrasah</td>
                <td>:</td>
                <td>MTsS NU TASYWIQUTH THULLAB SALAFIYAH TBS KUDUS</td>
            </tr>
            <tr>
                <td>NISN</td>
                <td>:</td>
                <td>{{ $student->nisn }}</td>
            </tr>
        </table>
    </div>

    <hr>

    <div class="title">REKAP HASIL BELAJAR</div>

    <table class="score-table">
        <thead>
            <tr>
                <th rowspan="2" colspan="2">Mata Pelajaran</th>
                <th colspan="2">VII</th>
                <th colspan="2">VIII</th>
                <th colspan="2">IX</th>
                <th rowspan="2">Rata-rata</th>
            </tr>
            <tr>
                <th>Ganjil</th>
                <th>Genap</th>
                <th>Ganjil</th>
                <th>Genap</th>
                <th>Ganjil</th>
                <th>Genap</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $no = 1; 
                $avgTotal = 0;
            @endphp
            @foreach ($subjects as $subject)
                <tr>
                    <td style="text-align: left;">{{ $no++ }}</td>
                    <td style="text-align: left;">{{ $subject->name }}</td>
                    @foreach ($subject->scores as $score) 
                        <td>{{ $score }}</td>
                    @endforeach
                </tr>

                @php $avgTotal += $subject->scores[count($subject->scores)-1]; @endphp
            @endforeach 
            <tr>
                <td colspan="8" style="text-align: end;"><b>JUMLAH :</b></td>
                <td>{{ $avgTotal }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <div>Kudus, {{ \Carbon\Carbon::today()->isoFormat('D MMMM Y') }}</div>
        <div class="signature">Kepala Madrasah</div>
        <div class="signature-name">SALIM, S.Ag., M.Pd.</div>
        <div>NIP. 19690217200641009</div>
    </div>
</body>
</html>