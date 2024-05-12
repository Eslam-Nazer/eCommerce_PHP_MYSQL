<?php 
ob_start();
session_start();
$pageTitle = "item";
include 'init.php';
$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
$stmt = $con->prepare('SELECT items.*, categories.Name AS NameOfCat, users.Username FROM items 
INNER JOIN users ON users.UserID = items.Member_ID 
INNER JOIN categories ON categories.ID = items.Cat_ID WHERE Item_ID = :itemid');
$stmt->execute(array(
    'itemid' => $itemid
)); 
$count = $stmt->rowCount();
if ($count > 0){
$item = $stmt->fetch();
?>
<h1 class="text-center"><?php echo $item['Name'] ?></h1>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <img src="img.jpg" class="img-thumbnail" alt="...">
        </div>
        <div class="col-md-9 item-info">
            <h2><?php echo $item['Name'] ?></h2>
            <p><?php echo $item['Description'] ?></p>
            <ul class="list-unstyled">
                <li><i class="fa-solid fa-calendar fa-fw"></i><span>Added Date</span> : <?php echo $item['Add_Date'] ?></li>
                <li><i class="fa-solid fa-money-check fa-fw"></i><span>Price</span> : <?php echo $item['Price'] ?></li>
                <li><i class="fa-solid fa-globe fa-fw"></i><span>Made in</span> : <?php echo $item['Country_Made'] ?></li>
                <li><i class="fa-solid fa-layer-group fa-fw"></i><span>Category</span> : <a href="categories.php?pageid=<?php echo $item['Cat_ID'] ?>&pagename=<?php echo $item['NameOfCat'] ?>"><?php echo $item['NameOfCat'] ?></a></li>
                <li><i class="fa-solid fa-user-check fa-fw"></i><span>Added by</span> : <?php echo $item['Username'] ?></li>
            </ul>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-md-3">
            user image
        </div>
        <div class="col-md-9">
            user comment
        </div>
    </div>
</div>

<?php 
} else {
    echo '<div class="container">';
    $errorMsg = '<div class="alert alert-danger" role="alert"><i class="fa-solid fa-circle-xmark"></i> There is no such ID </div>';
    redirectHome($errorMsg);
    echo '</div>';
}
include $tplDir . 'footer.php';
ob_end_flush();
?>