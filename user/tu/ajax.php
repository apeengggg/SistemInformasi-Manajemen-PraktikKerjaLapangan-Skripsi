<?php
if(isset($_POST['submit'])){
   $i=0;
   $n=count( $_POST['nim'] );
   while($i<$n){
      echo $_POST['nim'][$i] . " dan " . $_POST['nama'][$i] . " dan " . $_POST['prodi'][$i] . "<br />"; 
   $i++;
   }
}



// $koneksi = mysqli_connect("localhost", "root", "", "sim_ps");


// $nim = $_GET['nim'];

// $query = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE nim='$nim'");
// $mahasiswa = mysqli_fetch_array($query);
// $data = array(
//             'nama'      =>  $mahasiswa['nama'],
//             'prodi'      =>  $mahasiswa['prodi'],);

// echo json_encode($data);
?>