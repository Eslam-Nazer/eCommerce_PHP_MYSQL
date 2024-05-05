<?php 
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
                Name: <?php echo $info['Username']; ?> <br />
                Email: <?php echo $info['Email']; ?> <br />
                Full Name: <?php echo $info['FullName']; ?> <br />
                Register Date: <?php echo $info['Date']; ?> <br />
                Favourite Category:
            </div>
        </div>
    </div>
</div>
<div class="my-ads block">
    <div class="container">
        <div class="card border-primary ">
            <h5 class="card-header text-bg-primary">My Advertisements</h5>
            <div class="card-body">
                <div class="row gx-5">
                    <?php 
                    $items = getItems('Member_ID', $info['UserID']);
                    foreach ($items as $item) {
                        echo '<div class="col-sm-6 col-md-4 col-lg-3">';
                        echo '<div class="card item-box" style="width: 18rem;">';
                        echo '<span class="price-tag">' . $item['Price'] . '</span>';
                        echo '<img src="img.jpg" class="card-img-top img-thumbnail" alt="...">';
                        echo '<div class="card-body">';
                        echo '<h3 class="card-title">' . $item['Name'] . '</h3>';
                        echo '<p class="card-text">' . $item['Description'] . '</p>';
                        echo '<a href="#" class="btn btn-primary">Go somewhere</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
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
?>