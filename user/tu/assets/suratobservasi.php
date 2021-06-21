<?php
session_start();
require "../../../koneksi.php";
if (!isset($_SESSION["login_tu"])) {
header("location:../../../index.php");
exit();
}
if(isset($_POST['submit'])){
if ($_POST["tujuan"]=="" OR $_POST["tujuan"]==NULL) {
echo "<script>
alert('Data Tipe Surat Harus Diisi')
windows.location.href('suratobservasi.php')
</script>";
// header("location:../suratobservasi.php");
}else{
    $i=0;
    $n=count( $_POST['nim'] );
    $no=1;
    $np = $_POST["nama_perusahaan"];
    $alamat = $_POST["alamat"];
    $tujuan = $_POST["tujuan"];
    if ($tujuan==0) {
        $kd = '2.b';
        $ket = 'Observasi Praktik Kerja Lapangan (PKL)';
    }elseif ($tujuan==1) {
        $kd = '1.b';
        $ket = 'Observasi Praktik Kerja Lapangan (PKL)';
    }elseif ($tujuan==2) {
        $kd = '2.b';
        $ket = 'Observasi Tugas Akhir / Skripsi';
    }elseif ($tujuan==3) {
        $kd = '1.b';
        $ket = 'Observasi Tugas Akhir / Skripsi';
    }
  // membaca kode / nilai tertinggi dari penomoran yang ada didatabase berdasarkan tanggal
$bulan = date('n');
$tahun = date('Y');
$romawi = getRomawi($bulan);
$bln = getBulan($bulan);
$tgl = date('d');
$k = "'";
// echo $bulan; die;
  $query = "SELECT MAX(nomor) as maxNo FROM surat WHERE month(tanggal)='$bulan'";
  $hasil = mysqli_query($conn, $query);
  $data  = mysqli_fetch_array($hasil);
  $no= $data['maxNo'];
  $noUrut= $no + 1;
  $kode =  sprintf("%03s", $noUrut);
  $nomorbaru = $kode;
// echo $nomorbaru; die;
  $insert = mysqli_query($conn, "INSERT INTO surat (jenis, nomor) VALUES ('$ket','$nomorbaru')");

require_once "../../../plugins/mpdf/autoload.php";
$mpdf = new \Mpdf\Mpdf(['format' => 'Legal']);



$data = '<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Surat Observasi</title>
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="" crossorigin="anonymous">
	</head>
	<style>
		hr {
			border:0;
			border-top: 10px #000000 double;
		}
		.univ {
			font-family: : "Monospace", Helvetica, sans-serif;
			color: #000000;
		}
		.fakultas {
			color: 	#000000;
        }
        .br {
            border:0;
        }
	</style>
	<body>
		<table border="0">
		<tr>
		<td><img src="../../../assets/logo.png" alt="logo-umc" width="100" height="100"></td>
		<td>
		<center>
			<font size="6" class="univ"><b>POLITEKNIK NEGERI JAKARTA</b></font><BR>
			<font size="5" class="fakultas">JURUSAN TEKNIK ELEKTRO</font><BR>
			<font size="2">Jl. Prof. DR. G.A. Siwabessy, Kukusan, Kecamatan Beji, Kota Depok, Jawa Barat 16424. Telp : Telepon (021) 7863534, 7864927, 7864926, 7270042, 7270035
Fax (021) 7270034, (021) 7270036 Hunting</font><BR>
			<font size="2">Laman: http://www.pnj.ac.id e-pos: elektro@pnj.ac.id </font><BR>
		</center>
		</td>
		</tr>
		<tr>
			<td colspan="2"><hr></td>
        </tr>
        </table>
        <table border="0">
        <tr>
            <td width="30px"><font size="3"></font></td>
            <td><font size="4">No</font><BR></td>
            <td width="1px"><font size="4">:</font><BR></td>
            <td><font size="4">'.$nomorbaru.'/'.$kd.'/PL3.9/DA/'.$romawi.'/'.$tahun.'</font><BR></td>
        </tr>
        <tr>
        <td width="30px"><font size="3"></font></td>
            <td colspan><font size="4">Lampiran</font><BR></td>
            <td colspan><font size="4">:</font><BR></td>
            <td colspan><font size="4">-</font><BR></td>
        </tr>
        <tr>
        <td width="30px"><font size="3"></font></td>
            <td colspan><font size="4">Perihal</font><BR></td>
            <td colspan><font size="4">:</font><BR></td>
            <td colspan><font size="4">Permohonan Izin '.$ket.'</font><BR></td>
        </tr>
        <tr>
        <td width="30px"><font size="3"></font></td>
        <td colspan><font size="4"><br><br>Kepada</font><BR></td>
        <td colspan><font size="4"><br><br>:</font><BR></td>
        <td colspan><font size="4"><br><br>Yth. Pimpinan '.$np.'</font><BR></td>
        </tr>
        <tr>
        <td width="30px"><font size="3"></font></td>
        <td colspan><font size="4"></font><BR></td>
        <td colspan><font size="4"></font><BR></td>
        <td colspan><font size="4">'.$alamat.'</font><BR></td>
        </tr>
        <tr>
        <td width="30px"><font size="3"></font></td>
        <td colspan><font size="4"><br><br></font><BR></td>
        <td colspan><font size="4"><br><br></font><BR></td>
        <td colspan><font size="4"><br><br>Di Tempat</font><BR></td>
        </tr>
        <tr>
        <td width="30px"><font size="3"></font></td>
        <td colspan><font size="4"><br></font><BR></td>
        <td colspan><font size="4"><br></font><BR></td>
        <td colspan><font size="4"><br>Sehubungan dengan pelaksanaan kurikulum dan salah satu syarat kelulusan mahasiswa Program Studi Broadband Multimedia, Jurusan Teknik Elektro -
        Politeknik Negeri Jakarta.</font><BR></td>
        </tr>
        <tr>
        <td width="30px"><font size="3"></font></td>
        <td colspan><font size="4"><br><br></font><BR></td>
        <td colspan><font size="4"><br><br></font><BR></td>
        <td colspan><font size="4"><br>Bersama ini kami ingin menyampaikan bahwa mahasiswa tersebut di bawah ini:</font><BR></td>
        </tr>
        </table>';
$data .= '<br>';
$data .= '
        <table border="1" width="83%" cellspacing="0" align="right">
        <thead align="center">
        <tr>
        <th>No</th>
        <th>Nama</th>
        <th>NIM</th>
        <th>Program Studi</th>
        </tr>
        </thead>
        <tbody>
        ';
        while ($i<$n) {
$data .=  ' <br>
            <tr>
            <td align="center"><br>'.$no++.'</td>
            <td width="230px">'.$_POST['nama'][$i].'</td>
            <td width="100px" align="center">'.$_POST['nim'][$i].'</td>
            <td width="200px" align="center">'.$_POST['prodi'][$i].'</td>
            '.$i++.'
            </tr>';
        }
$data .= '</tbody>
        </table>';

$data.='<br> <table border="0">
<tr>
    <td width="113px"><font size="3"></font></td>
    <td><font size="4">Bermaksud menghadap Bapak/Ibu dan apabila memungkinkan kiranya yang bersangkutan
    diberikan ijin melakkan observasi di instansi/perusahaan yang Bapak/Ibu pimpin untuk keperluan '.$ket.'.</font><BR></td>
</tr>
<tr>
    <td width="100px"><font size="3"></font></td>

    <td><font size="4"><br>Kami mengharapkan kesediaannya memberi informasi melalui email: elektro@pnj.ac.id dalam waktu satu minggu sejak surat ini diterima.<br><br>Demikian surat permohonan ini kami buat, atas perhatian serta kerjasamanya kami sampaikan terima kasih.</font><BR></td>
</tr>
<tr>
</tr>
</table>';

$data .='<br><br><table border="0">
<tr>
    <td width="120px"></td>
<td><font size="3">Depok, '.$tgl.' '.$bln.' '.$tahun.'</font></td>
</tr>
<tr>
<td></td>
<td><font size="3">a.n Direktur Politeknik Negeri Jakarta
<br>Pembantu Direktur Bidang Akademik
<br>u.b. Ketua Jurusan Teknik Elektro,</font><br><br><br><br><br><br><br><br></td>
</tr>
<tr>
<td></td>
<td><font size="3"><b>Ir. Sri Danaryani, MT</b></font></td>
</tr>
<tr>
<td></td>
<td><font size="3">NIP 196305031991032001</font></td>
			</tr>
		</table>
	</body>
</html>';

$mpdf->WriteHTML($data);
$mpdf->Output('SuratObservasi', 'D');
    }
}

 ?>
