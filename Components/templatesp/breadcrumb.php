<div class="breadcrumb">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <?php
                if($page == ""){
                    echo '<li class="breadcrumb-item"><a href="#">Dashboard</a></li>';
                }elseif($page == "tambah_user"){
                    echo '<li class="breadcrumb-item"><a href="#">Tambah User</a></li>';
                }
            ?>
        </ol>
    </nav>
</div>