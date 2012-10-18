<?php
require_once 'config.inc';
require_once 'lib/Twig/Autoloader.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array('autoescape'=>true));


$link = mysql_connect('localhost',$database['name'],$database['pass']);
mysql_select_db($database['db']);

$band_id = mysql_real_escape_string($_GET["id"]);
$sql = "SELECT * FROM Bands WHERE id=".$band_id.";";
$result = mysql_query($sql,$link);

$sql = "SELECT song_title, request_count FROM Requests WHERE band_id=".$band_id." ORDER BY request_count DESC;";
$result2 = mysql_query($sql,$link);
$size = mysql_numrows($result2);
$request_array = array();
for($i=0;$i<$size;$i++)
{
    array_push($request_array,array(mysql_result($result2,$i,"song_title"),mysql_result($result2,$i,"request_count")));
}

mysql_close();
$vars = array(
              'title' => mysql_result($result,0,"title"),
              'image_link' => mysql_result($result,0,"small_pic"),
              'id' => mysql_result($result,0,"id"),
              'requests' => $request_array
              );
$template = $twig->loadTemplate('artist.phtml');
$template->display($vars);

?>