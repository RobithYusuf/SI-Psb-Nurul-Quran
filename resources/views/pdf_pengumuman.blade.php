<!DOCTYPE html>
<html>

<head>
    <title>Pengumuman Penerimaan Santri</title>
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
    <h2>Pondok Pesantren Nurul Quran</h2>
    <p>No: PPNQ/VII/2023</p>
    <p>Lampiran: 1 berkas</p>
    <p>Perihal: Pengumuman Hasil Kelulusan Santri</p>
    <br>
    <p>Assalamu'alaikum Wr. Wb.,</p>
    <p>
        Dengan memohon rahmat dan ridho Allah SWT, kami sampaikan bahwa berdasarkan hasil penilaian dan evaluasi yang telah dilakukan oleh tim Panitia PSB Pondok Pesantren Nurul Quran, telah ditentukan pendaftar dengan identitas:
    </p>
    <ul>
        <li>Nama: {{ $pendaftaran->nama }}</li>
        <li>NIK: {{ $pendaftaran->nik }}</li>
        <li>Tempat, Tanggal Lahir: {{ $pendaftaran->tempat_lahir }}, {{ $pendaftaran->tanggal_lahir }}</li>
        <li>Alamat: {{ $pendaftaran->alamat }}</li>
    </ul>

    <p>
        Peserta pendaftaran tersebut memperoleh nilai kompetensi dasar agama dengan {{ $seleksi->nilai_test }},
        nilai test wawancara dengan {{ $seleksi->nilai_wawancara }}, dan nilai ujian test BTQ nilai {{ $seleksi->nilai_btq }},
        sehingga total nilai yang di peroleh adalah {{ $seleksi->total_nilai }},
        @if($seleksi->total_nilai >= 75)
        <br>
    <p>
        Dengan hasil nilai tersebut kami pihak panitia PSB menyatakan  <strong> LOLOS</strong> pada pendaftaran dan ujian test yang telah dilakukan.
        Sehingga peserta harus melakukan pendaftaran ulang terhitung 1 minggu setelah surat pengumuman disampaikan.
    </p>
    <p>
        nb : pendaftaran ulang wajib membawa print surat pengumuman, fotocopy kk,akta kelahiran,dan ijazah terakhir.
    </p>

    @else
    Dengan hasil nilai tersebut kami pihak panitia PSB menyatakan <strong>TIDAK LOLOS</strong> pada pendaftaran dan ujian test yang telah dilakukan. Tetap semangat dan teruslah mencari ilmu.
    @endif
    </p>

    <p>
        Demikian pengumuman ini kami buat.
        Atas perhatiannya, kami ucapkan terima kasih.
    </p>

    <p>Wassalamu'alaikum Wr. Wb.,</p>
    <p>{{ \Carbon\Carbon::now()->format('d F Y') }}</p>
    <p>Pengurus Pondok Pesantren Nurul Quran</p>
</body>

</html>
