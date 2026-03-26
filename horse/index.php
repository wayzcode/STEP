<?php

// Max: Main page with information about the website.

include "dbconnect.php";

session_start();

// Max: Keeping thack of user's session, we need it to show or hide the logout button.
// In other words: The user will not see the logout button if they are not logged in and vice versa.

if (!isset($_SESSION['email'])) {
    $isloggedin = 0;
} else {
    $isloggedin = 1;
}

$email = $_SESSION['email'] ?? null;

// Max: Checking user's privileges in mysql database and assigning them on the web page.
// We will need it to hide or show the admin panel, the judge panel and strictly forbid access to the said pages.
// For example if you put domain/judge.php while being a regular user - you will be kicked out and sent to index.php

if ($email) {
    $stmt = $conn->prepare("SELECT isadmin FROM userdata WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $isadmin = ($result->num_rows > 0) ? $result->fetch_assoc()['isadmin'] : 0;
    $stmt->close();
} else {
    $isadmin = 0;
}

if ($email) {
    $stmt = $conn->prepare("SELECT isjudge FROM userdata WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $isjudge = ($result->num_rows > 0) ? $result->fetch_assoc()['isjudge'] : 0;
    $stmt->close();
} else {
    $isjudge = 0;
}

?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>S.T.E.P.</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/Header---Apple.css">
    <link rel="stylesheet" href="assets/css/Pretty-Footer-.css">
    <link rel="stylesheet" href="assets/css/Pretty-Header-.css">
</head>

<body>
    <div></div>
    <nav class="navbar navbar-expand-md fixed-top bg-dark navbar-dark">
        <div class="container"><button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav flex-grow-1 justify-content-between">
                    <li class="nav-item"><a class="nav-link" href="index.php"><i class="fas fa-horse-head apple-logo"></i></a></li>
                    <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="competitions.php">Competitions</a></li>
                    <li class="nav-item"><a class="nav-link" href="rules.php">Rules</a></li>
                 <?php if($isadmin == 1): ?>
                    <li class="nav-item"><a class="nav-link" onclick="window.location.href='admin.php'" style="color: rgb(255,106,106);">Admin Panel</a></li>
                <?php endif; ?>
                 <?php if($isadmin == 1 or $isjudge == 1): ?>
                    <li class="nav-item"><a class="nav-link" onclick="window.location.href='judge.php'" style="color: rgb(255,106,106);">Judge Panel</a></li>
                <?php endif; ?>
                 <?php if($isloggedin == 1): ?>
                    <li class="nav-item"><a class="nav-link" onclick="window.location.href='logout.php'" style="color: rgb(255,106,106);">Logout</a></li>
                <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
