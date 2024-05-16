<?php
ob_start();
session_start();
include 'init.php'; ?>


<div class="container">
    <h1 class="text-center">Show items</h1>
        <div class="row gx-5">
            <?php 
            $items = getItems('Cat_ID' ,$_GET['pageid'], 1);
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
</div>


<?php 
include $tplDir . 'footer.php'; 
ob_end_flush();
?>