<?php
ob_start();
session_start();

$pageTitle = 'Items';

if (isset($_SESSION['Username'])) {
    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if($do == 'Manage') {

        // Select All Items
        $stmt = $con->prepare("SELECT items.*, categories.Name AS Category_Name, users.Username As Member_Name FROM items 
                            INNER JOIN categories ON categories.ID = Items.Cat_ID 
                            INNER JOIN users ON users.UserID = Items.Member_ID ");
        // Execute The Statement
        $stmt->execute();
        // Assign To Variable
        $items = $stmt->fetchAll();

        if (! empty($items)) {
?>
        <h1 class="text-center">Mange Items</h1>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table table table-bordered text-center">
                    <tr>
                        <td><strong>#ID</strong></td>
                        <td><strong>Name</strong></td>
                        <td><strong>Description</strong></td>
                        <td><strong>Price</strong></td>
                        <td><strong>Adding Date</strong></td>
                        <td><strong>Country</strong></td>
                        <td><strong>Category</strong></td>
                        <td><strong>Member</strong></td>
                        <td style="width: 249px;"><strong>Control</strong></td>
                    </tr>
                    <?php

                    foreach ($items as $item) {
                        echo '<tr>';
                            echo '<td><strong>' . $item['Item_ID'] . '</strong></td>';
                            echo '<td><strong>' . $item['Name'] . '</strong></td>';
                            echo '<td><strong>' . $item['Description'] . '</strong></td>';
                            echo '<td><strong>' . $item['Price'] . '</strong></td>';
                            echo '<td><strong>' . $item['Add_Date'] . '</td>';
                            echo '<td><strong>' . $item['Country_Made'] . '</td>';
                            echo '<td><strong>' . $item['Category_Name'] . '</td>';
                            echo '<td><strong>' . $item['Member_Name'] . '</td>';
                            echo '<td>
                                <a href="?do=Edit&itemid=' . $item['Item_ID'] . '" class="btn btn-sm btn-success"><i class="fa-regular fa-pen-to-square"></i> Edit</a>
                                <a href="?do=Delete&itemid='. $item['Item_ID'] . '" class="btn btn-sm btn-danger confirm"><i class="fa-solid fa-square-xmark"></i> Delete</a>';
                            if ($item['Approve'] == 0) {
                                echo '<a href="?do=Approve&itemid=' . $item['Item_ID'] . '" class="btn btn-sm btn-info activate"><i class="fa-solid fa-check-to-slot"></i> Approve</a>';
                            }
                            echo '</td>';
                        echo '</tr>';
                    }

                    ?>
                
                </table>
            </div>

        <a href="items.php?do=Add" class="btn btn-primary add-item"><i class="fa-solid fa-plus"></i> New Item</a>

    </div>

<?php

                } else {
                    echo '<h1 class="text-center">Manage Items</h1>';
                    echo '<div class="container">';
                    echo '<div class="alert alert-info text-center" role="alert"><i class="fa-solid fa-circle-info"></i> <strong>There is not Record for users to show it</strong></div>';
                    echo '<a href="items.php?do=Add" class="btn btn-primary"><i class="fa-solid fa-plus"></i> New Item</a>';
                    echo '</div>';
                }

?>
<?php
    } elseif ($do == 'Add') {
?>

        <h1 class="text-center">Add New Item</h1>

            <div class="container">
                <form action="?do=Insert" method="post">
                    <!-- Start name field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <input class="form-control" type="text" name="name" id="floatingInput" placeholder="Name of the item" required>
                        <label for="floatingInput" style="font-weight: bold;">Name</label>
                    </div>
                    <!-- End name field -->
                    <!-- Start Description field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <input class="form-control" type="text" name="description" id="floatingInput" placeholder="Name of the item" required>
                        <label for="floatingInput" style="font-weight: bold;">Description</label>
                    </div>
                    <!-- End Description field -->
                    <!-- Start Price field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <input class="form-control" type="text" name="price" id="floatingInput" placeholder="Price of the item" required>
                        <label for="floatingInput" style="font-weight: bold;">Price</label>
                    </div>
                    <!-- End Price field -->
                    <!-- Start Country field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <input class="form-control" type="text" name="country" id="floatingInput" placeholder="Country of made" required>
                        <label for="floatingInput" style="font-weight: bold;">Country of made</label>
                    </div>
                    <!-- End Country field -->
                    <!-- Start Status field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <select name="status">
                            <option value="0" selected>Choose Status of item</option>
                            <option value="1">New</option>
                            <option value="2">Like New</option>
                            <option value="3">Used</option>
                            <option value="4">Old</option>
                        </select>
                    </div>
                    <!-- End Status field -->
                    <!-- Start Member field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <select name="member">
                            <option value="0" selected>Choose Member</option>
                            <?php
                            $stmt = $con->prepare('SELECT UserID, Username FROM users');
                            $stmt->execute();
                            $users = $stmt->fetchAll();

                            foreach ($users as $user) {
                                echo '<option value="' . $user['UserID'] . '">' . $user['Username'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <!-- End Member field -->
                    <!-- Start Category field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <select name="category">
                            <option value="0" selected>Choose Category</option>
                            <?php
                            $stmt = $con->prepare('SELECT ID, Name FROM categories');
                            $stmt->execute();
                            $cats = $stmt->fetchAll();

                            foreach ($cats as $cat) {
                                echo '<option value="' . $cat['ID'] . '">' . $cat['Name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <!-- End Category field -->

                    <!-- Start save button -->
                    <div class="form-group row mb-3">
                        <div class="update-btn col-sm-5 d-grid gap-2">
                            <input type="submit" name="insert" value="Add Item" class="btn btn-primary btn-lg">
                        </div>
                    </div>
                    <!-- End save button -->

                </form>
            </div>

<?php
    } elseif ($do == 'Insert') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            echo '<h1 class="text-center"> Insert Item </h1>';
            echo '<div class="container">';

            // Get Variables From The Form
            $name       = $_POST['name'];
            $desc       = $_POST['description'];
            $price      = $_POST['price'];
            $country    = $_POST['country'];
            $status     = $_POST['status'];
            $member     = $_POST['member'];
            $category   = $_POST['category'];

            $formErrors = array();

            if (empty($name)) {
                $formErrors[] = ' Name Can\'t be Empty';
            }
            if (empty($desc)) {
                $formErrors[] = ' Description Can\'t be Empty';
            }
            if (empty($price)) {
                $formErrors[] = ' Price Can\'t be Empty';
            }
            if (empty($country)) {
                $formErrors[] = ' Country Can\'t be Empty';
            }
            if ($status == 0) {
                $formErrors[] = ' You must choose the status of item';
            }
            if ($member == 0) {
                $formErrors[] = ' You must choose the Member of item';
            }
            if ($category == 0) {
                $formErrors[] = ' You must choose the Category of item';
            }


            foreach ($formErrors as $error) {
                echo '<div class="alert alert-danger" role="alert"><i class="fa-solid fa-circle-xmark"></i> <strong>' . $error . '</strong></div>';
            }

            if (empty($formErrors)) {
                $stmt = $con->prepare('INSERT INTO items (Name, Description, Price, Add_Date, Country_Made, Status, Cat_ID, Member_ID) VALUES (:name, :desc, :price, NOW(), :country, :status, :categoryID, :memberID)');
                $stmt->execute(array(
                    'name'      => $name,
                    'desc'      => $desc,
                    'price'     => $price,
                    'country'   => $country,
                    'status'    => $status,
                    'categoryID'=> $category,
                    'memberID'  => $member
                ));

                $successMsg = '<div class="alert alert-success" role="alert"><i class="fa-solid fa-circle-check"></i> ' . $stmt->rowCount() . ' Record Inserted</div>';
                redirectHome($successMsg, 5, 'items.php');
            }

            echo '</div>';
        } else {
            echo '<div class="container">';
            $errorMsg = '<div class="alert alert-danger"><i class="fa-solid fa-circle-xmark"></i><strong> You can\'t browse this page directly</strong></div>';
            redirectHome($errorMsg);
            echo '</div>';
        }


    } elseif ($do == 'Edit') {

        echo '<h1 class="text-center">Edit Item</h1>';
        echo '<div class="container">';

        $itemID = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

        $stmt = $con->prepare('SELECT * FROM items WHERE Item_ID = :itemID');
        $stmt->execute(array(
            'itemID' => $itemID
        ));
        $item = $stmt->fetch();

        $check = $stmt->rowCount();

        if ($check > 0) {

?>
            <form action="?do=Update" method="post">
                <input type="hidden" name="itemid" value="<?php echo $itemID ?>" />
                    <!-- Start name field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <input class="form-control" type="text" name="name" id="floatingInput" placeholder="Name of the item" value="<?php echo $item['Name']; ?>" required>
                        <label for="floatingInput" style="font-weight: bold;">Name</label>
                    </div>
                    <!-- End name field -->
                    <!-- Start Description field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <input class="form-control" type="text" name="description" id="floatingInput" placeholder="Name of the item" value="<?php echo $item['Description']; ?>" required>
                        <label for="floatingInput" style="font-weight: bold;">Description</label>
                    </div>
                    <!-- End Description field -->
                    <!-- Start Price field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <input class="form-control" type="text" name="price" id="floatingInput" placeholder="Price of the item" value="<?php echo $item['Price']; ?>" required>
                        <label for="floatingInput" style="font-weight: bold;">Price</label>
                    </div>
                    <!-- End Price field -->
                    <!-- Start Country field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <input class="form-control" type="text" name="country" id="floatingInput" placeholder="Country of made" value="<?php echo $item['Country_Made']; ?>" required>
                        <label for="floatingInput" style="font-weight: bold;">Country of made</label>
                    </div>
                    <!-- End Country field -->
                    <!-- Start Status field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <select name="status">
                            <option value="0" selected>Choose Status of item</option>
                            <option value="1" <?php if($item['Status'] == 1) { echo 'selected'; } ?>>New</option>
                            <option value="2" <?php if($item['Status'] == 2) { echo 'selected'; } ?>>Like New</option>
                            <option value="3" <?php if($item['Status'] == 3) { echo 'selected'; } ?>>Used</option>
                            <option value="4" <?php if($item['Status'] == 4) { echo 'selected'; } ?>>Old</option>
                        </select>
                    </div>
                    <!-- End Status field -->
                    <!-- Start Member field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <select name="member">
                            <option value="0" selected>Choose Member</option>
                            <?php
                            $stmt = $con->prepare('SELECT UserID, Username FROM users');
                            $stmt->execute();
                            $users = $stmt->fetchAll();

                            foreach ($users as $user) {
                                echo '<option value="' . $user['UserID'] . '"';
                                if ($item['Member_ID'] == $user['UserID']) { echo 'selected'; }
                                echo '>' . $user['Username'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <!-- End Member field -->
                    <!-- Start Category field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <select name="category">
                            <option value="0" selected>Choose Category</option>
                            <?php
                            $stmt = $con->prepare('SELECT ID, Name FROM categories');
                            $stmt->execute();
                            $cats = $stmt->fetchAll();

                            foreach ($cats as $cat) {
                                echo '<option value="' . $cat['ID'] . '"';
                                if ( $item['Cat_ID'] == $cat['ID']) { echo 'selected'; }
                                echo '>' . $cat['Name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <!-- End Category field -->

                    <!-- Start save button -->
                    <div class="form-group row mb-3">
                        <div class="update-btn col-sm-5 d-grid gap-2">
                            <input type="submit" name="update" value="Save Item" class="btn btn-primary btn-lg">
                        </div>
                    </div>
                    <!-- End save button -->
                </form>

            <?php

            $stmtComment = $con->prepare('SELECT comments.c_id, comments.comment AS comment, comments.comment_date AS date,
            comments.status, users.Username AS username FROM comments INNER JOIN users ON users.UserID = comments.user_id
            WHERE item_id = :item_id');
            
            $stmtComment->execute(array(
                'item_id' => $itemID
            ));
            $comments = $stmtComment->fetchAll();
            ?>

                    <div class="table-responsive">
                    <table class="main-table table table-bordered text-center">
                        <tr>
                            <td><strong>Comment</strong></td>
                            <td><strong>User Name</strong></td>
                            <td><strong>Added Date</strong></td>
                            <td><strong>Control</strong></td>
                        </tr>

                        <?php
                foreach ($comments as $comment) {
                    echo '<tr>';
                    echo '<td><strong>' . $comment['comment'] . '</strong></td>';
                    echo '<td><strong>' . $comment['username'] . '</strong></td>';
                    echo '<td><strong>' . $comment['date'] . '</strong></td>';
                    echo '<td>
                    <a href="comments.php?do=Edit&comid=' . $comment['c_id'] . '" class="btn btn-sm btn-success"><i class="fa-solid fa-comment-dots"></i> Edit</a>
                    <a href="comments.php?do=Delete&comid='. $comment['c_id'] . '" class="btn btn-sm btn-danger confirm"><i class="fa-solid fa-comment-slash"></i> Delete</a>';
                    if($comment['status'] == 0) {
                        echo '<a href="?do=Approve&comid=' . $comment['c_id'] . '" class="btn btn-sm btn-info activate"><i class="fa-solid fa-check"></i> Approve</a>';
                    }
                    echo '</td>';
                    ECHO '</tr>';
                }
            ?>

<?php
        } else {
            $errorMsg = '<div class="alert alert-danger" role="alert"><i class="fa-solid fa-circle-xmark"></i> <strong>Something Wrong </strong></div>';
            redirectHome($errorMsg, 5, 'items.php');
        }
        echo '</div;';
    } elseif ($do == 'Update') {
        echo '<h1 class="text-center"> Update Item </h1>';
        echo '<div class="container">';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get Variable from From
        $itemid  = $_POST['itemid'];
        $name    = $_POST['name'];
        $desc    = $_POST['description'];
        $price   = $_POST['price'];
        $country = $_POST['country'];
        $status  = $_POST['status'];
        $member  = $_POST['member'];
        $cat     = $_POST['category'];

        // Validate form
        $formErrors = array();

            if (empty($name)) {
                $formErrors[] = ' Name Can\'t be Empty';
            }
            if (empty($desc)) {
                $formErrors[] = ' Description Can\'t be Empty';
            }
            if (empty($price)) {
                $formErrors[] = ' Price Can\'t be Empty';
            }
            if (empty($country)) {
                $formErrors[] = ' Country Can\'t be Empty';
            }
            if ($status == 0) {
                $formErrors[] = ' You must choose the status of item';
            }
            if ($member == 0) {
                $formErrors[] = ' You must choose the Member of item';
            }
            if ($cat == 0) {
                $formErrors[] = ' You must choose the Category of item';
            }


            foreach ($formErrors as $error) {
                echo '<div class="alert alert-danger" role="alert"><i class="fa-solid fa-circle-xmark"></i> <strong>' . $error . '</strong></div>';
            }

            if (empty($formErrors)) {
                $stmt = $con->prepare('UPDATE items SET Name = :name, Description = :desc, Price = :price, Country_Made = :country, Status = :status, Member_ID = :member, Cat_ID = :catrgory WHERE Item_ID = :itemid');
                $stmt->execute(array(
                    'name'      => $name,
                    'desc'      => $desc,
                    'price'     => $price,
                    'country'   => $country,
                    'status'    => $status,
                    'member'    => $member,
                    'catrgory'  => $cat,
                    'itemid'    => $itemid
                ));
                // Echo success msg

                $successMsg = '<div class="alert alert-success" role="alert"><i class="fa-solid fa-circle-check"></i> <strong>' . $stmt->rowCount() . ' Record Updated</strong></div>';
                redirectHome($successMsg, 5, 'items.php');
            }

        } else {
            $errorMsg = '<div class="alert alert-danger" role="alert"><i class="fa-solid fa-circle-xmark"></i> <strong>You can\'t browse this page directly</strong></div>';
            redirectHome($errorMsg, 5, 'items.php');
        }

        echo '</div>';
    } elseif ($do == 'Delete') {
        echo '<h1 class="text-center">Delete Item</h1>';
        echo '<div class="container">';
        
        // Check if Get request itemid is numeric & get the integer value of it
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

        // Select all data depend on this ID
        $check = checkItems('Item_ID', 'items', $itemid);

        if ($check > 0) {
            $stmt = $con->prepare('DELETE FROM items WHERE Item_ID = :id');
            $stmt->execute(array(
                'id' => $itemid
            ));

            $successMsg = '<div class="alert alert-success" role="alert"><i class="fa-solid fa-circle-check"></i><strong> ' . $stmt->rowCount() . ' Recored Deleted</strong></div>';
            redirectHome($successMsg, 5, 'items.php');
        } else {
            $errorMsg = '<div class="alert alert-danger" role=""alert><i class="fa-solid fa-circle-xmark"></i> <strong>There is No such ID</strong></div>';
            redirectHome($errorMsg, 4, 'items.php');
        }


        echo '</div>';
    } elseif ($do == 'Approve') {
        echo '<h1 class="text-center"> Approve Item </h1>';
        echo '<div class="container">';
        
        // check if request itemid is numeric & get the integer value of it
        $itemID = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? $_GET['itemid'] : 0;

        // Select All data depend on this id
        $check = checkItems('Item_ID', 'items', $itemID);

        if ($check > 0) {
            $stmt = $con->prepare('UPDATE items SET Approve = 1 WHERE Item_ID = :id');
            $stmt->execute(array(
                'id' => $itemID
            ));
            if(isset($_GET['page']) == 'dash') {
                $successMsg = '<div class="alert alert-success" role="alert"><i class="fa-solid fa-circle-check"></i> <strong>' . $stmt->rowCount() . ' Item approved successfully</strong></div>';
                redirectHome($successMsg, 5);
            } else {
            $successMsg = '<div class="alert alert-success" role="alert"><i class="fa-solid fa-circle-check"></i> <strong>' . $stmt->rowCount() . ' Item approved successfully</strong></div>';
            redirectHome($successMsg, 5, 'items.php');
            }
        } else {
            $errorMsg = '<div class="alert alert-danger" role="alert"><i class="fa-solid fa-circle-xmark"></i> <strong> There is No such item to Approve</strong></div>';
            redirectHome($errorMsg, 3, 'items.php');
        }

        echo '</div>';
    } else {
        $errorMsg = '<div class="alert alert-danger" role="alert"><i class="fa-solid fa-circle-xmark"></i><strong> Something Wrong </strong></div>';
        redirectHome($errorMsg);
    }



    include $tplDir . 'footer.php';

}

ob_end_flush();
?>