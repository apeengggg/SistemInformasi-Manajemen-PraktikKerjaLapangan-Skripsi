<?php
            $a = mysqli_query($conn, "SELECT * FROM judul WHERE nim='$nim' AND status_judul='Disetujui'");
            if (mysqli_num_rows($a)>0) {
            ?>

<?php }else{?>
            <div class="alert alert-danger" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                      </button>
                      <b>Anda Belum Memiliki Judul Yang Disetujui Atau Anda Belum Mempunyai Judul, Silahkan Ajukan Judul Terlebih Dahulu</b>
                    </div>
            <?php }?>