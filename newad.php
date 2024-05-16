<?php 
ob_start();
session_start();
$pageTitle = "Create New Item";
include 'init.php';
if (isset($_SESSION['user'])) {
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $formErrors = array();
        $name    = filteringInput($_POST['name'], 'STRING');
        $desc    = filteringInput($_POST['description'], 'STRING');
        $price   = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
        $country = filteringInput($_POST['country'], "STRING");
        $status  = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
        $category     = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);

        if (strlen($name) < 4) {
            $formErrors[] = 'Name of item must be at least 4 characters';
        }
        if (strlen($desc) < 10) {
            $formErrors[] = 'Description of item must be at least 10 characters';
        }
        if (strlen($country) < 2) {
            $formErrors[] = 'Country filed must be at least 2 characters';
        }
        if (empty($price) || $price == 0) {
            $formErrors[] = 'Price of item must be not empty';
        }
        if (empty($status) || $status == 0) {
            $formErrors[] = 'Status of item must be not empty';
        }
        if (empty($category) || $category == 0) {
            $formErrors[] = 'Category of item must be not empty';
        }
        if (empty($formErrors)) {
            $stmt = $con->prepare('INSERT INTO Items(Name, Description, Price, Add_Date, Country_Made, Status, Cat_ID, Member_ID) 
            VALUES(:name, :desc, :price, now(), :country, :status, :category, :user)');
            $stmt->execute(array(
                'name'     => $name,
                'desc'     => $desc,
                'price'    => $price,
                'country'  => $country,
                'status'   => $status,
                'category' => $category,
                'user'     => $_SESSION['uid']
            ));
            if ($stmt) {
                echo '<div class="container">';
                echo '<div class="alert alert-success" role="alert"><i class"fa-solid fa-circle-check"> Item add successfully</i></div>';
                echo '</div>';
            }
        }
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
                                <input class="form-control live-name" type="text" name="name" id="floatingInput" placeholder="Name of the item" pattern=".{4,}" title="This field require at least 4 characters" required>
                                <label for="floatingInput" style="font-weight: bold;">Name of item</label>
                            </div>
                            <!-- End name field -->
                            <!-- Start Description field -->
                            <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-9">
                                <input class="form-control live-desc" type="text" name="description" id="floatingInput" placeholder="Name of the item" pattern=".{10,}" title="This field require at least 10 characters" required>
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
                                <input class="form-control" type="text" name="country" id="floatingInput" placeholder="Country of made" pattern=".{2,}" title="This field require at least 2 characters" required>
                                <label for="floatingInput" style="font-weight: bold;">Country of made</label>
                            </div>
                            <!-- End Country field -->
                            <!-- Start Status field -->
                            <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-9">
                                <select name="status" required>
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
                                <select name="category" required>
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
                <!-- Start Errors Loop -->
                <?php 
                if (!empty($formErrors)){
                    foreach ($formErrors as $error) {
                        echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
                    }
                }
                ?>
                <!-- End Errors Loop -->
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