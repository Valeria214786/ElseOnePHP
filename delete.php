<?php
if($_SERVER["REQUEST_METHOD"]=="POST") {
    include "connection_database.php";
    $sql = "DELETE FROM `news` WHERE `news`.`id` = ?";
    $sqlDeletePhoto = "SELECT `image` FROM `news` WHERE `news`.`id` = ?";
    //echo "zapros = ".$sqlDeletePhoto;
    if (isset($dbh)) {
        $basedir = '/images';
        $comand = $dbh->prepare($sqlDeletePhoto);
        $comand->execute([$_POST['id']]);
        $del = $comand->fetch();
        $path = $_SERVER['DOCUMENT_ROOT'] . $basedir."/" .$del['image'];
        unlink($path);

        $dbh->prepare($sql)->execute([$_POST['id']]);
        echo "id = " . $_POST['id'];
    }
}
?>