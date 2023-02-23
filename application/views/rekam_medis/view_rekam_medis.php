<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIM <?php echo getInfoRS('nama_rumah_sakit') ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<center><strong>Data Pasien</strong></center>
<br>
<br>
<br>
<table>
    <tbody>
        <tr>
            <td>Nama Pasien</td>
            <td>:</td>
            <td><?= $pasien->nama_lengkap ?></td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td><?= $pasien->nik ?></td>
        </tr>
        <tr>
            <td>TTL</td>
            <td>:</td>
            <td><?= $pasien->tanggal_lahir ?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td><?= $pasien->alamat . " RT " . $pasien->rt . ' RW ' . $pasien->rw . ', ' . $pasien->kabupaten ?></td>
        </tr>
    </tbody>
</table>
<br>
<br>
<br>
<center><strong>Data Rekam Medis</strong></center>
<br>
<br>
<table>
    <tbody>
        <tr>
            <td><strong>Kunjungan I (<?= date('d-m-Y', strtotime($periksa->dtm_crt)) ?>)</strong></td>
            <td></td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td>Anamnesi</td>
            <td>:</td>
            <td colspan="3"><?= $periksa->anamnesi ?></td>
        </tr>
        <tr>
            <td>Cek Fisik</td>
            <td>:</td>
            <td colspan="3"><?= $periksa->cek_fisik ?></td>
        </tr>
        <tr>
            <td>Berat Badan</td>
            <td>:</td>
            <td><?= $berat_badan[0]->nilai_periksa_fisik ?></td>
            <td>Tekanan Darah</td>
            <td>:</td>
            <td><?= $tekanan_darah[0]->nilai_periksa_fisik ?></td>
        </tr>
        <tr>
            <td>Tinggi Badan</td>
            <td>:</td>
            <td><?= $tinggi_badan[0]->nilai_periksa_fisik ?></td>
            <td>Suhu Tubuh</td>
            <td>:</td>
            <td><?= $suhu_tubuh[0]->nilai_periksa_fisik ?></td>
        </tr>
        <tr>
            <td>Riwayat Alergi Obat</td>
            <td>:</td>
            <td colspan="3"><?= $pasien->alamat . " RT " . $pasien->rt . ' RW ' . $pasien->rw . ', ' . $pasien->kabupaten ?></td>
        </tr>
        <tr>
            <td>Diagnosa</td>
            <td>:</td>
            <td colspan="3"><?= $periksa->diagnosa ?></td>
        </tr>
        <tr>
            <td>Diagnosa ICD 10</td>
            <td>:</td>
            <td colspan="3">
                <?php
                $count = count($diagnosa->result());
                foreach ($diagnosa->result() as $key => $value) {
                    echo $count == $key + 1 ? $value->diagnosa : $value->diagnosa . ', ';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>Tindakan</td>
            <td>:</td>
            <td colspan="3"><?= $periksa->tindakan ?></td>
        </tr>
        <tr>
            <td>Obat dan Alkes</td>
            <td>:</td>
            <td colspan="3">
                <?php
                $countObat = count($obat->result());
                foreach ($obat->result() as $keyObat => $valueObat) {
                    echo $countObat == $keyObat + 1 ? $valueObat->nama_barang : $valueObat->nama_barang . ', ';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>Catatan dari dokter</td>
            <td>:</td>
            <td colspan="3"><?= $periksa->note_dokter ?></td>
        </tr>
    </tbody>
</table>
<?php
if ($tipe == 'print') { ?>
    <script>
        window.print()
    </script>
<?php } ?>

</html>