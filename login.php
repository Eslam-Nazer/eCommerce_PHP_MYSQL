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
        $userFiltering = preg_replace( "/[^a-zA-Z-_]/", ' ','<script>_<script><h5>eslam</h5>');

        echo $userFiltering;
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
    <input type="text" name="test" />
            <div class="form-floating">
                <input type="text" name="username" class="form-control" id="floatingInputGrid" placeholder="username felid" required>
                <label for="floatingInputGrid"><strong>User Name</strong></label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="floatingInputGrid" placeholder="password felid" autocomplete="new-password" required>
                <label for="floatingInputGrid"><strong>Password</strong></label>
            </div>
            <div class="form-floating">
                <input type="password" name="confirm_password" class="form-control" id="floatingInputGrid" placeholder="password felid" autocomplete="new-password" required>
                <label for="floatingInputGrid"><strong>Confirm Password</strong></label>
            </div>
            <div class="form-floating">
                <input type="email" name="email" class="form-control" id="floatingInputGrid" placeholder="Email Felid" autocomplete="off" required>
                <label for="floatingInputGrid"><strong>Email</strong></label>
            </div>
            <div class="d-grid gap-2">
                <input type="submit" class="btn btn-success" name="signup" value="Signup">
            </div>
    </form>
    <div class="the-errors text-center">
        
    </div>
</div>

<?php 
include $tplDir . 'footer.php'; 
ob_end_flush();
?>