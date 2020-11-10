<?php
    session_start();
    require_once("config.php"); // get server

    $Email = $_POST["Email"]; // get email
    $Password = hash('sha256', ($_POST["Password"])); // get encrypted password

    $con = mysqli_connect(SERVER, USER, PASSWORD, DATABASE); // connect to db

    if (!$con) { // failed to connect to db
        $_SESSION["Message"] = "<code>Database can not connect.(".mysqli_error($con).")</code>";
        $_SESSION["refresh"] = 0;
        header("location:../../index.php");
        exit();
    }

    $query = "SELECT * FROM User WHERE Password='$Password' AND Email='$Email';";
    $result = mysqli_query($con, $query);

    if (!$result) {
        $_SESSION["Message"] = "<code>Query failed.(".mysqli_error($con)."</code>";
        $_SESSION["refresh"] = 0;
        header("location:../../index.php");
        exit();
    }

    if (mysqli_num_rows($result) != 1) {
        $_SESSION["Message"] = "<code>The email or password is incorrect</code>";
        $_SESSION["refresh"] = 0;
        header("location:../../index.php");
        exit();
    }

    $_SESSION["Email"] = $Email;
    $_SESSION["regState"] = 4;
    $_SESSION["Message"] = "";
    $_SESSION["refresh"] = 0;
    header("location:../../home.php");
    exit();
?>