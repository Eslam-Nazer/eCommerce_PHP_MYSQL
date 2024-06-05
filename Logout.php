<?php

    // Initialize the session.
    session_start(); // Start The Session

    session_unset(); // Unset The Data

    // If it's desired to kill the session, also delete the session cookie.
    // Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    session_destroy(); // Destroy The Sessoion

    header('Location: index.php');

    exit();
