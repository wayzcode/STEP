<?php

// Max: The rules page. The guide to fair "fighting" and evaluation.

// Honorable mention: If fighting is sure to result in victory, then you must fight!
// Sun Tzu said that, and I’d say he knows a little more about fighting than you do pal, because he invented it.
// And then he perfected it so that no living man could best him in the ring of honor!

include "dbconnect.php";

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'] ?? null;

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
                    <li class="nav-item"><a class="nav-link" href="rules.php" style="color: var(--bs-primary);">Rules</a></li>
                 <?php if($isadmin == 1): ?>
                    <li class="nav-item"><a class="nav-link" onclick="window.location.href='admin.php'" style="color: rgb(255,106,106);">Admin Panel</a></li>
                <?php endif; ?>
                 <?php if($isadmin == 1 or $isjudge == 1): ?>
                    <li class="nav-item"><a class="nav-link" onclick="window.location.href='judge.php'" style="color: rgb(255,106,106);">Judge Panel</a></li>
                <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" onclick="window.location.href='logout.php'" style="color: rgb(255,106,106);">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

<body>
    <div class="mt-5">
            <div class="container text-center">
                <div class="row mb-3">
                    <div class="col offset-0 m-auto">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                            <button type="button" href="rules-participation.php" >Participating in the competitions</button>
                            <button type="button" href="rules-judgement.php" >Judging competitions</button>
                            <button type="button" href="rules-appointment.php" >Appointing the evaluators</button>
                        </div>
                    </div>
                </div>
           </div>
        </form>
        </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
