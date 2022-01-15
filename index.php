<?php

// [PHPSHELL]

// Starting session
session_start();

// Loading configuration
require_once("config.php");

// Checking if PHPShell is enabled
// And throwing an error if not enabled
if (PHPSHELL_ENABLED !== true) {
  die("PHPShell is not enabled. Please enable PHPShell and try again.");
}

if ($_SESSION["PHPSHELL"] === true) {
  // The user is logged in
  if (isset($_POST["btn"]) and isset($_POST["data"])) {
    // This is an API request to execute a command
    $data = $_POST["data"];
    EXECUTE_COMMAND_API($data);
  } else {
    // Not an API request, show HTML
    SHOW_SHELL_HTML();
  }
} else {
  // The user is not logged in
  if (isset($_POST["btn"]) and isset($_POST["data"])) {
    // This is an API request to sign in
    $data = $_POST["data"];
    LOGIN_USER_API($data);
  } else {
    // Not an API request, show HTML
    SHOW_LOGIN_HTML();
  }
}

// [FUNCTIONS]

function EXECUTE_COMMAND_API($data) {
  // Execute command
  
  if ($data === "exit") {
    // If the user runs exit,
    // Sign them out
    LOGOUT_USER_API();
  }
  
  $output = shell_exec($data);
  if ($output === false) {
    // Error establishing pipe connection
    $output = "An error occurred";
  } elseif ($output === null) {
    // Maybe error?
    $output = "The program produced no output";
  }
  
  // URL-encode output
  $urlOutput = urlencode($output);
  
  // Redirecting the user with output
  header("Location: ".basename(__FILE__)."?output=".$urlOutput);
  exit();
}

function LOGOUT_USER_API() {
  // Signing out a user
  session_unset();
  session_destroy();
  
  // Redirecting the user
  header("Location: ".basename(__FILE__));
  exit();
}

function LOGIN_USER_API($data) {
  if (empty($data)) {
    // User did not type a password
    // Redirect user with error message
    header("Location: ".basename(__FILE__)."?error=password");
    exit();
  }
  
  if (password_verify($data, PHPSHELL_PASSWORD)) {
    // Valid password
    $_SESSION["PHPSHELL"] = true;
    
    // Redirecting the user
    header("Location: ".basename(__FILE__));
    exit();
  } else {
    // Invalid password;
    // Redirect user with error message
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
      <form method="post">
        <input type="text" name="data" placeholder="Shell command">
        <input type="submit" name="btn" value="Execute">
      </form>
      <p id="output">The program produced no output</p>
      <script>
        var objUrlParams = new URLSearchParams(window.location.search);
        document.getElementById('output').innerHTML = objUrlParams.get('output');
      </script>
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
