<?php 
$conn = mysqli_connect("localhost","root","","sim_ps");

if (mysqli_connect_errno()) {
	echo "Koneksi ke database tidak tersedia".mysqli_connect_errno();
}
date_default_timezone_set('Asia/Jakarta');
$namefile = date('d-M-Y-h-i-s');
$u_create = $_SESSION["nama"]; 
$action = "update";  
$action1 = "insert";
$action2 = "delete";
$set = mysqli_query($conn, "SET @action ='$action', @user = '$u_create', @action1 = '$action1',
@action2 ='$action2'");

function getRomawi($bln){
	switch ($bln){
			case 1: 
				return "I";
				break;
			case 2:
				return "II";
				break;
			case 3:
				return "III";
				break;
			case 4:
				return "IV";
				break;
			case 5:
				return "V";
				break;
			case 6:
				return "VI";
				break;
			case 7:
				return "VII";
				break;
			case 8:
				return "VIII";
				break;
			case 9:
				return "IX";
				break;
			case 10:
				return "X";
				break;
			case 11:
				return "XI";
				break;
			case 12:
				return "XII";
				break;
	  }
}

function getBulan($bln){
	switch ($bln){
			case 1: 
				return "Januari";
				break;
			case 2:
				return "Februari";
				break;
			case 3:
				return "Maret";
				break;
			case 4:
				return "April";
				break;
			case 5:
				return "Mei";
				break;
			case 6:
				return "Juni";
				break;
			case 7:
				return "Juli";
				break;
			case 8:
				return "Agustus";
				break;
			case 9:
				return "September";
				break;
			case 10:
				return "Oktober";
				break;
			case 11:
				return "November";
				break;
			case 12:
				return "Desember";
				break;
	  }
}

?>