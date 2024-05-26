<?php
ob_start();
session_start();
$pageTitle = 'Home';
include 'init.php';
?>

<div class="container">
    <div class="row">
        <?php 
        $stmt = $con->prepare('SELECT * FROM items ORDER BY Item_ID DESC');
        $stmt->execute();
        $items = $stmt->fetchAll();
        foreach($items as $item){
            if ($item['Status'] == 1) {?>
                <div class="col-sm-6 col-md-3 mt-4">
                    <div class="item-box card">
                        <span class="price-tag"><?php echo $item['Price']; ?></span>
                        <img src="img.jpg" class="card-img-top img-thumbnail" alt="Iamge here">
                        <div class="card-body">
                            <h3 class="card-title"><?php echo $item['Name']; ?></h3>
                            <div class="caption">
                                <p class="card-text"><?php echo $item['Description']; ?></p>
                            </div>
                            <div class="date"><?php echo $item['Add_Date']; ?></div>
                            <a href="items.php?itemid= <?php echo $item['Item_ID']; ?>" class="btn btn-primary">Show Item</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
</div>

<?php
include $tplDir . 'footer.php';
ob_end_flush();
?>