# PHPShell
Tired of SSHing into your server just to run a basic command?

Or want to run a command from a device without SSH support, like an iPad?

PHPShell solves these problems by creating a GUI that allows you to run commands from a web browser.
# Installation
To install PHPShell, just copy the index.php and config.php files to your server.
# Configuration
After installation, edit the PHPSHELL_PASSWORD in the config.php file.

After you have changed the default password, change PHPSHELL_ENABLED to true to enable PHPShell.
# Done
You're all set!

Run the exit command to sign out.

1. Docs are coming soon!
2. Feel free to open a pull request.
3. Feel free to open an issue.
# Notes
-PHPShell runs as the user PHP runs as, which is usually an unprivileged user without sudo access.

-Certain commands like nano do not work because they require an actual Linux shell running.

-Every time you run another command, a new Linux shell starts. So, cd only works like this: cd /path && pwd.
