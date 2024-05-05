<?php
/**
 * Category Page
 */

ob_start();
session_start();
$pageTitle = "Category";

if (isset($_SESSION['Username'])) {
    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    if ($do == 'Manage') {

        $sort = 'ASC';
        $sortArray = ['ASC', 'DESC'];
        if(isset($_GET['sort']) && in_array($_GET['sort'] , $sortArray)) {
            $sort = $_GET['sort'];
        }

        $stmt = $con->prepare('SELECT * FROM categories ORDER BY Ordering '. $sort);
        $stmt->execute();
        $cats = $stmt->fetchAll();
?>
        <h1 class="text-center">Manage Categories</h1>
        <div class="container categories">
            <div class="card">
                <div class="card-header">
                    <i class="fa-solid fa-edit"></i> Manage Categories
                    <div class="Ordering float-end">
                    <i class="fa-solid fa-sort"></i> Ordering : [
                        <a class="<?php if ($sort == 'ASC') { echo 'active'; } ?>" href="?sort=ASC">ASC</a> |
                        <a class="<?php if ($sort == 'DESC') { echo 'active'; } ?>" href="?sort=DESC">DESC</a> ]
                    </div>
                </div>
                <div class="card-body">
<?php
        if (! empty($cats)) {
            foreach ($cats as $cat) {
                echo '<div class="cat">';
                echo '<div class="hidden-buttons">';
                echo '<a href="categories.php?do=Edit&catid=' . $cat['ID'] . '" class="btn btn-primary"><i class="fa-regular fa-pen-to-square"></i> Edit</a>';
                echo '<a href="categories.php?do=Delete&catid=' . $cat['ID'] . '" class="btn btn-danger confirm"><i class="fa-solid fa-calendar-xmark"></i> Delete</a>';
                echo '</div>';
                echo '<h3>' . $cat['Name'] . '</h3>';
                echo '<div class="full-view">';
                    echo '<p>'; 
                    if ($cat['Description'] == '') {
                        echo 'This category has no description';
                    } else {
                        echo $cat['Description'];
                    }
                    echo '</p>';

                    if ($cat['Visibility'] == '1') {
                        echo '<span class="visibility hidden"><i class="fa-solid fa-eye-slash"></i> Hidden</span>';
                    } else {
                        echo '<span class="visibility visible"><i class="fa-solid fa-eye"></i> Visible</span>';
                    }

                    if ($cat['Allow_Comment'] == '1') {
                        echo '<span class="commenting com-dis"><i class="fa-solid fa-comment-slash"></i> Comment Disable</span>';
                    } else {
                        echo '<span class="commenting com-enb"><i class="fa-solid fa-comment-dots"></i> Comment Enable</span>';
                    }

                    if ($cat['Allow_ads'] == '1') {
                        echo '<span class="advertises ads-dis"><i class="fa-regular fa-bell-slash"></i> Ads Disable</span>';
                    } else {
                        echo '<span class="advertises ads-enb"><i class="fa-solid fa-rectangle-ad"></i> Ads Enable</span>';
                    }

                echo '</div>';
                echo '</div>';
                echo '<hr />';
            }
?>
                </div>
            </div>
            <a class="btn btn-primary add-cat" href="categories.php?do=Add"><i class="fa-solid fa-cart-plus"></i> Add Category </a>
        </div>

<?php

        } else {
            echo '<div class="container">';
            echo '<div class="alert alert-info text-center" role="alert"><i class="fa-solid fa-circle-info"></i> <strong>There is not Record for users to show it</strong></div>';
            echo '<a class="btn btn-primary add-cat" href="categories.php?do=Add"><i class="fa-solid fa-cart-plus"></i> Add Category </a>';
            echo '</div>';
        }

?>
<?php
    } elseif ($do == 'Add') {
?>

        <h1 class="text-center">Add New Category</h1>

            <div class="container edit-form">
                <form action="?do=Insert" method="post">
                    <!-- Start name field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <input class="form-control" type="text" name="name" id="floatingInput" placeholder="Name Of Category" autocomplete="off" required>
                        <label for="floatingInput" style="font-weight: bold;">Name</label>
                    </div>
                    <!-- End name field -->
                    <!-- Start Description field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <input class="form-control" type="text" name="description" id="floatingInput" placeholder="Description For Your Categories">
                        <label for="floatingInput" style="font-weight: bold;">Description</label>
                    </div>
                    <!-- End Description field -->
                    <!-- Start Ordering field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <input class="form-control" type="text" name="ordering" id="floatingInput" placeholder="Number for arrange the categories">
                        <label for="floatingInput" style="font-weight: bold;">Ordering</label>
                    </div>
                    <!-- End Ordering field -->
                    <!-- Start Visibility field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <div><strong>Visibility:</strong></div>
                        <div>
                            <input type="radio" name="visibility" id="vis-y" value="0" checked>
                            <label for="vis-y">Yes</label>
                        </div>
                        <div>
                            <input type="radio" name="visibility" id="vis-n" value="1">
                            <label for="vis-n">No</label>
                        </div>
                    </div>
                    <!-- Start Visibility field -->
                    <!-- Start Commenting field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <div><strong>Allow Commenting:</strong></div>
                        <div>
                            <input type="radio" name="commenting" id="com-y" value="0" checked>
                            <label for="com-y">Yes</label>
                        </div>
                        <div>
                            <input type="radio" name="commenting" id="com-n" value="1">
                            <label for="com-n">No</label>
                        </div>
                    </div>
                    <!-- End Commenting filed -->
                    <!-- Start Ads field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <div><strong>Allow Ads</strong></div>
                        <div>
                            <input type="radio" name="ads" id="ad-y" value="0" checked>
                            <label for="ad-y">Yes</label>
                        </div>
                        <div>
                            <input type="radio" name="ads" id="ads-n" value="1">
                            <label for="ads-n">No</label>
                        </div>
                    </div>
                    <!-- End Ads filed -->
                    <!-- Start save button -->
                    <div class="form-group row mb-3">
                        <div class="update-btn col-sm-5 d-grid gap-2">
                            <input type="submit" name="insert" value="Add Category" class="btn btn-primary btn-lg">
                        </div>
                    </div>
                    <!-- End save button -->

                </form>
            </div>

<?php
    } elseif ($do == 'Insert') {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            echo '<h1 class="text-center">Insert Category</h1>';
            echo '<div class="container edit-form">';
        // Get Variable from

        $name       = $_POST['name'];
        $desc       = $_POST['description'];
        $order      = $_POST['ordering'];
        $visible    = $_POST['visibility'];
        $comment    = $_POST['commenting'];
        $ads        = $_POST['ads'];

        $check = checkItems('Name', 'categories', $name);

        if($check == 1) {
            $errorMsg = '<div class="alert alert-danger" role="alert"><i class="fa-solid fa-circle-xmark"></i> This category exist, Add a new category </div>';
            redirectHome($errorMsg, 4, '?do=Add');
        } else {
            if (! empty($name)) {
                $stmt = $con->prepare('INSERT INTO categories(Name, Description, Ordering, Visibility, Allow_Comment, Allow_ads) VALUES(:name, :desc, :order, :visible, :comment, :ads)');
                $stmt->execute(array(
                    'name'      => $name,
                    'desc'      => $desc,
                    'order'     => $order,
                    'visible'   => $visible,
                    'comment'   => $comment,
                    'ads'       => $ads
                ));

                $successMsg = '<div class="alert alert-success" role="alert"><i class="fa-solid fa-circle-check"></i> ' . $stmt->rowCount() . ' Record Inserted</div>';
                redirectHome($successMsg, 5, 'categories.php');
            } else {
                $errorMsg = '<div class="alert alert-danger"><i class="fa-solid fa-circle-xmark"></i> Name can not be empty</div>';
                redirectHome($errorMsg, 4, '?do=Add');
            }
        }

            echo '</div>';
        } else {
            $errorMsg = '<div class="alert alert-danger" role="alert"><i class="fa-solid fa-circle-xmark"></i> You can\'t browse this page directly </div>';
            redirectHome($errorMsg, 4);
        }

    } elseif ($do == 'Edit') {
        
        $catid= isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

        $stmt = $con->prepare('SELECT * FROM categories WHERE ID = :catid');
        $stmt->execute(array(
            'catid' => $catid
        ));
        $cat = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($count > 0) {
?>
        <h1 class="text-center">Edit Category</h1>

        <div class="container edit-form">
            <form action="?do=Update" method="post">
                <input type="hidden" name="catid" value="<?php echo $catid; ?>" />
                <!-- Start name field -->
                <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                    <input class="form-control" type="text" name="name" id="floatingInput" placeholder="Name Of Category" value="<?php echo $cat['Name'] ?>" required>
                    <label for="floatingInput" style="font-weight: bold;">Name</label>
                </div>
                <!-- End name field -->
                <!-- Start Description field -->
                <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                    <input class="form-control" type="text" name="description" id="floatingInput" placeholder="Description For Your Categories" value="<?php echo $cat['Description'] ?>">
                    <label for="floatingInput" style="font-weight: bold;">Description</label>
                </div>
                <!-- End Description field -->
                <!-- Start Ordering field -->
                <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                    <input class="form-control" type="text" name="ordering" id="floatingInput" placeholder="Number for arrange the categories" value="<?php echo $cat['Ordering'] ?>">
                    <label for="floatingInput" style="font-weight: bold;">Ordering</label>
                </div>
                <!-- End Ordering field -->
                <!-- Start Visibility field -->
                <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                    <div><strong>Visibility:</strong></div>
                    <div>
                        <input type="radio" name="visibility" id="vis-y" value="0" <?php if ($cat['Visibility'] == 0) { echo 'checked'; } ?> >
                        <label for="vis-y">Yes</label>
                    </div>
                    <div>
                        <input type="radio" name="visibility" id="vis-n" value="1" <?php if ($cat['Visibility'] == 1) { echo 'checked'; } ?> >
                        <label for="vis-n">No</label>
                    </div>
                </div>
                <!-- Start Visibility field -->
                <!-- Start Commenting field -->
                <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                    <div><strong>Allow Commenting:</strong></div>
                    <div>
                        <input type="radio" name="commenting" id="com-y" value="0" <?php if ($cat['Allow_Comment'] == 0) { echo 'checked'; } ?> >
                        <label for="com-y">Yes</label>
                    </div>
                    <div>
                        <input type="radio" name="commenting" id="com-n" value="1" <?php if ($cat['Allow_Comment'] == 1) { echo 'checked'; } ?> >
                        <label for="com-n">No</label>
                    </div>
                </div>
                <!-- End Commenting filed -->
                <!-- Start Ads field -->
                <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                    <div><strong>Allow Ads</strong></div>
                    <div>
                        <input type="radio" name="ads" id="ad-y" value="0" <?php if ($cat['Allow_ads'] == 0) { echo 'checked'; } ?> >
                        <label for="ad-y">Yes</label>
                    </div>
                    <div>
                        <input type="radio" name="ads" id="ads-n" value="1" <?php if ($cat['Allow_ads'] == 1) { echo 'checked'; } ?> >
                        <label for="ads-n">No</label>
                    </div>
                </div>
                <!-- End Ads filed -->
                <!-- Start save button -->
                <div class="form-group row mb-3">
                    <div class="update-btn col-sm-5 d-grid gap-2">
                        <input type="submit" name="update" value="Update Category" class="btn btn-primary btn-lg">
                    </div>
                </div>
                <!-- End save button -->

    </form>
</div>

<?php
        } else {
            echo "<div class='container'>";
            $errorMsg = "<div class='alert alert-danger' role='alert'><i class='fa-solid fa-circle-xmark'></i> Something Wrong</div>";
            redirectHome($errorMsg, 5, 'categories.php');
            echo "</div>";
            // End Of Edit Page
        }
    } elseif ($do == 'Update') {

        echo '<h1 class="text-center"> Update Category </h1>';
        echo '<div class="container">';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get Variable From The Form
            $id     = $_POST['catid'];
            $name   = $_POST['name'];
            $desc   = $_POST['description'];
            $order  = $_POST['ordering'];
            // Get Variable form radio value
            $visible = $_POST['visibility'];
            $comment = $_POST['commenting'];
            $ads     = $_POST['ads'];

            // Update the database with this varible value
            $stmt = $con->prepare('UPDATE categories SET Name = :name, Description = :desc, Ordering = :order, Visibility = :visible, Allow_Comment = :comment, Allow_ads = :ads WHERE ID = :id');
            $stmt->execute(array(
                'name'      => $name,
                'desc'      => $desc,
                'order'     => $order,
                'visible'   => $visible,
                'comment'   => $comment,
                'ads'       => $ads,
                'id'        => $id
            ));

            $successMsg = '<div class="alert alert-success" role="alert"><i class="fa-solid fa-circle-check"></i> ' . $stmt->rowCount() . ' Record Updated</div>';
            redirectHome($successMsg, 4, 'categories.php');

        } else {
            $errorMsg = '<div class="alert alert-danger" role="alert"><i class="fa-solid fa-circle-xmark"></i> <strong>You can\'t Browse this page directly</strong> </div>';
            redirectHome($errorMsg, 4, 'categories.php');
        }
        echo '</div>';
    } elseif ($do == 'Delete') {
        echo '<h1 class="text-center"> Delete Category </h1>';
        echo '<div class="container">';
        // Check if GET Request catid is Numeric & get the integer value of it
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
        // Select All Data depend on this ID
        $check = checkItems('ID', 'categories', $catid);

        if ($check >0) {
            $stmt = $con->prepare('DELETE FROM categories WHERE ID = :id');
            $stmt->execute(array(
                'id' => $catid
            ));
            $successDeleteMsg = '<div class="alert alert-success" role="alert"><i class="fa-solid fa-circle-check"></i> '. $stmt->rowCount() . ' Record Deleted</div>' ;
            redirectHome($successDeleteMsg, 5, 'categories.php');
        } else {
            $errorMsg = '<div class="alert alert-danger"><i class="fa-solid fa-circle-xmark"></i> This <storng>ID</strong> Not Exist </div>';
            redirectHome($errorMsg, 4, 'categories.php');
        }
        echo '</div>';
    }


    include $tplDir . 'footer.php';
} else {
    header('Locate:index.php');
    exit();
}

ob_end_flush();
?>