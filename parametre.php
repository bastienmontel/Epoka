<!doctype html>
<html lang="fr">

	<head>
		<meta charset="UTF-8">
		<link href="style.css" rel="stylesheet">
	</head>
	
	<body class="index">
		<ul>
			<li><a href="mission.php">Ajout des missions</a></li>
			<li><a href="validation.php">Validation des missions</a></li>
			<li><a href="paiement.php">Paiement des frais</a></li>
			<li><a class="active" href="parametre.php">Paramétrage</a></li>
			<li class="deco"><a href="deconnexion.php">Déconnexion</a></li>
		</ul>
		<h1>Paramétrage de l'application</h1>
		<?php	
			session_start();
			if(!isset($_SESSION['utilisateur'])){
				header('Location: index.html');
			}
			else if($_SESSION['admin'] == 0){
				echo 'Vous n\'avez pas le droit d\'accéder à cette page';
				return;
			}
			$dbh = new PDO('mysql:host=localhost;dbname=epoka', 'root', '');
			if(isset($_POST["rembkm"]) && isset($_POST["rembheb"])){
				$rembkm = $_POST["rembkm"];
				$rembheb = $_POST["rembheb"];
				$dbh->query('UPDATE epoka_params SET prixKM='.$rembkm.', prixHebergement='.$rembheb.' WHERE id=1;');
			}
			if(isset($_POST["from"]) && isset($_POST["to"]) && isset($_POST["distance"])){
				$from = $_POST["from"];
				$to = $_POST["to"];
				$distance = $_POST["distance"];
				$dbh->query('INSERT INTO `epoka_distances`(`ville1`, `ville2`, `distance`) VALUES ('.$from.','.$to.','.$distance.')');
			}
			foreach($dbh->query('SELECT * FROM epoka_params;') as $row){	
				$rembkm=$row['prixKM'];
				$rembheb=$row['prixHebergement'];
			}
		?>
		<h2>Montant du remboursement au km</h2>
		<form action="parametre.php" method="POST">
			Remboursement au km : <input type="text" name="rembkm" value="<?php echo $rembkm ?>">
			<br>
			Indémnité d'hébergement : <input type="text" name="rembheb" value="<?php echo $rembheb ?>">
			<br>
			<input type="submit" value="Valider">
		</form>
		<h1>Distance entre villes</h1>
		<form action="parametre.php" method="POST">
		
			De : 
			
			<select name="from">
				<?php
					$dbh = new PDO('mysql:host=localhost;dbname=epoka', 'root', '');
					$liste=$dbh->query('SELECT * FROM Ville ORDER BY Vil_Nom;');
					foreach($liste as $row){	
						echo '<option value="'.$row['id'].'">'.$row['Vil_Nom'].'</option>';
					}
					echo '</select> à : <select name="to">';
					$liste=$dbh->query('SELECT * FROM Ville ORDER BY Vil_Nom;');
					foreach($liste as $row){	
						echo '<option value="'.$row['id'].'">'.$row['Vil_Nom'].'</option>';
					}
				?>
			</select>
			
			Distance en km : <input type="text" name="distance">
			
			<br>
			<input type="submit" value="Valider">
		</form>
		<h1>Distance entre villes déjà saisies</h1>
		<table><tr style="font-weight: bold;"><td>De</td><td>à</td><td>Km</td></tr>
		<?php
			$i=0;
			$dbh = new PDO('mysql:host=localhost;dbname=epoka', 'root', '');
			foreach($dbh->query('SELECT * FROM epoka_distances,Ville WHERE ville1=Ville.id OR ville2=Ville.id;') as $row){
				if($i==0){
					echo '<tr>';
				}
				echo '<td>'.$row['Vil_Nom'].'</td>';
				$i++;
				if($i==2){
					echo '<td>'.$row['distance'].'</td></tr>';
					$i=0;
				}
			}
		?>
		</table>
	</body>
</html>