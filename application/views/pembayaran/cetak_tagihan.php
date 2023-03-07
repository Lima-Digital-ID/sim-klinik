<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Kwitansi Pembayaran</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">-->

  <!-- Load paper.css for happy printing -->
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">-->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/paper-css/paper.css">

  <style>
    body {
      font-family: "Arial";
    }

    .header,
    .header .left {
      display: flex;
    }

    .header .left {
      width: 55%;
    }

    .header .right {
      width: 45%;
      padding-left: 40px;
      padding-top: 30px;
    }
  </style>

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <!--<style>
  @page { size: A5 landscape }
  </style>-->
  <style>
    @page {
      size: A4
    }
  </style>
  <style type="text/css">
    .tg {
      border-collapse: collapse;
      border-spacing: 0;
    }

    .tg td {
      border-color: black;
      border-style: solid;
      border-width: 1px;
      font-family: Arial, sans-serif;
      font-size: 14px;
      overflow: hidden;
      padding: 10px 5px;
      word-break: normal;
    }

    .tg th {
      border-color: black;
      border-style: solid;
      border-width: 1px;
      font-family: Arial, sans-serif;
      font-size: 14px;
      font-weight: normal;
      overflow: hidden;
      padding: 10px 5px;
      word-break: normal;
    }

    .tg .tg-0lax {
      text-align: left;
      vertical-align: top
    }
  </style>

</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A4">
  <!-- <body class="A5 landscape" onload="window.print()"> -->
  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">

    <div class="header">
      <div class="left" style="width: 15% !important; margin-top:20px">
        <div class="img">
          <img src="<?php echo base_url() . "assets/images/" . getInfoRS('logo') ?>" alt="logo" width="100" style="border-radius:20px" />
        </div>
      </div>
      <div class="right" style="width: 70% !important; padding-left: 0px !important;">
        <div class="address" style="margin-left:15px">
          <center>
            <h2 style="font-family:times-new-roman;margin-top:0;margin-bottom:0px"><?= getInfoRS('nama_rumah_sakit') ?></h2>
            <p style="margin-top:5px;margin-bottom:0px"><?= getInfoRS('alamat') ?></p>
            <p style="margin-top:5px;margin-bottom:0px">Email :again.medical.center@gmail.com</p>
            <p style="margin-top:5px;margin-bottom:0px">Telp : 031-5952220 / WA : <?= getInfoRS('no_telpon') ?></p>
          </center>
        </div>
      </div>
    </div>
    <hr>
    <h3 style="text-align: center;margin-bottom:0px"><span style="font-size:24px;">KWITANSI</span></h3>

    <center style="margin-top: 20px;">
      <table width="100%">
        <tr>
          <td width="40%">
            <table>
              <tr>
                <td>Nama &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
                <td>:</td>
                <td><?= $data->atas_nama ?></td>
              </tr>
              <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?= $pasien->alamat ?></td>
              </tr>
              <tr>
                <td>Dokter</td>
                <td>:</td>
                <td><?= $dokter != null ? $dokter->nama_dokter : '-' ?></td>
              </tr>
              <tr>
                <td>Jenis Perawatan</td>
                <td>:</td>
                <td><?= $tujuan->name ?></td>
              </tr>
            </table>
          </td>
          <td width="60%">
            <table>
              <tr>
                <td>No Tagihan &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
                <td>:</td>
                <td><?= $data->no_transaksi ?></td>
              </tr>
              <tr>
                <td>Tanggal Transaksi</td>
                <td>:</td>
                <td><?= $tgl ?></td>
              </tr>
              <tr>
                <td>Metode Bayar</td>
                <td>:</td>
                <td><?= $data->cara_pembayaran == 1 ? 'Tunai' : 'Transfer' ?></td>
              </tr>
              <tr>
                <td>Diagnosa ICD 10</td>
                <td>:</td>
                <td>
                  <?php foreach ($diagnosa_icd10 as $key => $value) {
                    // echo ($key+1).'-'.count($diagnosa_icd10);
                    echo $key + 1 != count($diagnosa_icd10) ? $value->diagnosa . ', ' : $value->diagnosa;
                  } ?>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </center>
    <table class="tg" width="100%">
      <thead>
        <tr>
          <th class="tg-0lax">No</th>
          <th class="tg-0lax">Deskripsi</th>
          <th class="tg-0lax">Jumlah</th>
          <th class="tg-0lax">Nilai</th>
          <th class="tg-0lax"></th>
          <th class="tg-0lax">Total</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $subtotal = 0;
        $i = 1;
        $no = 1;
        $biayaAdmin = 0;
        $diskon = 0;
        foreach ($transaksi_d as $loop) {
          if (strpos($loop->deskripsi, 'Pembayaran Biaya Medis') === false) {
            if ($loop->amount_transaksi > 0 && $loop->dc == 'd' && $loop->deskripsi != 'Biaya Administrasi') {
        ?>
              <tr>
                <td class="tg-0lax">
                  <?= $no++ ?>
                </td>
                <td class="tg-0lax">
                  <?php echo $loop->deskripsi; ?>
                  <?php  
                    if($loop->deskripsi == 'Biaya Tindakan'){
                    foreach ($tindakan as $t) { ?>
                    <br>
                    - <?= $t->tindakan ?>
                  <?php } }else if($loop->deskripsi == 'Total Obat-obatan'){
                    foreach ($obat as $o) { ?>
                      <br>
                      - <?= $o->nama_barang ?>
                    <?php }
                  } ?>
                </td>
                <td class="tg-0lax">
                <?php  
                    if($loop->deskripsi == 'Biaya Tindakan'){
                      foreach ($tindakan as $t) { ?>
                      <br>
                      <?= '1' ?>
                      <?php } 
                    }else if($loop->deskripsi == 'Total Obat-obatan'){
                      foreach ($obat as $o) { ?>
                        <br>
                        <?= $o->jumlah ?>
                      <?php }
                    } else { echo '1'; }?>
                </td>
                <td class="tg-0lax">
                  <?php
                  if($loop->deskripsi == 'Biaya Tindakan'){
                      foreach ($tindakan as $t) { ?>
                      <br>
                      Rp. <?= number_format($t->biaya, 2, ',', '.') ?>
                      <?php } 
                    }else if($loop->deskripsi == 'Total Obat-obatan'){
                      foreach ($obat as $o) { ?>
                        <br>
                        Rp. <?= number_format($o->jumlah * $o->harga, 2, ',', '.') ?>
                      <?php }
                    } else { ?>
                      Rp.<?php echo $loop->dc == 'd' ? number_format($loop->amount_transaksi, 2, ',', '.') : ($loop->amount_transaksi != 0 ? '-' . number_format($loop->amount_transaksi, 2, ',', '.') : number_format(0, 2, ',', '.')); ?> 
                    <?php }?>
                </td>
                <td class="tg-0lax"></td>
                <td class="tg-0lax" style="vertical-align: bottom;">
                  Rp.<?php echo $loop->dc == 'd' ? number_format($loop->amount_transaksi, 2, ',', '.') : ($loop->amount_transaksi != 0 ? '-' . number_format($loop->amount_transaksi, 2, ',', '.') : number_format(0, 2, ',', '.')); ?>
                </td>
              </tr>
        <?php
              $i++;
            }
            if ($loop->amount_transaksi > 0 && $loop->dc == 'd' && $loop->deskripsi != 'Biaya Administrasi')
              $subtotal += $loop->amount_transaksi;
            if ($loop->deskripsi == 'Biaya Administrasi')
              $biayaAdmin += $loop->amount_transaksi;
            if ($loop->amount_transaksi > 0 && $loop->dc == 'c')
              $diskon += $loop->amount_transaksi;
            // else
            //   $subtotal -= $loop->amount_transaksi;
          }
        }
        ?>
        <tr>
          <td colspan="2">
            <b><i>Terbilang: <?= ucwords(terbilang($subtotal + $biayaAdmin - $diskon)) ?> Rupiah</i></b>
          </td>
          <td class="tg-0lax" colspan="4">
            Subtotal : <span><?= number_format($subtotal, 2, ',', '.') ?></span>
            <br>
            Admin Fee : <?= $loop->deskripsi == 'Biaya Administrasi' ? number_format($loop->amount_transaksi, 2, ',', '.') : number_format(0, 2, ',', '.'); ?>
            <br>
            Subsidi : - <?= number_format($diskon, 2, ',', '.') ?>
            <br>
            Grand Total : <?= number_format($subtotal + $biayaAdmin - $diskon, 2, ',', '.') ?>
          </td>
        </tr>
      </tbody>
    </table>
    <table width="100%">
      <tr>
        <td>
          Surabaya, <?= date("d F y") ?>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <b><u><?= $data->atas_nama ?></u></b>
          <br>
          Customer
        </td>
        <td>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <b><u><?= $this->session->userdata('full_name'); ?></u></b>
          <br>
          Kasir
        </td>
        <td width="30%">
          <center>
            <img src="<?= base_url() . "assets/images/qr_code/" . $data->qr_code_struk ?>" width="150px" alt="" srcset="">
            <br>
            <b>QR TAGIHAN ANDA</b>
          </center>
        </td>
      </tr>
    </table>
  </section>

</body>

</html>