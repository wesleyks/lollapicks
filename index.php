<?php
require_once 'config.inc';
require_once 'lib/Twig/Autoloader.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array('autoescape'=>true));

$link = mysql_connect('localhost',$database['name'],$database['pass']);
mysql_select_db($database['db']);

$sql = "SELECT * FROM Requests ORDER BY request_count DESC LIMIT 0,10;";
$result = mysql_query($sql,$link);
$size = mysql_numrows($result);
$request_array = array();
for($i=0;$i<$size;$i++)
{
    array_push($request_array,array(mysql_result($result,$i,"song_title"),mysql_result($result,$i,"band_name"),mysql_result($result,$i,"request_count")));
}

mysql_close();
$vars = array(
              'requests' => $request_array
              );
$template = $twig->loadTemplate('index.phtml');
$template->display($vars);

?>
