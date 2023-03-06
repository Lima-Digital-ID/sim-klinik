<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Cetak Struk</title>
  <style type="text/css">
  *{
        /* font-family : "Dot Matrix"; */
        font-size : 15px;
        color: black;
    }
  /* @media print and (width: 58mm) and (height: 80mm) { */
        /* @page {
          margin: 3cm;
        } */
  /* } */
  /* @page {
      size: 58mm 80mm;
      margin: 10%;
  } */
  body{
    width: 58mm;
    min-height: 80mm;
  }
  /* @media print { 
    body{ 
      width: 58mm;
      height: 80mm
    }
  } */
  </style>
  <link rel="shortcut icon" href="{{ asset('public/assets/img/icon2.png') }}" />
</head>
<body>
<center>
  <div class="left">
      <div class="img">
          <center>
              <img src="<?php echo base_url()."assets/images/".getInfoRS('logo')?>" alt="logo" width="50px" style="border-radius:7px"/>
            </center>
      </div>
      <div class="address" style="margin-left:15px;text-align:center;margin-top:10px">
        <h2 style="font-family:times-new-roman;margin-top:0;margin-bottom:0px"><?= getInfoRS('nama_rumah_sakit') ?></h2>
        <p style="margin-top:5px;margin-bottom:0px"><?= getInfoRS('alamat') ?></p>
        <p style="margin-top:5px;margin-bottom:0px">Email : again.medical.center@gmail.com</p>
        <p style="margin-top:5px;margin-bottom:0px">Telp : 031-5952220 / WA : <?= getInfoRS('no_telpon') ?></p>
      </div>
    -------------------------------------------
    <?php echo $transaksi[0]->no_transaksi;?>
    <br>        
    -------------------------------------------
  </center>
  <table width="100%">
    <?php
      $total_transaksi = 0;
      $i = 1;
      foreach($periksa_d_obat as $data){
        $total_transaksi+=($data->harga*$data->jumlah);
    ?>
    <tr>
      <td width="47.5%">
        <b><?= $data->nama_barang ?></b>
        <br>
        <?= $data->jumlah." x ".$data->harga ?>
      </td>
      <td width="5%"></td>
      <td width="47.5%" align="right">
        <br>
        Rp.<?php echo number_format(($data->harga*$data->jumlah),2,',','.')?>
      </td>
    </tr>
    <?php } 
        // $diskon=$total_transaksi*(($getDiskon != null ? $getDiskon->diskon : 0) / 100);
        // $diskon = $subsidi;
    ?>
    <tr>
      <td colspan="3">------------------------------------------</td>
    </tr>
    <tr>
      <td width="47.5%">
        <b>Total</b>
      </td>
      <td width="5%"></td>
      <td width="47.5%" align="right">
        Rp. <?php echo number_format($total_transaksi,2,',','.');?>
      </td>
    </tr>    
    <!-- <tr>
      <td width="47.5%">
        <b>Diskon</b>
      </td>
      <td width="5%"></td>
      <td width="47.5%" align="right">
        Rp. <?php echo number_format($diskon,2,',','.');?>
      </td>
    </tr>     -->
    <!-- <tr>
      <td width="47.5%">
        <b>Grand Total</b>
      </td>
      <td width="5%"></td>
      <td width="47.5%" align="right">
        Rp. <?php echo number_format($total_transaksi-$diskon,2,',','.');?>
      </td>
    </tr>     -->
  </table>

</body>
<script>
 window.print();
</script>
</html>

