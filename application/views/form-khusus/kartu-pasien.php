<style>
    body{
        font-family : 'arial';
    }
</style>
<center>
<?php 
function hitung_umur($tanggal_lahir){
	$birthDate = new DateTime($tanggal_lahir);
	$today = new DateTime("today");
	if ($birthDate > $today) { 
	    exit("0 tahun 0 bulan 0 hari");
	}
	$y = $today->diff($birthDate)->y;
	$m = $today->diff($birthDate)->m;
	$d = $today->diff($birthDate)->d;
	return $y." tahun ".$m." bulan ";
}
?>
<table border='1' width="100%" cellspacing='0' cellpadding='10'>
    <tr>
        <td>
            <center>
                <h2><u>KARTU PASIEN</u></h2>
            </center>
            <br>
            <table width="100%">
                <tr>
                    <td width="25%">Nama Pasien</td>
                    <td width="3%">:</td>
                    <td><?= $data->nama_lengkap ?></td>
                </tr>
                <tr>
                    <td width="25%">Umur / Jenis Kelamin</td>
                    <td width="3%">:</td>
                    <td><?= hitung_umur($data->tanggal_lahir) ?> / <?= $data->jenis_kelamin == 'L' ? "Laki Laki" : 'Perempuan' ?></td>
                </tr>
                <tr>
                    <td width="25%">TB / BB</td>
                    <td width="3%">:</td>
                    <td>...........................</td>
                </tr>
                <tr>
                    <td width="25%">Riwayat Alergi</td>
                    <td width="3%">:</td>
                    <td>...........................</td>
                </tr>
            </table>
            <br>
            <br>
            <table border='1' height="100%" width="100%" cellspacing='0' cellpadding='10'>
                <tr>
                    <th>VITAL SIGN</th>
                    <th>ANAMNESA</th>
                    <th>DIAGNOSA</th>
                </tr>
                <tr>
                    <td>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                    </td>
                    <td>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                    </td>
                    <td>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
