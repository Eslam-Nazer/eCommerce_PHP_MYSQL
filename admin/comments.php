<?php
ob_start();
session_start();

$pageTitle = "Comments";

if (isset($_SESSION['Username'])) {

    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if($do == 'Manage'){
        $stmt = $con->prepare('SELECT comments.*, items.Name AS item_name, users.Username AS username FROM comments 
        INNER JOIN items ON items.Item_ID = comments.item_id 
        INNER JOIN users ON users.UserID = comments.user_id');
        $stmt->execute();

        $rows = $stmt->fetchAll();

        if (! empty($rows)) {

?>

        <h1 class="text-center">Manage Comments</h1>
            <div class="container">
                <div class="table-responsive">
                    <table class="main-table table table-bordered text-center">
                        <tr>
                            <td><strong>#ID</strong></td>
                            <td><strong>Comment</strong></td>
                            <td><strong>Item Name</strong></td>
                            <td><strong>User Name</strong></td>
                            <td><strong>Added Date</strong></td>
                            <td><strong>Control</strong></td>
                        </tr>
                        <?php

                        foreach ($rows as $row) {
                            echo '<tr>';
                                echo '<td><strong>' . $row['c_id'] . '</strong></td>';
                                echo '<td><strong>' . $row['comment'] . '</strong></td>';
                                echo '<td><strong>' . $row['item_name'] . '</strong></td>';
                                echo '<td><strong>' . $row['username'] . '</strong></td>';
                                echo '<td><strong>' . $row['comment_date'] . '</td>';
                                echo '<td>
                                    <a href="?do=Edit&comid=' . $row['c_id'] . '" class="btn btn-sm btn-success"><i class="fa-solid fa-comment-dots"></i> Edit</a>
                                    <a href="?do=Delete&comid='. $row['c_id'] . '" class="btn btn-sm btn-danger confirm"><i class="fa-solid fa-comment-slash"></i> Delete</a>';

                                if($row['status'] == 0) {
                                    echo '<a href="?do=Approve&comid=' . $row['c_id'] . '" class="btn btn-sm btn-info activate"><i class="fa-solid fa-check"></i> Approve</a>';
                                }

                                echo '</td>';
                            echo '</tr>';
                        }

                        ?>
                    
                    </table>
                </div>
            </div>

<?php

                    } else {
                        echo '<h1 class="text-center">Manage comments</h1>';
                    echo '<div class="container">';
                    echo '<div class="alert alert-info text-center" role="alert"><i class="fa-solid fa-circle-info"></i> <strong>There is not Record for users to show it</strong></div>';
                    echo '</div>';
                    }
?>

<?php


    } elseif ($do == 'Edit') {
        // check if request comid is numeric & get integer value
        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;


        // Select All Data depend on this ID
        $stmt = $con->prepare('SELECT comments.*, items.Name AS item_name, users.Username AS username FROM comments 
        INNER JOIN items ON items.Item_ID = comments.item_id
        INNER JOIN users ON users.UserID = comments.user_id WHERE c_id = :comid');
        //execute query
        $stmt->execute(array(
            'comid' => $comid,
        ));
        // Fetch this data
        $row = $stmt->fetch();

        $check = $stmt->rowCount();

        
        if ($check > 0) {

?>

    <h1 class="text-center">Edit Comments</h1>
        <div class="container">
            <form action="?do=Update" method="post">
            <input type="hidden" name="comid" value="<?php echo $row['c_id']; ?>" />
                <!-- Start Comment field -->
                <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                    <textarea class="form-control" name="comment" id="floatingTextarea" style="height: 150px;" placeholder="Leave a comment here" ><?php echo $row['comment']; ?></textarea>
                    <label for="floatingTextarea" style="font-weight: bold;">Comment</label>
                </div>
                <!-- End Comment field -->
                <!-- Start Item field -->
                <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                    <input type="email" class="form-control" id="floatingInputDisabled" placeholder="Name Of Item" value="<?php echo $row['item_name'] ?>" disabled>
                    <label for="floatingInputDisabled">Item</label>
                </div>
                <!-- End Item field -->
                <!-- Start Member field -->
                <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                    <input type="email" class="form-control" id="floatingInputDisabled" placeholder="Name Of Member" value="<?php echo $row['username'] ?>" disabled>
                    <label for="floatingInputDisabled">Item</label>
                </div>
                <!-- End Member field -->
                <!-- Start save button -->
                <div class="form-group row mb-3">
                    <div class="update-btn col-sm-5 d-grid gap-2">
                        <input type="submit" name="update" value="Save Comment" class="btn btn-primary btn-lg">
                    </div>
                </div>
                <!-- End save button -->
            </form>
        </div>

<?php

        } else {
            echo '<h1 class="text-center">Edit Comments</h1>';
            echo '<div class="container">';
            $errorMsg = '<div class="alert alert-danger" role=""alert><i class="fa-solid fa-circle-xmark"></i> <strong>There is No such ID</strong></div>';
            redirectHome($errorMsg, 4, 'comments.php');
            echo '</div>';
        }

    } elseif ($do == 'Update') {

        echo '<h1 class="text-center">Update Comment</h1>';
        echo '<div class="container">';
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get variables from form
        $comid      = $_POST['comid'];
        $comment    = $_POST['comment'];



            if (!empty($comment)){
                // Update data with this info after check the comment field not empty
                $stmt = $con->prepare('UPDATE comments SET comment = :comment WHERE c_id = :comid');
                $stmt->execute(array(
                    'comment' => $comment,
                    'comid'   => $comid
                ));
                $successMsg = '<div class="alert alert-success" role="alert"><i class="fa-solid fa-circle-check"></i> <strong>' . $stmt->rowCount() . ' Record Updated</strong></div>';
                redirectHome($successMsg, 5, 'comments.php');

            } else {
                $errorMsg = '<div class="alert alert-danger" role="alert"><i class="fa-solid fa-circle-xmark"></i><strong> Comment can\'t be empty</strong></div>';
                redirectHome($errorMsg, 4, 'comments.php?do=Edit&comid=' . $comid);
            }
        } else {
            $errorMsg = '<div class="alert alert-danger" role="alert"><i class="fa-solid fa-circle-xmark"></i> <strong>You can\'t browse this page directly</strong></div>';
            redirectHome($errorMsg, 5, 'comments.php');
        }
        echo '</div>';

    } elseif ($do == 'Delete') {
        echo '<h1 class="text-center">Delete Comment</h1>';
        echo '<div class="container">';
        
        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

        $check = checkItems('c_id', 'comments', $comid);

        if ($check > 0) {

        $stmt = $con->prepare('DELETE FROM comments WHERE c_id = :comid');
        $stmt->execute(array(
            'comid' => $comid
        ));

        $successMsg = '<div class="alert alert-success" role="alert"><i class="fa-solid fa-circle-check"></i> <strong>' . $stmt->rowCount() . ' Record Deleted</strong></div>';
        redirectHome($successMsg, 5, 'comments.php');

        } else {
            $errorMsg = '<div class="alert alert-danger" role=""alert><i class="fa-solid fa-circle-xmark"></i> <strong>There is No such ID</strong></div>';
            redirectHome($errorMsg, 4, 'comments.php');
        }

    } elseif ($do == 'Approve') {
        echo '<h1 class="text-center">Approve Comment</h1>';
        echo '<div class="container">';

        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

        $check = checkItems('c_id', 'comments', $comid);

        if ($check > 0){
        $stmt = $con->prepare('UPDATE comments SET status = 1 WHERE c_id = :comid');
        $stmt->execute(array(
            'comid' => $comid
        ));

        $successMsg = '<div class="alert alert-success" role="alert"><i class="fa-solid fa-circle-check"></i> <strong>' . $stmt->rowCount() . ' Record Approved</strong></div>';
        redirectHome($successMsg, 5, 'comments.php');

        } else {
            $errorMsg = '<div class="alert alert-danger" role=""alert><i class="fa-solid fa-circle-xmark"></i> <strong>There is No such ID</strong></div>';
            redirectHome($errorMsg, 4, 'comments.php');
        }

        echo '</div>';
    }

    include $tplDir . 'footer.php';

}
ob_end_flush();