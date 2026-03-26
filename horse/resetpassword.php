<?php

// Max: While the reset password page is only accessible via the button in .profile.php - it is not limited ...
// only to those who are logged in, anyone could access it simply by typing domain/resetpassword.php

include "dbconnect.php";

$message = "";
$toastClass = "";



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password_old = $_POST['password_old'];
    $password_new = $_POST['password_new'];
    $password_new_confirm = $_POST['password_new_confirm'];
    $salt = base64_encode(random_bytes(8));
    $passwordhash = crypt($password_new, '$5$' . $salt . '$'); // Encryption for passwords


    $stmt = $conn->prepare("SELECT password FROM userdata WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_password);
        $stmt->fetch();

        if (password_verify($password_old, $db_password)) {

            if ($password_new === $password_new_confirm) {
                $stmt2 = $conn->prepare("UPDATE userdata SET password = ? WHERE email = ?");
                $stmt2->bind_param("ss", $passwordhash, $email);

                        if ($stmt2->execute()) {
                             $message = "Password updated successfully";
                             $toastClass = "bg-success";
                        } else {
                             $message = "Error updating password";
                             $toastClass = "bg-danger";
                               }
            $stmt2->close();

            } else {
            $message = "New password does not match";
            $toastClass = "bg-danger";
                   }


    } else {
        $message = "Old password is incorrect";
        $toastClass = "bg-warning";
    }

  } else {
    $message = "No users found with this email";
    $toastClass = "bg-warning";
}


    $stmt->close();
    $conn->close();
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
    <link rel="stylesheet" href="assets/css/Header---Apple.css">
    <link rel="stylesheet" href="assets/css/Pretty-Footer-.css">
    <link rel="stylesheet" href="assets/css/Pretty-Header-.css">
</head>

<body>
    <div class="mt-5">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="container text-center">

                <?php if($message): ?>
                    <div class="alert <?php echo $toastClass; ?>"><?php echo $message; ?></div>
                <?php endif; ?>

                <div class="row mb-3">
                    <div class="col offset-0 m-auto">
                        <h3>Password Reset</h3>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col offset-0 m-auto"><input type="email" name="email" id="email" placeholder="Email" required></div>
                </div>
                <div class="row mb-2">
                    <div class="col offset-0 m-auto"><input type="password" name="password_old" id="password_old" placeholder="Old Password" required></div>
                </div>
                <div class="row mb-2">
                    <div class="col offset-0 m-auto"><input type="password" name="password_new" id="password_new" placeholder="New Password" required></div>
                </div>
                <div class="row mb-2">
                    <div class="col offset-0 m-auto"><input type="password" name="password_new_confirm" id="password_new_confirm" placeholder="Repeat New Password" required></div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                            <button class="btn btn-secondary" name="back" id="back" type="button" onclick="window.location.href='index.php'" >Back</button>
                            <button class="btn btn-primary" name="reset_password_submit" id="reset_password_submit" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
