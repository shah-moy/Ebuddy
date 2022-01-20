<?php 
$title = "ebuddy";
$sub_title = "ebuddy";
if( isset($_GET['id'])){
    $cat_qry = $conn->query("SELECT sid FROM products where md5(id) = '{$_GET['id']}'");
    $shop = $conn->query("SELECT * FROM shop where sid = '{$cat_qry->fetch_assoc()['sid']}'");
    if($shop->num_rows > 0){
        $title = $shop->fetch_assoc()['sname'];
    }
   
   
}
if( isset($_GET['id'])){
    $cat_qry = $conn->query("SELECT sid FROM products where md5(id) = '{$_GET['id']}'");
    $shop = $conn->query("SELECT * FROM shop where sid = '{$cat_qry->fetch_assoc()['sid']}'");
    if($shop->num_rows > 0){
        $sub_title = $shop->fetch_assoc()['motto'];
    }
   
    
}



?>
<!-- Header-->
<header class="bg-dark py-5" id="main-header" >
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder"><?php echo $title ?></h1>
            <p class="lead fw-normal text-white-50 mb-0"><?php echo $sub_title ?></p>
        </div>
    </div>
</header>
<style>

#shop-header{
        position:relative;
        background: rgb(0,0,0)!important;
        background: radial-gradient(circle, rgba(0,0,0,0.48503151260504207) 22%, rgba(0,0,0,0.39539565826330536) 49%, rgba(0,212,255,0) 100%)!important;
    }
    #shop-header:before{
        content:"";
        position:absolute;
        top:0;
        left:0;
        width:100%;
        height:100%;
      
        background-repeat: no-repeat;
        background-size: cover;
        filter: drop-shadow(0px 7px 6px black);
        z-index:-1;
    }

</style>

<!-- Section-->
<section class="py-5">
    <div class="container-fluid px-4 px-lg-5 mt-5">
    <?php 
	
	
	
                if(isset($_GET['search'])){
                    echo "<h4 class='text-center'><b>Search Result for '".$_GET['search']."'</b></h4>";
                }
            ?>
        
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
           
            <?php 
			
			
		        $shopData = "";
                $whereData = "";
               
               if(isset($_GET['id']))
               $shop_qry = $conn->query("SELECT sid FROM products where md5(id) = '{$_GET['id']}'");
              

                    //$whereData = " and md5(sid) = '{$shop_qry->fetch_assoc()['sid']}' ";
					
					
                $products = $conn->query("SELECT * FROM `products` where status=1 and  sid = '{$shop_qry->fetch_assoc()['sid']}' order by rand() ");
                while($row = $products->fetch_assoc()):
                    $upload_path = base_app.'/uploads/product_'.$row['id'];
                    $img = "";
                    if(is_dir($upload_path)){
                        $fileO = scandir($upload_path);
                        if(isset($fileO[2]))
                            $img = "uploads/product_".$row['id']."/".$fileO[2];
                        // var_dump($fileO);
                    }
					
                    $inventory = $conn->query("SELECT * FROM inventory where product_id = ".$row['id']);
                    $inv = array();
                    while($ir = $inventory->fetch_assoc()){
                        $inv[$ir['size']] = number_format($ir['price']);
                    }
            ?>
            <div class="col mb-5">
                <div class="card h-100 product-item">
                    <!-- Product image-->
                    <img class="card-img-top w-100" src="<?php echo validate_image($img) ?>" loading="lazy" alt="..." />
                    <!-- Product details-->
                    <div class="card-body p-4">
                        <div class="text-center">
                            <!-- Product name-->
                            <h5 class="fw-bolder"><?php echo $row['product_name'] ?></h5>
                            <!-- Product price-->
                            <?php foreach($inv as $k=> $v): ?>
                                <span><b><?php echo $k ?>: </b><?php echo $v ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- Product actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
					
                        <div class="text-center">
                            <a class="btn btn-flat btn-primary "   href=".?p=view_product&id=<?php echo md5($row['id']) ?>">View</a>
                        </div>
                        
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
            <?php 
                if($products->num_rows <= 0){
                    echo "<h4 class='text-center'><b>No Product Listed.</b></h4>";
                }
            ?>
        </div>
    </div>
</section>