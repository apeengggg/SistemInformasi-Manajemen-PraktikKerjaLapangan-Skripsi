<?php 
    $back_dir    ="../../../assets/uploads/template_mahasiswa.xls";
     
        if (file_exists($back_dir)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($back_dir));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: private');
            header('Pragma: private');
            header('Content-Length: ' . filesize($back_dir));
            ob_clean();
            flush();
            readfile($back_dir);
            exit();
        } 
        else {
            echo "<script>
    alert('File Tidak Ditemukan')
    windows.location.href('index.php')
    </script>";
        }
    
?><a href="../index.php">Jika Tidak Kembali Klik Disini</a>