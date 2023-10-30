<?php
try{
    $link = new PDO("mysql:host=localhost;dbname=pr6", 'root', '');
}catch(PDOException $e){
    echo $e;
}
?>