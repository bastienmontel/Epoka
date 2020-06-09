<!doctype html>
<html lang="fr">

	<head>
		<meta charset="UTF-8">
		<link href="style.css" rel="stylesheet">
	</head>
	
	<body class="index">
		<ul>
			<li><a class="active" href="mission.php">Ajout des missions</a></li>
			<li><a href="validation.php">Validation des missions</a></li>
			<li><a href="paiement.php">Paiement des frais</a></li>
			<li><a href="parametre.php">Paramétrage</a></li>
			<li class="deco"><a href="deconnexion.php">Déconnexion</a></li>
		</ul>
		<h1>Ajout d'une mission</h1>
		<?php	
			session_start();
			if(!isset($_SESSION['utilisateur'])){
				header('Location: index.html');
			}
			else if($_SESSION['admin'] != 0 or $_SESSION['resp'] != NULL){
				echo 'Vous n\'avez pas le droit d\'accéder à cette page';
				return;
			}
			if(isset($_POST['deb'])){
				$dbh = new PDO('mysql:host=localhost;dbname=epoka', 'root', '');
				$dbh->query('INSERT INTO `epoka_missions`(`dateDebut`, `dateFin`, `lieuMission`, `idUser`, `remboursement`) VALUES ("'.$_POST['deb'].'","'.$_POST['fin'].'",'.$_POST['lieu'].','.$_SESSION['userid'].',0);');
			}
		?>		
		<form action="mission.php" method="POST">
			Date de début : <input type="date" name="deb">
			<br>
			Date de fin : <input type="date" name="fin">
			<br>
			Lieu de la mission : 
			<select name="lieu">
			<?php
			$dbh = new PDO('mysql:host=localhost;dbname=epoka', 'root', '');
			foreach($dbh->query('SELECT * FROM Ville ORDER BY Vil_Nom;') as $row){	
				echo '<option value="'.$row['id'].'">'.$row['Vil_Nom'].'</option>';
			}
			?>
			</select>
			<br>
			<input type="submit" value="Ajouter">
		</form>
	</body>
</html>