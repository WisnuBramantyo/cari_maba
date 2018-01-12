<!doctype html>
<html>
    <head>
        <title>Paginasi</title>
        <link rel="stylesheet" href="bootstrap.min.css"/>
    </head>
    <body>
        <?php 
        //includekan fungsi paginasi  
        include 'pagination1.php';
        //koneksi ke database
        $koneksi = mysqli_connect("localhost", "root", "", "paginasi_pencarian"); // sesuaikan username dan password mysql anda
//===================
        if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
        }
        // $db = mysqli_select_db(mysqli $link, string $paginasi_pencarian);
//=================== FITUR SEARCHING
        //mengatur variabel reload dan sql
        //var_dump($_REQUEST);
        //var_export($_REQUEST['']);
       // is_array(($_REQUEST) && $_REQUEST == 'attach');

        $index= array_key_exists('keyword', $_REQUEST) ? $_REQUEST['keyword'] : '';

        // if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){

        if ($_REQUEST = !empty($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '') {
        
        //jika ada kata kunci pencarian (artinya form pencarian disubmit dan tidak kosong)
        //pakai ini

        $keyword = $_REQUEST['keyword'];
        $reload = "index.php?pagination=true&keyword=$keyword";
        $sql =  "SELECT * FROM provinsi WHERE provinsi LIKE '%$keyword%' ORDER BY provinsi";
            
        $result = mysqli_query($koneksi, $sql);

        } 
        else
        {
        //jika tidak ada pencarian pakai ini
            $reload = "index.php?pagination=true";
            $sql =  "SELECT * FROM provinsi ORDER BY provinsi";
            $result = mysqli_query($koneksi, $sql);
        }
//===================      
        //pagination config start
        $rpp = 10; // jumlah record per halaman
        //$reload = "index.php?pagination=true";
        $page = isset($_GET["page"]) ? (intval($_GET["page"])) : 1;
        //--
        ?>
        <?php if ($res = mysqli_query($koneksi, $sql)) ?>
        <?php
            $rowcount = mysqli_num_rows($res);
            
             //mysqli_free_result($result);
//====================      

//====================      
        $tcount = mysqli_num_rows($result);    
        $tpages = ($tcount) ? ceil($tcount/$rpp) : 1; // total pages, last page number
        $count = 0;
        $i = ($page-1)*$rpp;
        $no_urut = ($page-1)*$rpp;
        //pagination config end  
        
        ?>
         <div class="container" style="margin-top: 50px">
        <div class="row">
                <div class="col-lg-8">

        <!--muncul jika ada pencarian (tombol reset pencarian)-->
                    <?php
                    //if($_REQUEST['keyword']<>"")
                    if (is_array($_REQUEST) && $_REQUEST == 'attach') {
                        # code...
                    ?>
                        <a class="btn btn-default btn-outline" href="index.php"> Reset Pencarian</a>
                    <?php
                }
                ?>
                </div>
                <div class="col-lg-4 text-right">
                    <form method="post" action="index.php">
                        <div class="form-group input-group">
                            <input type="text" name="keyword" class="form-control" placeholder="Search..." value="<?php 
                            if (is_array(($_REQUEST) && $_REQUEST == 'attach'))
                                {
                            echo $_REQUEST['keyword']; }?>"
                            >
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">Cari
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
            
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Provinsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while(($count<$rpp) && ($i<$tcount)) {
                        mysqli_data_seek($result,$i);
                        $data = mysqli_fetch_array($result);

                    ?>
                    <tr>
                        <td width="80px">
                            <?php echo ++$no_urut;?> 
                        </td>

                        <td>
                            <?php echo $data ['provinsi']; ?> 
                        </td>
                        <!-- <td width="120px" class="text-center">
                            <a href="#"> Edit</a> |
                            <a href="#">Delete</a>
                        </td> -->
                    </tr>
                    <?php
                        $i++; 
                        $count++;
                    }

                    ?>
                </tbody>
            </table>
            <div><?php echo paginate_one($reload, $page, $tpages); ?></div>

        </div>
    </body>
</html>