<?php
ob_start();
session_start();
include 'init.php'; 
?>

<div class="container">
    <?php
    if(isset($_GET['pageid']) && is_numeric($_GET['pageid'])) {
        $pageId = intval($_GET['pageid']);
        $stmt = $con->prepare('SELECT Name FROM categories WHERE ID = '. $pageId);
        $stmt->execute();
        $categoryName = $stmt->fetch(); 
        ?>

        <h1 class="text-center"><?php echo $categoryName['Name'] ?></h1>
        <div class="row gx-5">
            <?php 
            $items = getItems('Cat_ID' ,$pageId, 1);
            foreach ($items as $item) {
                echo '<div class="col-sm-6 col-md-4 col-lg-3">';
                echo '<div class="card item-box" style="width: 18rem;">';
                echo '<span class="price-tag">' . $item['Price'] . '</span>';
                echo '<img src="img.jpg" class="card-img-top img-thumbnail" alt="...">';
                echo '<div class="card-body">';
                echo '<h3 class="card-title">' . $item['Name'] . '</h3>';
                echo '<p class="card-text">' . $item['Description'] . '</p>';
                echo '<div class="date">' . $item['Add_Date'] . '</div>';
                echo '<a href="items.php?itemid=' . $item['Item_ID'] . '" class="btn btn-primary">Show Item</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    <?php } else {
        $errorMsg = '<div class="alert alert-danger mt-4" role="alert"><i class="fa-solid fa-circle-xmark"></i> You Don\'t Specify Page ID </div>';
        redirectHome($errorMsg);
    } ?>
</div>


<?php 
include $tplDir . 'footer.php'; 
ob_end_flush();
?>