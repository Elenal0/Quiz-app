
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Quiz System'; ?></title>
    <link rel="stylesheet" href="<?php echo isset($cssPath) ? $cssPath : '../assets/styles.css'; ?>">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <a href="<?php echo isset($publicPath) ? $publicPath : './'; ?>index.php">QuizMaster</a>
            </div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="<?php echo isset($publicPath) ? $publicPath : './'; ?>index.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo isset($publicPath) ? $publicPath : './'; ?>about.php" class="nav-link">About</a>
                </li>
                <?php if (isLoggedIn()): ?>
                    <li class="nav-item">
                        <a href="<?php echo isset($publicPath) ? $publicPath : './'; ?>dashboard.php" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo isset($publicPath) ? $publicPath : './'; ?>profile.php" class="nav-link">Profile</a>
                    </li>
                    <?php if (isAdmin()): ?>
                        <li class="nav-item">
                            <a href="../admin/dashboard.php" class="nav-link admin-link">Admin</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a href="<?php echo isset($publicPath) ? $publicPath : './'; ?>logout.php" class="nav-link">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="<?php echo isset($publicPath) ? $publicPath : './'; ?>login.php" class="nav-link">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo isset($publicPath) ? $publicPath : './'; ?>register.php" class="nav-link">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
    </nav>
