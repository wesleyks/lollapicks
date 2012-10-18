<?php
require_once 'config.inc';
require_once 'lib/Twig/Autoloader.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array('autoescape'=>false));

$artist = urlencode($_GET['artist']);
$id = urlencode($_GET['id']);
$title = urlencode($_GET['title']);

$query = "http://developer.echonest.com/api/v4/song/search?api_key=".$services['echonest']."&format=xml&results=10&artist=".$artist."&title=".$title;
$xml = simplexml_load_file($query);
$songs = array();
foreach ($xml->songs->song as $song)
{
    array_push($songs,$song->title);
}
$songs = array_unique($songs);
$vars = array(
              'songs' => $songs,
              'artist' => $_GET['artist'],
              'id' => $id,
              'title' => $title
              );
$template = $twig->loadTemplate('search.phtml');
$template->display($vars);

?>