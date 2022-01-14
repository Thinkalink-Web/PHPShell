<?php

session_start();

// Loading configuration
require_once("config.php");

// Checking if PHPShell is enabled
if (PHPSHELL_ENABLED !== true) {
  die("PHPShell is not enabled. Please enable PHPShell and try again.");
}

if ($_SESSION["loggedin"] === true) {
  // User is signed in, show a shell
  SHOW_SHELL_HTML();
} else {
  // User is not signed in, show a login screen
  SHOW_LOGIN_HTML();
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
      <form method="post">
        <input type="password" name="data" placeholder="Password">
        <input type="button" name="btn" value="Sign in">
    </body>
  </html>
  <?php
}

// Thanks for using PHPShell!
