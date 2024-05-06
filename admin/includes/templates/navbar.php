<nav class="navbar navbar-expand-lg bg-dark border-bottom border-body" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarSupportedContent">

        <ul class="navbar-nav col-md-4 mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link " aria-current="page" href="#"><?php echo language('ADMIN_HOME'); ?></a>
            </li>
        </ul>
        
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="categories.php"><?php echo language('CATEGORIES'); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="items.php"><?php echo language('ITEMS'); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="members.php"><?php echo language('MEMBERS'); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="comments.php"><?php echo language('COMMENTS'); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#"><?php echo language('STATISTICS'); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#"><?php echo language('LOGS'); ?></a>
            </li>
        <!-- Dropdown -->
        <div class="collapse navbar-collapse dr-menu" id="nav-app">
        <i class="fa-solid fa-user-tie fa-lg dr-menu-icon" style="color:wheat; padding-right: 5px;"></i>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo $_SESSION['Username'] ; ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a class="dropdown-item" href="members.php?do=Edit&userid=<?php echo $_SESSION['ID']; ?>">Edit Profile</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item" href="../index.php">Visit Shop</a></li>
                    <li><a class="dropdown-item" href="Logout.php">Logout</a></li>
                </ul>
                </li>
            </ul>
        </div>
        </ul>

        </div>
    </div>
</nav>