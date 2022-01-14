<?php

session_start();

// Loading configuration
require_once("config.php");

// Checking if PHPShell is enabled
if (PHPSHELL_ENABLED !== true) {
  die("PHPShell is not enabled. Please enable PHPShell and try again.");
}

if ($_SESSION["PHPSHELL"] === true) {
  // User is signed in
  SHOW_SHELL_HTML();
} else {
  if (isset($_POST["btn"]) and isset($_POST["data"])) {
    // This is an API request to sign in
    $data = $_POST["data"];
    LOGIN_USER($data);
  } else {
    // User is not signed in
    SHOW_LOGIN_HTML();
  }
}

function LOGIN_USER($data) {
  if (empty($data)) {
    // User did not type a password
    // Give an error message
    header("Location: ".basename(__FILE__)."?error=emptyPassword");
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
      <form method="post">
        <input type="text" name="data" placeholder="Shell command">
        <input type="button" name="btn" value="Execute">
      </form>
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
      if ($error === "emptyPassword") {
        echo("<p>Please type a password</p>");
      }
      ?>
      <form method="post">
        <input type="password" name="data" placeholder="Password">
        <input type="button" name="btn" value="Sign in">
      </form>
    </body>
  </html>
  <?php
}

// Thanks for using PHPShell!
