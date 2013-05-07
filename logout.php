<?php

    // Remove users session
    session_start();
    session_destroy();

    // Redirect to the main page
    header("Location: index.php");
    exit;