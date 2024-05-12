<?php 
ob_start();
session_start();
$pageTitle = 'Profile';

include 'init.php';
if (isset($_SESSION['user'])){
    $getUser = $con->prepare('SELECT * FROM users WHERE Username = :user');
    $getUser->execute(array(
        'user' => $sessionUser
    ));
    $info = $getUser->fetch();
?>

<h1 class="text-center">My Profile</h1>
<div class="information block">
    <div class="container">
        <div class="card border-primary ">
            <h5 class="card-header text-bg-primary">My information</h5>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li><i class="fa-solid fa-unlock fa-fw"></i> <span>Login Name</span> : <?php echo $info['Username']; ?> </li>
                    <li><i class="fa-solid fa-envelope fa-fw"></i> <span>Email</span> : <?php echo $info['Email']; ?> </li>
                    <li><i class="fa-solid fa-user-check fa-fw"></i> <span>Full Name</span> : <?php echo $info['FullName']; ?> </li>
                    <li><i class="fa-regular fa-calendar-days fa-fw"></i> <span>Register Date</span> : <?php echo $info['Date']; ?> </li>
                    <li><i class="fa-regular fa-tags fa-fw"></i> <span>Favourite Category</span> : </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="my-ads block">
    <div class="container">
        <div class="card border-primary ">
            <h5 class="card-header text-bg-primary">My Advertisements</h5>
            <div class="card-body">
                <?php 
                $items = getItems('Member_ID', $info['UserID']);
                if (!empty($items)) {
                    echo '<div class="row gx-5">';
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
                    echo '</div>';
                } else {
                    echo 'There is no <strong>ads</strong> to show, Create <a href="newad.php" class="btn btn-sm btn-primary" >New Ad</a>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<div class="comment block">
    <div class="container">
        <div class="card border-primary ">
            <h5 class="card-header text-bg-primary">My Comments</h5>
            <div class="card-body">
                <?php 
                $getComments = $con->prepare('SELECT * FROM comments WHERE user_id = :userid');
                $getComments->execute(array(
                    'userid' => $info['UserID']
                ));
                $comments = $getComments->fetchAll();
                if(! empty($comments)){
                    foreach($comments as $comment) {
                        echo '<p>' . $comment['comment'] . '</p>';
                    }
                } else {
                    echo 'There is no <strong>Comments</strong> to show';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php 
} else {
    header('Location: login.php');
    exit();
}

include $tplDir . 'footer.php';
ob_end_flush();
?>