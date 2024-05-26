<?php 
ob_start();
session_start();
$pageTitle = "item";
include 'init.php';
$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
$stmt = $con->prepare('SELECT items.*, categories.Name AS NameOfCat, users.Username FROM items 
INNER JOIN users ON users.UserID = items.Member_ID 
INNER JOIN categories ON categories.ID = items.Cat_ID WHERE Item_ID = :itemid AND Approve = 1');
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
                <li class="item-tag"><i class="fa-solid fa-tag fa-fw"></i><span>Tags</span> :
                <?php 
                if (!empty($item['tags'])){
                    $alltags = explode(' ', $item['tags']);
                    foreach ($alltags as $tag) {
                        $lowerTags = str_replace( ' ', '' ,(strtolower($tag)));
                        echo '<a class="tag-btn" href="tags.php?name=' . $lowerTags . '">' . $tag . '</a>';
                    } 
                }?>
                </li>
            </ul>
        </div>
    </div>
    <hr />
    <!-- Start Add Comment -->
    <?php if (isset($_SESSION['user'])) { ?>
    <div class="row">
        <div class="col-md-3 offset-md-3">
            <div class="add-comment">
                <h3>Add Comment</h3>
                <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['Item_ID'] ?>" method="POST">
                    <textarea name="comment" required></textarea>
                    <input class="btn btn-primary btn-sm" type="submit" value="Add comment">
                </form>
                <?php 
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $comment    = filteringInput($_POST['comment'], 'STRING');
                    $itemid     = filter_var($item['Item_ID'], FILTER_SANITIZE_NUMBER_INT);
                    if (!empty($comment)) {
                        $stmt = $con->prepare('INSERT INTO comments(comment, comment_date, status, item_id, user_id) 
                        VALUES(:comment, NOW(), 0, :itemid, :userid)');
                        $stmt->execute(array(
                            'comment'   => $comment,
                            'userid'    => $_SESSION['uid'],
                            'itemid'    => $itemid
                        ));
                        if ($stmt) {
                            echo '<div class="alert alert-info" role="alert"><i class="fa-solid fa-circle-check"></i> Comment recored added successfully</div>';
                        }
                    } else {
                        echo '<div class="alert alert-danger" role="alert"><i class="fa-solid fa-circle-xmark"></i> Comment Can\'t be empty</div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <?php } else {
        echo '<a href="login.php">Login</a> or <a href="login.php">Register</a> to add comment';
    } ?>
    <!-- End Add Comment -->
    <hr />
    <div class="row show-comment">
        <?php 
        $stmt = $con->prepare('SELECT comments.*, users.Username AS Member FROM comments 
        INNER JOIN users ON users.UserID = comments.user_id WHERE item_id = :itemid AND status = 1 ORDER BY c_id DESC');
        $stmt->execute(array(
            'itemid' => $itemid
        ));
        $comments = $stmt->fetchAll();
        foreach ($comments as $comment) {
            ?>
            <div class="col-sm-2 text-center">
                <img src="img.jpg" class="rounded-circle img-thumbnail" alt="...">
                <?php echo $comment['Member']; ?>
            </div>
            <div class="col-sm-10">
                <p class="lead"><?php echo $comment['comment'] ?></p>
                <br />
                <span class="fst-italic fw-light"><?php echo $comment['comment_date']; ?></span>
            </div>
            <hr />
        <?php } ?>
    </div>
</div>

<?php 
} else {
    echo '<div class="container">';
    $errorMsg = '<div class="alert alert-danger" role="alert"><i class="fa-solid fa-circle-xmark"></i> There is no such ID Or this item watting aproval</div>';
    redirectHome($errorMsg);
    echo '</div>';
}
include $tplDir . 'footer.php';
ob_end_flush();
?>