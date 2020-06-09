<?php
session_start();
$login = $_POST["login"];
$mdp = $_POST["motdepasse"];
$dbh = new PDO('mysql:host=localhost;dbname=epoka', 'root', '');
$flag = 0;

foreach($dbh->query('SELECT * FROM epoka_users WHERE nom="'.$login.'" AND pass="'.$mdp.'";') as $row){	
	$flag = 1;
	$_SESSION['utilisateur']=$login;
	$_SESSION['userid']=$row['id'];
	$_SESSION['resp']=$row['idResp'];
	$_SESSION['admin']=$row['admin'];
	header('Location: validation.php');
}
if($flag == 0){
	header('Location: index.html');
}
?>