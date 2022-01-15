<?php

// [PHPSHELL]

session_start();

// Loading configuration
require_once("config.php");

// Checking if PHPShell is enabled
if (PHPSHELL_ENABLED !== true) {
  die("PHPShell is not enabled. Please enable PHPShell and try again.");
}

if ($_SESSION["PHPSHELL"] === true) {
  if ($_GET["logout"] === "1") {
    // This is an API request to sign out
    session_unset();
    session_destroy();
  } elseif (isset($_POST["btn"]) and isset($_POST["data"])) {
    // This is an API request to execute a command
    $data = $_POST["data"];
    EXECUTE_COMMAND_API($data);
  } else {
    // User is signed in
    SHOW_SHELL_HTML();
  }
} else {
  if (isset($_POST["btn"]) and isset($_POST["data"])) {
    // This is an API request to sign in
    $data = $_POST["data"];
    LOGIN_USER_API($data);
  } else {
    // User is not signed in
    SHOW_LOGIN_HTML();
  }
}

// [FUNCTIONS]

function EXECUTE_COMMAND_API($data) {
  $output = shell_exec($data);
  if ($output === false) {
    // Error
    $output = "An error occurred";
  } elseif ($output === null) {
    // Maybe error?
    $output = "The program produced no output";
  }
}

function LOGIN_USER_API($data) {
  if (empty($data)) {
    // User did not type a password
    // Give an error message
    header("Location: ".basename(__FILE__)."?error=password");
    exit();
  }
  
  if (password_verify($data, PHPSHELL_PASSWORD)) {
    // Valid password
    $_SESSION["PHPSHELL"] = true;
    header("Location: ".basename(__FILE__));
    exit();
  } else {
    // Incorrect password
    header("Location: ".basename(__FILE__)."?error=password");
    exit();
  }
}

function SHOW_SHELL_HTML() {
  ?>
  <!DOCTYPE html>
  <html>
    <head>
      <title>PHPShell</title>
    </head>
    <body>
      <a href="?logout=1">Sign out</a>
      <form method="post">
        <input type="text" name="data" placeholder="Shell command">
        <input type="submit" name="btn" value="Execute">
      </form>
      <p>The program produced no output</p>
    </body>
  </html>
  <?php
}

function SHOW_LOGIN_HTML() {
  ?>
  <!DOCTYPE html>
  <html>
    <head>
      <title>PHPShell</title>
    </head>
    <body>
      <?php
      // Show error message
      $error = $_GET["error"];
      if ($error === "password") {
        echo("<p>Incorrect password</p>");
      }
      ?>
      <form method="post">
        <input type="password" name="data" placeholder="Password">
        <input type="submit" name="btn" value="Sign in">
      </form>
    </body>
  </html>
  <?php
}

// Thanks for using PHPShell!
