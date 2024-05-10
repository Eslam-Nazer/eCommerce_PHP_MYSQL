<?php 
ob_start();
session_start();
$pageTitle = "Create New Item";
include 'init.php';
if (isset($_SESSION['user'])) {
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $desc = $_POST['description'];
        $price = $_POST['price'];
        $country = $_POST['country'];
        $status = $_POST['status'];
        $cat = $_POST['category'];

    }
?>
<h1 class="text-center"><?php echo $pageTitle ?></h1>
<div class="create-ad block">
    <div class="container">
        <div class="card border-primary">
            <h5 class="card-header text-bg-primary"><?php echo $pageTitle ?></h5>
            <div class="card-body">
                <div class="row gx-5">
                    <div class="col-md-8">
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                            <!-- Start name field -->
                            <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-9">
                                <input class="form-control live-name" type="text" name="name" id="floatingInput" placeholder="Name of the item" required>
                                <label for="floatingInput" style="font-weight: bold;">Name of item</label>
                            </div>
                            <!-- End name field -->
                            <!-- Start Description field -->
                            <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-9">
                                <input class="form-control live-desc" type="text" name="description" id="floatingInput" placeholder="Name of the item" required>
                                <label for="floatingInput" style="font-weight: bold;">Description</label>
                            </div>
                            <!-- End Description field -->
                            <!-- Start Price field -->
                            <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-9">
                                <input class="form-control live-price" type="text" name="price" id="floatingInput" placeholder="Price of the item" required>
                                <label for="floatingInput" style="font-weight: bold;">Price</label>
                            </div>
                            <!-- End Price field -->
                            <!-- Start Country field -->
                            <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-9">
                                <input class="form-control" type="text" name="country" id="floatingInput" placeholder="Country of made" required>
                                <label for="floatingInput" style="font-weight: bold;">Country of made</label>
                            </div>
                            <!-- End Country field -->
                            <!-- Start Status field -->
                            <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-9">
                                <select name="status">
                                    <option value="0" selected>Choose Status of item</option>
                                    <option value="1">New</option>
                                    <option value="2">Like New</option>
                                    <option value="3">Used</option>
                                    <option value="4">Old</option>
                                </select>
                            </div>
                            <!-- End Status field -->
                            <!-- Start Category field -->
                            <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-9">
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
                                <input type="submit" name="insert" value="Add Item" class="btn btn-primary btn-lg">
                            <!-- End save button -->
                        </form>
                    </div>
                    <div class="col-md-4">
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="card item-box live-preview" style="width: 18rem;">
                                <span class="price-tag">0$</span>
                                <img src="img.jpg" class="card-img-top img-thumbnail" alt="...">
                                <div class="card-bady">
                                    <div class="card-title"> <h3> Name </h3></div>
                                    <p class="card-text">this is test</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include $tplDir . 'footer.php';
} else {
    header('Location: index.php');
    exit();
}
ob_end_flush();
?>