<?php
ob_start(); // Output Buffering Start
session_start();
$pageTitle = "Dashboard";

if (isset($_SESSION['Username'])) {
    include 'init.php';

    /* Start Dashborad Page */
    $countLusers = 6;
    $Lusers = getLatest('*', 'users', 'UserID', $countLusers, 'user');

    $countLItems = 4;
    $LItems = getLatest('Item_ID, Name, Approve', 'items', 'Item_ID', $countLItems);
?>

    <div class="container home-stats text-center">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="stat st-members">
                    <i class="fa-solid fa-users"></i>
                    <div class="info">
                        Total Members
                        <span><a href="members.php"><?php echo countItems('UserID', 'users'); ?></a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-pending">
                <i class="fa-solid fa-person-circle-plus"></i>
                    <div class="info">
                        Pending Members
                        <span><a href="members.php?do=Manage&page=Pending">
                            <?php echo checkItems('RegStatus', 'users', 0) ?>
                        </a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-items">
                <i class="fa-solid fa-tags"></i>
                    <div class="info">
                        Total Items
                            <span><a href="items.php">
                                <?php echo countItems('Item_ID', 'items') ?>
                            </a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-comments">
                    <i class="fa-solid fa-comments"></i>
                    <div class="info">
                        Total Comments
                        <span>
                            <a href="comments.php"><?php echo countItems('comment', 'comments'); ?></a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container latest">
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-users"></i> Latest <?php echo $countLusers; ?> Registered Users
                    <span class="toggle-info float-end"><i class="fa-solid fa-minus fa-lg"></i></span>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled latest-users">
                            <?php
                            if (! empty($Lusers)) {
                                foreach ($Lusers as $user) {
                                    echo '<li><strong>' . $user['Username'] . '</strong><a href="members.php?do=Edit&userid=' . $user['UserID'] . '"><span class="btn btn-sm btn-success float-end"><i class="fa-regular fa-pen-to-square"></i> Edit</span></a>';
                                    if($user['RegStatus'] == 0) {
                                        echo '<a href="?do=Activate&userid=' . $user['UserID'] . '" class="btn btn-sm btn-info activate float-end"><i class="fa-solid fa-check"></i> Activate</a>';
                                    }
                                    echo '</li>';
                                }
                            } else {
                                echo 'There is not record to show';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-tag"></i> Latest Items
                        <span class="toggle-info float-end"><i class="fa-solid fa-minus fa-lg"></i></span>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled latest-users">
                        <?php
                        if (! empty($LItems)) {
                            foreach ($LItems as $item) {
                                echo '<li><strong>' . $item['Name'] . '</strong><a href="items.php?do=Edit&itemid=' . $item['Item_ID'] . '"><span class="btn btn-sm btn-success float-end"><i class="fa-regular fa-pen-to-square"></i> Edit</span></a>';
                                if($item['Approve'] == 0) {
                                    echo '<a href="items.php?do=Approve&itemid=' . $item['Item_ID'] . '&page=dash" class="btn btn-sm btn-info activate float-end"><i class="fa-solid fa-check-to-slot"></i> Approve</a>';
                                }
                                echo '</li>';
                            }
                        } else {
                            echo 'There is not record to show';
                        }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
    /* End Dashborad Page */

    include $tplDir . 'footer.php';
}else {
    header("Location: index.php");
}

ob_end_flush(); //Release The Output
?>