<?php

// Max: The logout page. Kills the user session and annihilates the cookie files where the session is stored.

session_start();

$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

// Max: After the process is done - send the user to index.php

header("Location: index.php");

?>
