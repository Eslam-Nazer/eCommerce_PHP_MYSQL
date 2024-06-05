<?php

/**
 * Mange Members page
 * You can Add | Edit | Delete Members From Here
 */

    session_start();
    $pageTitle = "Members";

    if(isset($_SESSION['Username'])) {
        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : "Manage";

        // Start Manage Page
            if($do == "Manage") {// Manage Page
                
                $query = '';
                if(isset($_GET['page']) && $_GET['page'] == "Pending") {
                    $query = "AND RegStatus = 0";
                }

                // Select All Users Except Admin
                $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query");
                // Execute The Statement
                $stmt->execute();
                // Assign To Variable
                $rows = $stmt->fetchAll();

                if (! empty($rows)) {
?>
            <h1 class="text-center">Manage Members</h1>
            <div class="container">
                <div class="table-responsive">
                    <table class="main-table table table-bordered text-center">
                        <tr>
                            <td><strong>#ID</strong></td>
                            <td><strong>Username</strong></td>
                            <td><strong>Email</strong></td>
                            <td><strong>Full Name</strong></td>
                            <td><strong>Registered Date</strong></td>
                            <td><strong>Control</strong></td>
                        </tr>
                        <?php

                        foreach ($rows as $row) {
                            echo '<tr>';
                                echo '<td><strong>' . $row['UserID'] . '</strong></td>';
                                echo '<td><strong>' . $row['Username'] . '</strong></td>';
                                echo '<td><strong>' . $row['Email'] . '</strong></td>';
                                echo '<td><strong>' . $row['FullName'] . '</strong></td>';
                                echo '<td><strong>' . $row['Date'] . '</td>';
                                echo '<td>
                                    <a href="?do=Edit&userid=' . $row['UserID'] . '" class="btn btn-sm btn-success"><i class="fa-regular fa-pen-to-square"></i> Edit</a>
                                    <a href="?do=Delete&userid='. $row['UserID'] . '" class="btn btn-sm btn-danger confirm"><i class="fa-solid fa-user-slash"></i> Delete</a>';

                                if($row['RegStatus'] == 0) {
                                    echo '<a href="?do=Activate&userid=' . $row['UserID'] . '" class="btn btn-sm btn-info activate"><i class="fa-solid fa-user-check"></i> Activate</a>';
                                }

                                echo '</td>';
                            echo '</tr>';
                        }

                        ?>
                    
                    </table>
                </div>

                <a href="members.php?do=Add" class="btn btn-primary"><i class="fa-solid fa-user-plus"></i> New Member</a>

            </div>

<?php
                } else {
                    echo '<h1 class="text-center">Manage Members</h1>';
                    echo '<div class="container">';
                    echo '<div class="alert alert-info text-center" role="alert"><i class="fa-solid fa-circle-info"></i> <strong>There is not Record for users to show it</strong></div>';
                    echo '<a href="members.php?do=Add" class="btn btn-primary"><i class="fa-solid fa-user-plus"></i> New Member</a>';
                    echo '</div>';
                }
?>

<?php
            } elseif ($do == "Add") { // Add Page
?>
            <h1 class="text-center">Add New Member</h1>

            <div class="container edit-form">
                <form action="?do=Insert" method="post" enctype="multipart/form-data">
                    <!-- Start username field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <input class="form-control" type="text" name="username" id="floatingInput" placeholder="Username To Login Into Shop" autocomplete="off" required>
                        <label for="floatingInput" style="font-weight: bold;">UserName</label>
                    </div>
                    <!-- End username field -->
                    <!-- Start Password field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <input class="form-control" type="password" name="password" id="floatingInput" placeholder="Password Must Be Hard And Complex" autocomplete="new-password" required >
                        <label for="floatingInput" style="font-weight: bold;">Password</label>
                    </div>
                    <!-- End Password field -->
                    <!-- Start Email field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <input class="form-control" type="email" name="email" id="floatingInput" placeholder="name@example.com" required>
                        <label for="floatingInput" style="font-weight: bold;">Email address</label>
                    </div>
                    <!-- End Email field -->
                    <!-- Start FullName field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <input class="form-control" type="text" name="fullname" id="floatingInput" placeholder="Your Full Name Apper In Your Profile Page" required>
                        <label for="floatingInput" style="font-weight: bold;">Full Name</label>
                    </div>
                    <!-- End FullName field -->
                    <!-- Start Avatar field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <input class="form-control" type="file" name="avatarinfo" required>
                    </div>
                    <!-- End Avatar field -->
                    <!-- Start save button -->
                    <div class="form-group row mb-3">
                        <div class="update-btn col-sm-5 d-grid gap-2">
                            <input type="submit" name="update" value="Add Member" class="btn btn-primary btn-lg">
                        </div>
                    </div>
                    <!-- End save button -->

                </form>
            </div>

<?php
            } elseif ($do == "Insert") {

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    
                    echo '<h1 class="text-center">Add New Member</h1>';
                    echo '<div class="container edit-form">';
                    // Get upload array
                    $avatarinfo = $_FILES['avatarinfo'];
                    // Get upload variables
                        $avatarName = $avatarinfo['name'];
                        $avatarSize = $avatarinfo['size'];
                        $avatarTmp  = $avatarinfo['tmp_name'];
                        $avatarType = $avatarinfo['type'];
                    $avatarAllowedExtension = ['jpeg','jpg','png','gif'];
                    $tmp = explode('.', $avatarName);
                    $avatarExtension = strtolower(end($tmp));
                    // Get variables from form
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $email    = $_POST['email'];
                    $fullname = $_POST['fullname'];

                    $hashPassword = sha1($password);

                    $formErrors = array();
                    if (empty($username)) {
                        $formErrors[] = "username can't be empty";
                    } elseif (strlen($username) < 4) {
                        $formErrors[] = "username must be more than 4 charcters";
                    } elseif (strlen($username) > 20) {
                        $formErrors[] = "username must be less than 20 charcters";
                    }

                    if (empty($password)) {
                        $formErrors[] = "Password can't be empty";
                    }

                    if (empty($email)) {
                        $formErrors[] = "Email can't be empty";
                    }

                    if (empty($fullname)){
                        $formErrors[] = "Full Name can't be empty";
                    }

                    if(!empty($avatarName) && !in_array($avatarExtension, $avatarAllowedExtension)) {
                        $formErrors[] = "This extension not <strong>Allowed</strong>";
                    }
                    if(empty($avatarName)) {
                        $formErrors[] = "Avatar is <strong>required</strong>";
                    }
                    if($avatarSize > 4194304) {
                        $formErrors[] = "Avatar size can't be larger than 4mp";
                    }

                    foreach ($formErrors as $error) {
                        echo '<div class="alert alert-danger" role="alert"><i class="fa-solid fa-circle-xmark"></i> ' . $error . '</div>';
                    }

                    if(empty($formErrors)) {

                        $avatar = rand(0, 1000000000) . "_" . $avatarName;
                        $checkUsername = checkItems("Username", "users", $username) ;
                        if($checkUsername == 1) {
                            $errorMsg = '<div class="alert alert-danger" role="alert"><i class="fa-solid fa-circle-xmark"></i> Sorry This User Name is not available to you. Please add another one </div>';

                            redirectHome($errorMsg, 5, "members.php?do=Add");
                        } else {
                            $stmt = $con->prepare("INSERT INTO users(Username, Password, Email, FullName, RegStatus, Date, avatar) VALUES(:uname, :pass, :email, :fname, 1, now(), :avatar)");
                            $stmt->execute(array(
                                'uname'     => $username,
                                'pass'      => $hashPassword,
                                'email'     => $email,
                                'fname'     => $fullname,
                                'avatar'    => $avatar
                            ));
                            move_uploaded_file($avatarTmp, 'upload\avatar\\' . $avatar);
                            $success = '<div class="alert alert-success" role="alert"><i class="fa-solid fa-circle-check"></i>' . $stmt->rowCount() . ' Recored Inserted</div>';
                            redirectHome($success, 5, "members.php");
                        }
                    }

                    echo '</div>';
                } else {
                    echo "<div class='container'>";
                    $errorMsg = '<div class="alert alert-danger" role="alert"><i class="fa-solid fa-circle-xmark"></i> Sorry You Can\'t Browse This Page</div>';
                    redirectHome($errorMsg, 6);
                    echo "</div>";
                }

            } elseif ($do == "Edit") { // Edit Page
                // Check If Get Request userid Is Numeric & Get The Integer Value Of It
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
                // Select All Data Depend On This ID
                $stmt = $con->prepare(" SELECT * FROM users WHERE UserID = ? LIMIT 1");
                // Execute Query
                $stmt->execute(array($userid));
                // Fetch the Data => Data Is Coming :D
                $row = $stmt->fetch();
                // The Row Count Changed If Data Found
                $count = $stmt->rowCount();
                // If There's Such ID ,Show The Form With Data
                if ($count > 0){
            ?>

            <h1 class="text-center">Profile Editing</h1>

            <div class="container edit-form">
                <form action="?do=Update" method="post">
                    <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                    <!-- Start username field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <input class="form-control" type="text" name="username" value="<?php echo $row['Username']; ?>" id="floatingInput" placeholder="Your UserName" autocomplete="off" required>
                        <label for="floatingInput" style="font-weight: bold;">UserName</label>
                    </div>
                    <!-- End username field -->
                    <!-- Start Password field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <input type="hidden" name="oldpassword" value="<?php echo $row['Password']; ?>">
                        <input class="form-control" type="password" name="newpassword" id="floatingInput" placeholder="Your Password" autocomplete="new-password">
                        <label for="floatingInput" style="font-weight: bold;">Password</label>
                    </div>
                    <!-- End Password field -->
                    <!-- Start Email field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <input class="form-control" type="email" name="email" value="<?php echo $row['Email']; ?>" id="floatingInput" placeholder="name@example.com" required>
                        <label for="floatingInput" style="font-weight: bold;">Email address</label>
                    </div>
                    <!-- End Email field -->
                    <!-- Start FullName field -->
                    <div class="form-floating mb-3 col-sm-10 col-md-6 col-lg-5">
                        <input class="form-control" type="text" name="fullname" value="<?php echo $row['FullName']; ?>" id="floatingInput" placeholder="Your FullName" >
                        <label for="floatingInput" style="font-weight: bold;">Full Name</label>
                    </div>
                    <!-- Start FullName field -->
                    <!-- Start save button -->
                    <div class="form-group row mb-3">
                        <div class="update-btn col-sm-5 d-grid gap-2">
                            <input type="submit" name="update" value="Save" class="btn btn-primary btn-lg">
                        </div>
                    </div>
                    <!-- End save button -->

                </form>
            </div>

            <?php 
                // If There's ID Not Exist Then Show An Error Message 
                } else {
                    echo "<div class='container'>";
                    $errorMsg = "<div class='alert alert-danger' role='alert'><i class='fa-solid fa-circle-xmark'></i> Something Wrong</div>";
                    redirectHome($errorMsg, 5);
                    echo "</div>";
                    // End Of Edit Page
                }
            } elseif($do == "Update") { // Update Page
?>
                <h1 class="text-center">Update Profile</h1>
                <div class="container"> 

<?php
                if($_SERVER['REQUEST_METHOD'] == "POST"){
                // Get Variable From This Form
                $id         = $_POST['userid'];
                $username   = $_POST['username'];
                $email      = $_POST['email'];
                $fullname   = $_POST['fullname'];
                
                // Password Trick
                if(empty($_POST['newpassword'])) {
                    $password = $_POST['oldpassword'];
                } else {
                    $password = sha1($_POST['newpassword']);
                }

                // Validate The Data
                $formErrors = array();

                if(empty($username)) {
                    $formErrors[] = " Username Can't Be Empt";
                } elseif(strlen($username) < 4) {
                    $formErrors[] = " Username Can't Be Less Than 4 Characters";
                } elseif(strlen($username) > 20) {
                    $formErrors[] = " Username Can't Be More Than 20 Characters";
                }
                if(empty($email)){
                    $formErrors[] = " Email Can't Be Empty";
                }
                if(empty($fullname)){
                    $formErrors[] = " Full Name Can't Be Empty";
                } elseif(strlen($fullname) < 7) {
                    $formErrors[] = " Full Name Can't Be Less Than 7 Characters";
                }

                foreach ($formErrors as $error) {
                    echo '<div class="alert alert-danger" role="alert"><i class="fa-solid fa-circle-xmark"></i>' . $error . '</div>';
                }

                if (empty($formErrors)) {

                $stmtCheck = $con->prepare('SELECT UserID, Username FROM users WHERE Username = :username AND UserID != :userid');
                $stmtCheck->execute(array(
                    'username' => $username,
                    'userid'   => $id
                ));
                $stmtCheckCount = $stmtCheck->rowCount();

                if ($stmtCheckCount > 0) {
                    $errorMsg = '<div class="alert alert-danger" role="alert"><i class="fa-solid fa-circle-xmark"></i> <strong>This user actually Exist</strong></div>';
                    redirectHome($errorMsg,'','?do=Edit&userid=' . $id);
                } else {
                // Update The Database With This Info
                $stmt = $con->prepare('UPDATE users SET Username = ?, Password = ?, Email = ?, FullName = ? WHERE UserID = ?');
                $stmt->execute(array($username, $password, $email, $fullname, $id));

                $successMsg = "<div class ='alert alert-success' role='alert' style = 'display: block;'><i class='fa-solid fa-circle-check'></i> " . $stmt->rowCount() . " Has Been Updated</div>";
                
                redirectHome($successMsg, 4,"?do=Edit&userid=" . $id);
                }
                }

                } else {
                    $errorMsg =  "<div class='alert alert-danger' role='alert'><i class='fa-solid fa-circle-xmark'></i> Sorry You Can't Browse This Page</div>";
                    redirectHome($errorMsg);
                } 
?>
                </div>
<?php
            } elseif ($do == "Delete") { // Delete Member Page
                echo '<h1 class="text-center">Delete User</h1>';
                echo '<div class="container">';
                // Check If Get Request userid Is Numeric & Get The Integer Value Of It
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
                // Select All Data Depend On This ID
                $check = checkItems('UserID', 'users', $userid);

                // Check If Row Count Greater Than 0 In This case ID Exist And Delete This User
                if ($check > 0) {
                    $stmt = $con->prepare('DELETE FROM users WHERE UserId = :userid');
                    $stmt->bindParam(':userid', $userid);
                    $stmt->execute();
                    $successMsg = '<div class="alert alert-success" role="alert"><i class="fa-solid fa-circle-check"></i> ' . $stmt->rowCount() . ' Recored Deleted</div>';
                    redirectHome($successMsg, 5, "members.php");
                } else {
                    $errorMsg = '<div class="alert alert-danger" role="alert"><i class="fa-solid fa-circle-xmark"></i> This ID Not Exist</div>';
                    redirectHome($errorMsg, 5, "members.php");
                } 
                echo '</div>';
            } elseif ($do == 'Activate') {
                echo '<h1 class="text-center">Delete User</h1>';
                echo '<div class="container">';
                // Check If Get Request userid Is Numeric & Get The Integer Value Of It
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;
                // Select All Data Depend On This ID
                $check = checkItems('UserID', 'users', $userid);
                // Check If Row Count Greater Than 0 In This case ID Exist And Delete This User
                if ($check > 0) {
                    $stmt = $con->prepare('UPDATE users SET RegStatus = 1 WHERE UserID = :userid');
                    $stmt->execute(array(
                        'userid' => $userid
                    ));
                    $successMsg = $successMsg = '<div class="alert alert-success" role="alert"><i class="fa-solid fa-circle-check"></i> ' . $stmt->rowCount() . ' Recored Activated</div>';
                    redirectHome($successMsg, 5, "members.php");
                } else {
                    $errorMsg = '<div class="alert alert-danger" role="alert"><i class="fa-solid fa-circle-xmark"></i> This ID Not Exist</div>';
                    redirectHome($errorMsg, 5, "members.php");
                }
            }
        // End Manage Page

        include $tplDir . 'footer.php';
    } else {
        header('Location: index.php');
        exit();
    }