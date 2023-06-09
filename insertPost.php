<?php
session_start();
/**
 * Inserts a new article into the database with the given parameters.
 */
include 'lib/dbConnect.php';
$bd = new DbConnect();
$conn = $bd->connect();

$titre = $_POST['titre'];
$img = $_FILES["image"]["name"];
$repImg = 'images/';
$cate = $_POST['cate'];
$contenu = $_POST['article'];
$user = $_SESSION["User"];

$sql = "INSERT INTO article VALUES (NULL, :titre,:contenu,NOW(), :img,:cate,:user,0)";
$req = $conn->prepare($sql);
$req->bindParam(':titre', $titre);
$req->bindParam(':contenu', $contenu);
$req->bindParam(':img', $img);
$req->bindParam(':cate', $cate);
$req->bindParam(':user', $user);
if ($req->execute()) {
    move_uploaded_file($_FILES['image']['tmp_name'], $repImg . $img);
    header("Location: index.php");
} else {
    header("Location: createPost.php?erreur=TRUE");
}
?>