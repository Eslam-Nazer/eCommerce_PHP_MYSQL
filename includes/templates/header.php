<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="referrer" content="strict-origin" />
    <title><?php getTitle() ?></title>
    <link rel="stylesheet" href="<?php echo $cssDir; ?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $cssDir; ?>fontawesome.css">
    <link rel="stylesheet" href="<?php echo $cssDir; ?>jquery-ui.css">
    <link rel="stylesheet" href="<?php echo $cssDir; ?>jquery.selectBoxIt.css">
    <link rel="stylesheet" href="<?php echo $cssDir; ?>brands.css">
    <link rel="stylesheet" href="<?php echo $cssDir; ?>solid.css">
    <link rel="stylesheet" href="<?php echo $cssDir; ?>frontend.css">
</head>
<body>
    <div class="upper-bar">
        <div class="container">
            <?php if (isset($_SESSION['user'])) { ?>
                <div class="btn-group my-info">
                    <img src="img.jpg" class="rounded-circle img-thumbnail" alt="...">
                    <span class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
                        <?php echo $_SESSION['user']; ?>
                    <span class="caret"></span>
                    </span>
                    <ul class="dropdown-menu">
                        <li><a href="profile.php">My Profile</a></li>
                        <li><a href="newad.php">Create New Item</a></li>
                        <li><a href="profile.php#my-ads">My Items</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div>
                <?php
                $statusOfUser = checkUserStatus($_SESSION['user']);
                if ($statusOfUser == 1) {
                    echo '<div class="float-end">Your Membership need to active by admin</div>';
                }
                } else { ?>
                upper
                <a href="login.php">
                <span class="float-end"><strong>Login/Signup</strong></span>
                </a>
            <?php } ?>
        </div>
    </div>
<nav class="navbar bg-dark navbar-expand-lg bg-body-tertiary border-bottom border-body" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Home</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- 
            The .mx-auto class can be used to align the items to the center of the navbar.
            The .ms-auto class is used to align items to the right of the navbar.
            The .me-auto class is used to align items to the left of that navbar.
            -->
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <?php
                    $categories = getCats('WHERE parent = 0');
                    foreach ($categories as $cat) {
                        echo '<li class="nav-link"><a class="nav-link active" href="categories.php?pageid=' . $cat['ID'] .'">' . $cat['Name'] . '</a></li>';
                    }
                ?>
            </ul>
        </div>
    </div>
</nav>

