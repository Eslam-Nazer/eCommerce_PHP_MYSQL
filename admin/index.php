<?php 
session_start();
$noNavbar  = '';
$pageTitle = "Login";

if (isset($_SESSION['Username'])) {
    header('Location: dashboard.php'); // Redirect To Dashboard Page
}

include 'init.php';

// Check If User Coming From HTTP Post Request

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['user'];
    $password = $_POST['pass'];
    $hashPassword = sha1($password);

    // Check If User Exist In Database
    $stmt = $con->prepare("SELECT UserID, Username, Password FROM users WHERE Username = ? AND Password = ? AND GroupID = 1 LIMIT 1"); 
    $stmt->execute(array($username , $hashPassword));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    //echo $count;

    // If Count > 0 This Mean The Database Contain Record About This Username
    if ($count > 0) {
        $_SESSION['Username'] = $username; // Register session username
        $_SESSION['ID'] = $row['UserID'];  // Register session ID
        header('Location: dashboard.php'); // Redirect To Dashboard Page
        exit();
    }
}

?>

    <form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <h4 class="text-center">Admin Login</h4>
        <div class="form-floating">
            <input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off" />
            <label for="floatingInput" style="font-weight: bold;">Username</label>
        </div>
        <div class="form-floating">
            <input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password" />
            <label for="floatingInput" style="font-weight: bold;">Password</label>
        </div>
        <div class="d-grid gap-2">
            <input class="btn btn-primary" type="submit" value="Login" />
        </div>
    </form>

<?php
include $tplDir . 'footer.php';
?>