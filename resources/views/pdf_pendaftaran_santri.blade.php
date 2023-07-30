<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laporan Pendaftaran Santri</title>
    <style type="text/css" media="all">
        * {
            font-family: DejaVu Sans, sans-serif !important;
        }

        html {
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
            border: 1px solid #ededed;
        }

        table th {
            white-space: normal;
            overflow: hidden;
            text-overflow: ellipsis;
            border: 1px solid #ededed;
            padding: 5px;
            font-size: 10px;
            background-color: #ddd;
        }

        table td {
            word-wrap: break-word;
            overflow-wrap: break-word;
            /* Tambahkan baris ini */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: normal;
            /* Ubah ini */
            border: 1px solid #ededed;
            padding: 5px;
            font-size: 10px;
        }

        .header {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            text-align: center;
            margin-bottom: 10px;

        }

        .title {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .date {
            font-size: 8;
            margin-bottom: 5px;
        }

        .footer1 {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 20px;
            font-size: 14px;
            background-color: #f9f9f9;
            padding: 20px;
            text-align: left;
            font-weight: bold;
        }

        .footer1 {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 20px;
            font-size: 14px;
            background-color: #f9f9f9;
            padding: 20px;
            text-align: left;
            font-weight: bold;
        }

        .footer1-item {
            margin: 5px 0;
            font-size: 10px;
            font-weight: normal;
        }

        .footer1-item span {
            font-weight: bold;
        }

        .footer1-item.right {
            margin-left: auto;
            text-align: right;
        }

        .footer1-item.left {
            text-align: left;
        }

        .footer1-item.italic {
            font-style: italic;
            font-size: 7px;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 20px;
            font-size: 14px;
            background-color: #f9f9f9;
            padding: 20px;
            text-align: left;
            font-weight: bold;
        }

        .footer-item {
            margin: 5px 0;
            font-size: 10px;
            font-weight: normal;
        }

        .footer-item span {
            font-weight: bold;
        }

        .footer-item.right {
            margin-left: auto;
            text-align: right;
        }

        .footer-item.left {
            text-align: left;
        }

        .footer-item.italic {
            font-style: italic;
            font-size: 7px;
        }

        .logo {
            width: 75px;
            height: 75px;
            margin-left: 15px;
        }

        .table-title {
            text-align: center;
            font-size: 13px;
        }

        .report-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .report-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .report-period {
            font-size: 12px;
            color: #333;
            padding: 0;
            margin: 0;
        }

        .data-count {
            font-size: 12px;
            color: #333;
            padding: 0;
            margin: 0;
        }

        .report-period span,
        .data-count span {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="header">
            <table style="width: 100%; border: none;">
                <tr>
                    <td style="width: 15%;">
                        <img src="nurul_quran.png" alt="Nurul Qur'an" class="logo">
                    </td>
                    <td style="width: 80%;">
                        <div class="title">
                            <span class="logo-title">PONDOK PESANTREN NURUL QUR'AN KOTA BANJAR
                            </span>
                        </div>
                        <div class="subtitle">
                            <span class="logo-subtitle"> PIAGAM KEMENAG RI NO.5100032790038 Tahun 2013
                            </span>
                        </div>
                        <div class="subtitle">
                            <span class="logo-subtitle">
                                SK.KEMENAG RI NO. 5100032790038 Tahun 2013
                            </span>
                        </div>
                        <div class="address">
                            <span class="logo-address"> Dusun Citangkolo, Desa Kujangsari Kecamatan Langensari, Kota Banjar 46324</span>
                        </div>
                        <div class="contact">
                            <span class="logo-contact">Email: nurulquran01@gmail.com | Telp: 081384147813/089519792191</span>
                        </div>
                    </td>
                </tr>
            </table>
            <hr style="border-top: 3px solid #000000;">
        </div>
    </div>
    <div class="report-title">Laporan Data Pendaftaran</div> <div class="report-info">
        <div class="report-period">
            Periode: <span>{{ \Carbon\Carbon::parse($dari)->format('d/m/Y') }}</span> sampai <span>{{ \Carbon\Carbon::parse($hingga)->format('d/m/Y') }}</span>
        </div>
        <div class="data-count">
    <table>
        <thead>
            <tr>
                <th>ID Pendaftaran</th>
                <th>NIK</th>
                <th>Nama Pendaftaran</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Alamat</th>
                <th>Dibuat Pada</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $record)
            <tr>
                <td class="center-text">{{ $record->id }}</td>
                <td>{{ $record->nik }}</td>
                <td>{{ $record->nama }}</td>
                <td>{{ $record->tempat_lahir }}</td>
                <td>{{ $record->tanggal_lahir }}</td>
                <td>{{ $record->alamat }}</td>
                <td>{{ $record->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        <p class="footer-item right">Total Pendaftaran Santri:</p>

        <p class="footer-item right" style="font-size: 14px;"><span>{{ $totalRows }}</span></p>
        <p class="footer-item italic">*Informasi ini terupdate hingga tanggal {{ date('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
