<?php 
	// created by Anis Hidayat
	include '../include/config.php';
	date_default_timezone_set('Asia/jakarta');

	$today = date('ymd');
	$kode  = $_POST['txtNama'];
	$sub_kalimat = substr($kode, 0,2);
	$upper = strtoupper($sub_kalimat);

	$query   =mysqli_query($conn, "SELECT max(id_barang) as maxKode FROM t_barang");
	$data    = mysqli_fetch_array($query);
	$noOrder = $data['maxKode'];
	$noUrut  = (int) substr($noOrder, 9, 3);
	$noUrut++;
	$tahun = substr($today, 0, 4);
	$bulan = substr($today, 5, 2);
	$id_barang = $upper .$tahun .$bulan . sprintf("%03s", $noUrut);

	$id_principle = $_POST['txtIdPrinciple'];
	$nama_barang  = $_POST['txtNama'];
	$nama_grup    = $_POST['txtGrup'];
	$satuan_kecil = $_POST['txtSatuanKecil'];
	$satuan_besar = $_POST['txtSatuanBesar'];

	$cek = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM t_barang WHERE nama_barang = '$nama_barang' AND satuan_kecil = '$satuan_kecil' AND satuan_besar = '$satuan_besar'"));
    $cek1 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM t_barang WHERE id_principle = '$id_principle'"));
    
    if ($cek > 0) {
		echo "<script>alert('Maaf... Data sudah ada');window.location = '../pages/form-barang1.php'</script>";
	}elseif ($cek1 > 0) {
		echo "<script>alert('Id Principle sudah ada !');window.location = '../pages/form-barang1.php'</script>";
	}else{
		$query = mysqli_query($conn, "INSERT INTO t_barang (id_barang, id_principle, nama_barang, nama_grup, satuan_kecil, satuan_besar, scan) VALUES ('$id_barang', '$id_principle', '$nama_barang', '$nama_grup', '$satuan_kecil', '$satuan_besar', 'Principle id')") or die (mysqli_error($conn));
		if ($conn->affected_rows > 0){
			echo "<script>alert('Data berhasil disimpan');window.location = '../pages/barang.php'</script>";
		}else{
			echo "<script>alert('Data gagal disimpan');window.location = '../pages/form-barang1.php'</script>";
		}
	}
	// else{
	// 	echo "<script>alert('Nama grup tidak ada !');window.location = '../pages/form-barang1.php'</script>";	
	// }

?>