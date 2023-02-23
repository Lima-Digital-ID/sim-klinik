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
<?php foreach ($periksa as $key => $value) {
    $diagnosa = $this->Tbl_periksa_diagnosa_model->get_by_no_periksa($value->no_periksa);
    $obat = $this->Periksa_model->get_d_obat_by_id($value->no_periksa, true);
    $berat_badan = $this->Periksa_model->get_d_fisik_by_id($value->no_periksa, 'Berat Badan');
    $tinggi_badan = $this->Periksa_model->get_d_fisik_by_id($value->no_periksa, 'Tinggi Badan');
    $tekanan_darah = $this->Periksa_model->get_d_fisik_by_id($value->no_periksa, 'Tekanan Darah');
    $suhu_tubuh = $this->Periksa_model->get_d_fisik_by_id($value->no_periksa, 'Suhu Tubuh');
?>
    <table>
        <tbody>
            <tr>
                <td><strong>Kunjungan I (<?= date('d-m-Y', strtotime($value->dtm_crt)) ?>)</strong></td>
                <td></td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td>Anamnesi</td>
                <td>:</td>
                <td colspan="3"><?= $value->anamnesi ?></td>
            </tr>
            <tr>
                <td>Cek Fisik</td>
                <td>:</td>
                <td colspan="3"><?= $value->cek_fisik ?></td>
            </tr>
            <tr>
                <td>Berat Badan</td>
                <td>:</td>
                <td><?= $berat_badan[$key]->nilai_periksa_fisik ?></td>
                <td>Tekanan Darah</td>
                <td>:</td>
                <td><?= $tekanan_darah[$key]->nilai_periksa_fisik ?></td>
            </tr>
            <tr>
                <td>Tinggi Badan</td>
                <td>:</td>
                <td><?= $tinggi_badan[$key]->nilai_periksa_fisik ?></td>
                <td>Suhu Tubuh</td>
                <td>:</td>
                <td><?= $suhu_tubuh[$key]->nilai_periksa_fisik ?></td>
            </tr>
            <tr>
                <td>Riwayat Alergi Obat</td>
                <td>:</td>
                <td colspan="3"><?= $pasien->alamat . " RT " . $pasien->rt . ' RW ' . $pasien->rw . ', ' . $pasien->kabupaten ?></td>
            </tr>
            <tr>
                <td>Diagnosa</td>
                <td>:</td>
                <td colspan="3"><?= $value->diagnosa ?></td>
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
                <td colspan="3"><?= $value->tindakan ?></td>
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
                <td colspan="3"><?= $value->note_dokter ?></td>
            </tr>
        </tbody>
    </table>
    <br>
<?php } ?>
<?php
if ($tipe == 'print') { ?>
    <script>
        window.print()
    </script>
<?php } ?>

</html>