<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laporan Data Santri</title>
    <style type="text/css" media="all">
        * {
            font-family: DejaVu Sans, sans-serif !important;
        }

        html,
        body,
        table {
            width: 100%;
        }

        table {
            border-collapse: collapse;
            table-layout: auto;
            border: 1px solid #ededed;
        }

        table th,
        table td {
            word-wrap: break-word;
            overflow-wrap: break-word;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: normal;
            border: 1px solid #ededed;
            padding: 5px;
            font-size: 10px;
            background-color: #ddd;
        }

        table td {
            background-color: #fff;
        }

        .header,
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

        .header-item,
        .footer-item {
            margin: 5px 0;
            font-size: 10px;
            font-weight: normal;
        }

        .header-item span,
        .footer-item span {
            font-weight: bold;
            font-size: 20px;
        }

        .header-item.right,
        .footer-item.right {
            margin-left: auto;
            text-align: right;
        }

        .header-item.left,
        .footer-item.left {
            text-align: left;
        }

        .header-item.italic,
        .footer-item.italic {
            font-style: italic;
            font-size: 7px;
        }

        .report-title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .report-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .report-info,
        .data-count {
            font-size: 10px;
            color: #333;
            padding: 0;
            margin: 0;
        }

        .report-period span,
        .data-count span {
            font-weight: bold;
        }

        .center-text {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <!-- Your header here -->
    </div>
    <div class="report-title">Laporan Data Santri</div>
    <div class="report-info">

        <div class="report-info">
            Kelas: <span>{{ $kelas_nama }}</span>
            Kamar: <span>{{ $kamar_nama }}</span>
        </div>

        <div class="data-count">

        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID Pendaftaran</th>
                <th>Nama Pendaftaran</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($records as $record)
            <tr>
                <td class="center-text">{{ $record->id }}</td>
                <td>{{ $record->nama }}</td>
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
