# calendar

Super simple calendar web "app" (= web site) for you who have your own web server with PHP on it.

HOW TO USE IT:
1. Have your own web server with PHP installed on it. If you have this, I assume you know how to set up a website too.
2. Create the file data.txt in the same directory as index.php. This is where all the data is stored. Make it able to write to (in Linux: chmod 777 data.txt, chown www-data data.txt).
4. Set your own password in index.php (if ($_POST["login"] == "password").

BUGS: as of 230703, you need to refresh the site again after having logged in, to actually log in (actually, you are logged in but you don't see the site yet).

/kbrecordzz
