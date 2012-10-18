<?php
require_once 'config.inc';
$link = mysql_connect('localhost',$database['name'],$database['pass']);
mysql_select_db($database['db']);


$artist = mysql_real_escape_string($_GET["artist"]);
$band_id = mysql_real_escape_string($_GET["id"]);
$title = mysql_real_escape_string($_GET["title"]);

$query = "http://developer.echonest.com/api/v4/song/search?api_key=".$services['echonest']."&format=xml&results=1&artist=".$artist."&title=".$title;
$xml = simplexml_load_file($query);
$song = $xml->songs->song;
if ($song) {
    $sql = "INSERT INTO Requests (event_tag, band_id, band_name, song_title, request_count)
            VALUES ('lolla12',".$band_id.",'$artist','$song->title',1)
            ON DUPLICATE KEY UPDATE request_count = request_count + 1;";
    
    if(mysql_query($sql,$link)) echo "0";
    else echo "2";
    mysql_close();
    }
else echo "1";

?>