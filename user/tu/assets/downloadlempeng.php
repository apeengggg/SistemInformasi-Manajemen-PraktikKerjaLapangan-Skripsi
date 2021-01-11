<?php 
    if (isset($_GET['filename'])) {
    $filename    = $_GET['filename'];

    $back_dir    ="../../../assets/skripsi_lempeng/";
    $file = $back_dir.$_GET['filename'];
     
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: private');
            header('Pragma: private');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            
            exit;
        } 
        else {
            echo "<script>
    alert('File Tidak Ditemukan')
    windows.location.href('index.php')
    </script>";
        }
    }
?><a href="../index.php">Jika Tidak Kembali Klik Disini</a>