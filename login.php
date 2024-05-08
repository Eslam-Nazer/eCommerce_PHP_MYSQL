<?php 
ob_start();
session_start();
$pageTitle = 'Login';
include 'init.php'; 
if (isset($_SESSION['user'])){
    header('Location: index.php'); // go to home page
    exit();
}
// Check if user come from HTTP POST request
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        //get values from form
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $hashedPassword = sha1($pass);

        //Check if this user exist in database
        $stmt = $con->prepare('SELECT Username,Password FROM users WHERE Username = :user AND Password = :pass AND GroupID != 1');
        $stmt->execute(array(
            'user' => $user,
            'pass' => $hashedPassword
        ));
        $count = $stmt->rowCount();
        
        //if count > 0 this mean the database have record about this user
        if($count > 0) {
            $_SESSION['user'] = $user;
            header('Location: index.php');
            exit();
        }
    } else {
        $formErrors = array();
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];
        $email = $_POST['email'];
        if (isset($username)) {
            // $userFiltering = preg_replace( "/[^a-zA-Z-_]/", ' ','<script>eslam.test@gmail.com </script><h5></h5>1'=1''--');
            // replace it to function to use in other situations of filtering
            $filterUser = filteringInput($username, "USERNAME");
            if (strlen($filterUser) < 4) {
                $formErrors[] = "User Name must be larger than 3 characters";
            }
        }
        if (isset($password) && isset($confirmPassword)) {
            if(empty($password) && empty($confirmPassword)) {
                $formErrors[] = "Password can't be empty";
            }
            $filterPassword        = sha1(filteringInput($password, 'PASSWORD'));
            $filterConfirmPassword = sha1(filteringInput($confirmPassword, 'PASSWORD'));
            if ($filterPassword !== $filterConfirmPassword) {
                $formErrors[] = 'Password is not match';
            }
        }
        if (isset($email)) {
            $filterEmail = filteringInput(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL), 'EMAIL');
                if (filter_var($filterEmail, FILTER_VALIDATE_EMAIL) != true) {
                    $formErrors[] = 'This Email is not valid';
                }
            
        }
        if (empty($formErrors)){
            $checkForUser = checkItems('Username', 'users', $filterUser);
            if ($checkForUser == 1) {
                $formErrors[] = 'This username already exist';
            } else {
                $stmt = $con->prepare('INSERT INTO users(Username, Password, Email, RegStatus, Date) VALUES(:username, :password, :email, 0, now())');
                $stmt->execute(array(
                    'username' => $filterUser,
                    'password' => $filterPassword,
                    'email'    => $filterEmail
                ));
                $successMsg = "Congrats you are now registerd user";
            }
        }
    }
}
?>

<div class="container login-page">
    <h1 class="text-center">
        <span class="selected" data-class="login">Login</span> |
        <span data-class="signup">Signup</span>
    </h1>
    <form class="login form-floating" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <div class="form-floating">
            <input type="text" name="username" class="form-control" id="floatingInputGrid" placeholder="username felid" required>
            <label for="floatingInputGrid"><strong>User Name</strong></label>
        </div>
        <div class="form-floating">
            <input type="password" name="password" class="form-control" id="floatingInputGrid" placeholder="password felid" autocomplete="new-password" required>
            <label for="floatingInputGrid"><strong>Password</strong></label>
        </div>
        <div class="d-grid gap-2">
            <input type="submit" class="btn btn-primary" name="login" value="Login">
        </div>
    </form>
    <form class="signup form-floating" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="form-floating">
            <input pattern=".{4,}" title="User Name must be larger than 3 characters" type="text" name="username" class="form-control" id="floatingInputGrid" placeholder="username felid" required>
            <label for="floatingInputGrid"><strong>User Name</strong></label>
        </div>
        <div class="form-floating">
            <input minlength="8" type="password" name="password" class="form-control" id="floatingInputGrid" placeholder="password felid" autocomplete="new-password" required>
            <label for="floatingInputGrid"><strong>Password</strong></label>
        </div>
        <div class="form-floating">
            <input minlength="8" type="password" name="confirm_password" class="form-control" id="floatingInputGrid" placeholder="password felid" autocomplete="new-password" required>
            <label for="floatingInputGrid"><strong>Confirm Password</strong></label>
        </div>
        <div class="form-floating">
            <input type="email" name="email" class="form-control" id="floatingInputGrid" placeholder="Email Felid" autocomplete="off" >
            <label for="floatingInputGrid"><strong>Email</strong></label>
        </div>
        <div class="d-grid gap-2">
            <input type="submit" class="btn btn-success" name="signup" value="Signup">
        </div>
    </form>
    <div class="the-errors text-center">
        <?php 
            if (!empty($formErrors)){
                foreach ($formErrors as $error){
                    echo '<div class="msg error" ><i class="fa-solid fa-triangle-exclamation"></i> ' . $error . '</div>';
                }
            }
            if (isset($successMsg)) {
                echo '<div class="msg success"><i class="fa-solid fa-circle-check"></i> ' . $successMsg . '</div>';
            }
        ?>
    </div>
</div>

<?php 
include $tplDir . 'footer.php'; 
ob_end_flush();
?>