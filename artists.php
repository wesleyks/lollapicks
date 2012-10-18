<?php
require_once 'config.inc';
require_once 'lib/Twig/Autoloader.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array('autoescape'=>false));

$sql = "SELECT id, title FROM Bands ORDER BY title;";

$link = mysql_connect('localhost',$database['name'],$database['pass']);
mysql_select_db($database['db']);

$results = mysql_query($sql,$link);
mysql_close();
$size = mysql_numrows($results);
$letter = null;
$artist_array = array();
for($i=0;$i<$size;$i++)
{
    $title = mysql_result($results,$i,"title");
    $id = mysql_result($results,$i,"id");
    if(strtolower($letter) != strtolower($title[0]))
    {
        if($letter!=null) array_push($artist_array,"</ul></p></div>");
        $letter = $title[0];
        array_push($artist_array,"<div data-role='collapsible' data-theme='b'>
                   <h3>".$letter."</h3>
                   <p><ul data-role='listview'>");
        //array_push($artist_array,$letter);
    }
    array_push($artist_array,"<li><a href='artist.php?id=".$id."' data-transition='slide'>".$title."</a></li>");
}
array_push($artist_array,"</ul></p></div>");
$vars = array(
              'artist_array' => $artist_array
              );
$template = $twig->loadTemplate('artists.phtml');
$template->display($vars);

?>