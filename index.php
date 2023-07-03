<style>box-sizing: border-box;</style>
<style>div { max-width: 360px; padding-left: 10px; padding-right: 10px; padding-top: 5px; padding-bottom: 5px; margin: 10px; background-color: #F2F2F2; }</style>

<?php

/* kolla om man �r inloggad */
if (!isset($_COOKIE["calendar_loggedin"]))
{
	echo "<form method=\"POST\" action=\"index.php?login\"><input type=\"password\" name=\"login\"> <input type=\"submit\" text=\"button\"></form>";
	if (isset($_GET["login"])) { if ($_POST["login"] == "password") { setcookie("calendar_loggedin", "calendar_loggedin", time()+60*60*24*30); } }
}
else
{

if (isset($_GET["logout"])) setcookie("calendar_loggedin", '', time()-3000);
if (isset($_GET["add"]))
{
	$data = file_get_contents("data.txt");
	if (strpos($data, str_replace(";","",$_GET["date"]) . ";" . str_replace(";","",$_GET["text"])) === false)
	{
		file_put_contents("data.txt", $data . str_replace(";","",$_GET["date"]) . ";" . str_replace(";","",$_GET["text"]) . "\n");
	}
}
if (isset($_GET["del"])) file_put_contents("data.txt", str_replace($_GET["data"], str_replace("-","!",$_GET["data"]), file_get_contents("data.txt")));

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\">";
echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">";

/* layout */
echo "<head><title>calendar</title><style>";
echo "* { box-sizing: border-box; }";
echo ".column {";
echo "float: left;";
echo "width: 100%;";
echo "padding: 10px; }";
echo "</style></head>";

echo "<body style=\"margin: 0 auto !important; float: none !important;\">";

if (isset($_GET["m"])) $month = $_GET["m"];
else $month = date("m");

/* m�nadsl�nkar */
echo "<div class=\"column\"><p><i>click on a post to remove it<br><a href=\"data.txt\">history</a></i></p><p><a href=\"?m=01\">jan</a> - <a href=\"?m=02\">feb</a> - <a href=\"?m=03\">mar</a> - <a href=\"?m=04\">apr</a> - <a href=\"?m=05\">may</a> - <a href=\"?m=06\">jun</a> - <a href=\"?m=07\">jul</a> - <a href=\"?m=08\">aug</a> - <a href=\"?m=09\">sep</a> - <a href=\"?m=10\">oct</a> - <a href=\"?m=11\">nov</a> - <a href=\"?m=12\">dec</a></p>";
echo "<p><b>";
echo "</b></p></div>";

/* alla datum */
$data = file_get_contents("data.txt");
$i = 1;
echo "<div class=\"column\">";
while ($i <= 31)
{
	// veckodag
	if (date("l", strtotime(date("Y") . "-" . $month . "-" . $i)) == "Monday") echo "</div><div class=\"column\">";

	echo "<form action=\"index.php\" method=\"GET\">";
	if ($i == date("d")) echo "<b>";
	echo $i . ". (" . strtolower(substr(date("l", strtotime(date("Y") . "-" . $month . "-" . $i)), 0, 3)) . ")";
	echo " <input type=\"textbox\" name=\"text\"><input type=\"hidden\" name=\"date\" value=\"" . date("Y") . "-" . $month . "-" . $i . "\"><input type=\"hidden\" name=\"m\" value=" . $month . "><input type=\"hidden\" name=\"add\"><input type=\"submit\"> ";

	echo "<br>";

	// h�mta alla p�mminelsetexter fr�n denna dag
	$a = explode(date("Y") . "-" . $month . "-" . $i . ";", $data);
	for ($ii = 1; $ii < count($a); $ii++)
	{
		$b = explode("\n", $a[$ii]);
		echo "* <a target=_blank href=\"index.php?m=" . $month . "&del&data=" . date("Y") . "-" . $month . "-" . $i . ";" . $b[0] . "\">" . $b[0] . "</a><br>";
	}
	
	if ($i == date("d")) echo "</b>";
	echo "</form>";
	$i++;
}
echo "</div>";

}

?>
