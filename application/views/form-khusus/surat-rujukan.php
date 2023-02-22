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
<table border='1' width="90%" cellspacing='0' cellpadding='10'>
    <tr>
        <td>
            <center>
                <h2><u>SURAT RUJUKAN</u></h2>
            </center>
            <table width="100%">
                <tr>
                    <td width="70%"></td>
                    <td>
                    KLINIK
                    <br>
                    Pratama Agian
                    <br>
                    Medical Center
                    </td>
                </tr>
            </table>
            <br>
            <p>Mohon pemeriksaan dan pengobatan lebih lanjut terhadap penderita</p>
            <br>
            <table width="100%">
                <tr>
                    <td width="25%">Nama Pasien</td>
                    <td width="3%">:</td>
                    <td><?= $data->nama_lengkap ?></td>
                </tr>
                <tr>
                    <td width="25%">Jenis Kelamin</td>
                    <td width="3%">:</td>
                    <td><?= $data->jenis_kelamin == 'L' ? "Laki Laki" : 'Perempuan' ?></td>
                </tr>
                <tr>
                    <td width="25%">Umur</td>
                    <td width="3%">:</td>
                    <td><?= hitung_umur($data->tanggal_lahir) ?></td>
                </tr>
                <tr>
                    <td width="25%">No. Telpon</td>
                    <td width="3%">:</td>
                    <td><?= $data->nomer_telepon ?></td>
                </tr>
                <tr>
                    <td width="25%">Alamat Rumah</td>
                    <td width="3%">:</td>
                    <td><?= $data->alamat ?></td>
                </tr>
                <tr>
                    <td width="25%">Anamnese Keluhan</td>
                    <td width="3%">:</td>
                    <td>...........................</td>
                </tr>
                <tr>
                    <td width="25%">Diagnosa sementara</td>
                    <td width="3%">:</td>
                    <td>...........................</td>
                </tr>
                <tr>
                    <td width="25%">Kasus</td>
                    <td width="3%">:</td>
                    <td>...........................</td>
                </tr>
                <tr>
                    <td width="25%">Terapi/Obat yang telah diberikan</td>
                    <td width="3%">:</td>
                    <td>...........................</td>
                </tr>
            </table>
            <br>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Demikian surat rujukan ini kami kirim, kami mohon balasan atas surat rujukan ini. Atas
perhatian Bapak/Ibu kami ucapkan terima kasih.</p>
            <br>
            <table width="100%">
                <tr>
                    <td width="70%"></td>
                    <td align="center">
                        Hormat Kami
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        (...........................)
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</center>