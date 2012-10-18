<?php
/*$link = mysql_connect('localhost','root');
if($link){
    echo "connected!\n";
    $sql = 'CREATE DATABASE IF NOT EXISTS lolla_db';
    if (mysql_query($sql,$link)){
        echo "db created!\n";
    }
    mysql_select_db('lolla_db');
    $sql = "DROP TABLE Events;";
    if( mysql_query($sql,$link) ) echo "tables dropped";
    else echo mysql_error();
    $sql = "CREATE TABLE Events (
            id INTEGER,
            title VARCHAR(255) NOT NULL,
            bandid INTEGER NOT NULL,
            PRIMARY KEY(id)
            );";
    if( mysql_query($sql,$link) ) echo "tables created";
    else echo mysql_error();
    mysql_close($link);
}
else {
    echo "could not connect";
}*/
require_once 'config.inc';
$link = mysql_connect('localhost',$database['name'],$database['pass']);
mysql_select_db($database['db']);

$key = $_GET['key'];
if ($key == $database['seedkey']){
switch($_GET["table"])
{
    case "venues":
    $xml = simplexml_load_file('http://api.dostuffmedia.com/venues.xml?key='.$services['dostuff'].'&page=1');
    echo "venues<br/>";
    for($i=1;$i<=$xml->total_pages;$i++)
    {
        $xml = simplexml_load_file('http://api.dostuffmedia.com/venues.xml?key='.$services['dostuff'].'&page='.$i);
        foreach ($xml->venue as $child)
        {
            $sql = "INSERT INTO Venues (id,title,sort_order,latitude,longitude)
                    VALUES (" . $child->id . ",'".mysql_real_escape_string($child->title)."'," . $child->sort_order . "," . $child->latitude . "," . $child->longitude . ")";

            if(mysql_query($sql,$link)) echo $child->title . " inserted<br/>";
            else echo mysql_error() . "<br/>";
        }
    }
    break;

    case "bands":
    $xml = simplexml_load_file('http://api.dostuffmedia.com/bands.xml?key='.$services['dostuff'].'&page=1');
    echo "bands<br/>";
    for($i=1;$i<=$xml->total_pages;$i++)
    {
        $xml = simplexml_load_file('http://api.dostuffmedia.com/bands.xml?key='.$services['dostuff'].'&page='.$i);
        foreach ($xml->band as $child)
        {
            $sql = "INSERT INTO Bands (id,title,big_pic,small_pic,bio,fan_count)
                    VALUES (" . $child->id . ",
                    '".mysql_real_escape_string($child->title)."',
                    '".mysql_real_escape_string($child->photo_large)."',
                    '".mysql_real_escape_string($child->photo_thumb)."',
                    '".mysql_real_escape_string($child->description)."',
                    " . $child->fan_count . ")";
            if(mysql_query($sql,$link)) echo $child->title . " inserted<br/>";
            else echo mysql_error() . "<br/>";
        }
    }
    break;
    
    case "events":
    $xml = simplexml_load_file('http://api.dostuffmedia.com/events.xml?key='.$services['dostuff'].'&page=1');
    echo "events<br/>";
    for($i=1;$i<=$xml->total_pages;$i++)
    {
        $xml = simplexml_load_file('http://api.dostuffmedia.com/events.xml?key='.$services['dostuff'].'&page='.$i);
        foreach ($xml->event as $child)
        {
            $sql = "INSERT INTO Events (id,title,band_id,venue_id)
                    VALUES (" . $child->id . ",'".mysql_real_escape_string($child->title)."'," . $child->bands->band->id . "," . $child->venue->id . ")";
            if(mysql_query($sql,$link)) echo $child->title . " inserted<br/>";
            else echo mysql_error() . "<br/>";
        }
    }
    break;
}
mysql_close();
}
?>