<html lang="fr">

	<head>
		<meta charset="UTF-8">
		<link href="style.css" rel="stylesheet">
	</head>
	
	<body class="index">
	
		<ul>
			<li><a href="mission.php">Ajout des missions</a></li>
			<li><a href="validation.php">Validation des missions</a></li>
			<li><a class="active" href="paiement.php">Paiement des frais</a></li>
			<li><a href="parametre.php">Paramétrage</a></li>
			<li class="deco"><a href="deconnexion.php">Déconnexion</a></li>
		</ul>
		<h1>PAIEMENT DES MISSIONS</h1>
		<?php
			session_start();
			if(!isset($_SESSION['utilisateur'])){
				header('Location: index.html');
			}
			else if($_SESSION['admin'] == 0){
				echo 'Vous n\'avez pas le droit d\'accéder à cette page';
				return;
			}
			echo '<table><tr style="font-weight: bold;"><td>Nom du Salarié</td><td>Prénom du Salarié</td><td>Début de la mission</td><td>Fin de la mission</td><td>Lieu de la mission</td><td>Montant</td><td>Paiement</td></tr>';

			$dbh = new PDO('mysql:host=localhost;dbname=epoka', 'root', '');

			if(isset($_GET['id'])){
				$id = $_GET['id'];
				$dbh->query('UPDATE epoka_missions SET paiement=1 WHERE idMission='.$id.';');
			}

			foreach($dbh->query('SELECT * FROM epoka_missions,epoka_users,ville WHERE epoka_missions.idUser=epoka_users.id AND epoka_missions.lieuMission=ville.id AND validation=1;') as $row){	
				echo '<tr>';
				echo '<td>'.$row['nom'].'</td>';
				echo '<td>'.$row['prenom'].'</td>';
				echo '<td>'.$row['dateDebut'].'</td>';
				echo '<td>'.$row['dateFin'].'</td>';
				echo '<td>'.$row['Vil_Nom'].'</td>';
				echo '<td>'.$row['remboursement'].' €</td>';
				if($row['paiement']!=NULL){
					echo '<td>Remboursée</td>';
				}else{
					echo '<td><a href="paiement.php?id='.$row['idMission'].'"><button>Rembourser</button></a></td>';
				}
				echo '</tr>';
			}
			
			echo '</table>';
		?>

	</body>
</html>