<?php

// Is PHPShell enabled?
// If not true, PHPShell will not load
// If true, PHPShell will load
define("PHPSHELL_ENABLED", false);

// The password used to sign in to PHPShell
// Please change this password before enabling PHPShell
define("PHPSHELL_PASSWORD", password_hash("phpshell", PASSWORD_DEFAULT));

// Optional favicon for PHPShell
define("PHPSHELL_FAVICON", "");

// Thanks for using PHPShell!
