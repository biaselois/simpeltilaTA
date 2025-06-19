<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Berita Acara</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12px;
        }

        .kop-surat {
            width: 100%;
            border-bottom: 2px solid black;
            padding-bottom: 5px;
        }

        .kop-surat td {
            vertical-align: middle;
        }

        .logo {
            width: 90px;
        }

        .text-header {
            text-align: center;
        }

        .text-header h2 {
            margin: 0;
            font-size: 18pt;
            font-weight: bold;
        }

        .text-header h3 {
            margin: 0;
            font-size: 14pt;
            font-weight: bold;
        }

        .text-header p {
            margin: 2px 0;
            font-size: 11pt;
        }

        .garis-bawah {
            border-bottom: 1px solid black;
            margin-top: 2px;
        }

        table,
        th,
        td {
            border-collapse: collapse;
        }

        .center {
            text-align: center;
        }

        .header img {
            width: 70px;
        }

        .bordered {
            border: 1px solid black;
        }

        .signature {
            height: 60px;
        }

    </style>

</head>

<body>

    <table class="kop-surat">
        <tr>
            <td style="width: 100px;">
                <img src="{{ $base64Logo }}" class="logo">
            </td>
            <td class="text-header">
                <h2>PEMERINTAH KABUPATEN BANYUWANGI</h2>
                <h3>BADAN PENDAPATAN DAERAH</h3>
                <p>Jl. Jaksa Agung Suprapto No. 37 Banyuwangi</p>
                <p>http://www.banyuwangikab.go.id E-mail : bapenda@banyuwangikab.go.id</p>
            </td>
        </tr>
    </table>

    <h4 class="center">LAPORAN PENELITIAN LAPANGAN/KANTOR PBB-P2/BPHTB</h4>

    <p>
        Berdasarkan Permohonan Pelayanan dengan Nomor {{ $data->jadwal->permohonan->nomordokumen ?? '-' }} tanggal :
        {{ $data->tanggal ?? '-' }}, <br>
        kami telah melakukan penelitian/pemeriksaan terhadap objek pajak/kondisi wajib pajak :
    </p>

    <table style="width: 100%;">
        <tr>
            <td width="30%">Nama Wajib Pajak</td>
            <td>: {{ $data->Nama_WP }}</td>
        </tr>
        <tr>
            <td>Alamat Wajib Pajak</td>
            <td>: {{ $data->Alamat_WP }}</td>
        </tr>
        <tr>
            <td>NOP</td>
            <td>: {{ $data->NOP }}</td>
        </tr>
        <tr>
            <td>Alamat Objek Pajak</td>
            <td>: {{ $data->Alamat_OP }}</td>
        </tr>
    </table>

  @php
//   dd($data->Tujuan);
$pilihan = [
    1 => 'Objek Pajak Baru',
    2 => 'Mutasi/ Balik Nama',
    3 => 'Pemecahan',
    4 => 'Penggabungan',
    5 => 'Pembatalan/ Penghapusan',
    6 => 'Perubahan Data',
    7 => 'Keberatan/ Pengurangan',
    8 => 'Penilaian Individu',
    9 => 'Verifikasi BPHTB',
    10 => 'Lainnya………………………'
];
@endphp

<table style="font-size: 12px; margin-top: 10px">
    <tr>
        <td style="vertical-align: top;">Tujuan<br>Penelitian/Pemeriksaan</td>
        <td style="vertical-align: top;">:</td>
        <td>
            <table style="font-size: 12px">
                @foreach ($pilihan as $kode => $label)
                    @if ($loop->iteration % 2 == 1)
                        <tr>
                    @endif
                    <td @if ($data->Tujuan == $label) style="font-weight:bold; background:yellow;" @endif>{{ $kode }}. {{ $label }}</td>
                    @if ($loop->iteration % 2 == 0)
                        </tr>
                    @endif
                    @if ($loop->last && $loop->iteration % 2 == 1)
                        <td></td></tr><!-- jika ganjil, tambahi 1 kolom -->
                    @endif
                @endforeach
            </table>
        </td>
    </tr>
</table>


        </td>
    </tr>
</table>



    <p>Adapun temuan hasil penelitian/pemeriksaan sebagai berikut:</p>

    <table style="width: 100%;" class="bordered">
        <tr>
            <th style="width: 5%;" class="bordered">No</th>
            <th class="bordered">Temuan</th>
        </tr>
        <tr>
            <td class="bordered">1</td>
            <td class="bordered">{{ $data->Hasil }}</td>
        </tr>
    </table>

    <p>Sehingga kesimpulan dan rekomendasi kami sebagai berikut:</p>

    <table style="width: 100%;" class="bordered">
        <tr>
            <th style="width: 5%;" class="bordered">No</th>
            <th class="bordered">Kesimpulan/Rekomendasi</th>
        </tr>
        <tr>
            <td class="bordered">1</td>
            <td class="bordered">{{ $data->Rekomendasi }}</td>
        </tr>
    </table>

    <br>


    <table width="100%" style="margin-top: 20px;">
        <tr>
            <td width="45%" valign="top">
                <strong>PETUGAS PENELITI</strong><br>
                @foreach ($data->jadwal->petugas as $i => $petugas)
                    {{ $i + 1 }}. {{ $petugas->name }}<br>
                    NIP. {{ $petugas->nip ?? '-' }}<br>
                @endforeach
                <br><br>
                Wajib Pajak/Kuasa/ Desa/Kelurahan<br><br>

                @if ($base64Ttd)
                    <img src="{{ $base64Ttd }}" alt="TTD_WP" width="100"><br>
                @else
                    <p>Tanda tangan belum tersedia</p>
                @endif

                <strong><u>{{ $data->Nama_WP }}</u></strong><br><br>

            </td>

            <td width="45%" valign="top" style="padding-left: 30px;">
                <strong>Diperiksa oleh :</strong><br>
                Kasubbid Pendataan dan Penilaian PBB & BPHTB<br>
                @if ($base64TtdKasi)
                    <img src="{{ $base64TtdKasi }}" style="width: 100px;"><br>
                @else
                    <p>Tanda tangan belum tersedia</p>
                @endif
                <strong><u> MUFIDAH HANUM, SH </u></strong><br>
                NIP. 19840229 200212 2 004<br><br>

                Mengetahui,<br>
                Kepala Bidang Pendataan dan Penetapan<br>
                @if ($base64TtdKabid)
                    <img src="{{ $base64TtdKabid }}" style="width: 100px;"><br>
                @else
                    <p>Tanda tangan belum tersedia</p>
                @endif
                <strong><u>MOHAMMAD MAHFUD, S.SOS</u></strong><br>
                NIP. 19720625 199303 1 007
            </td>
        </tr>
    </table>


</body>

</html>
