<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="projekni zadatak iz se201">
		<meta name="author" content="Nikola">
		<title>Berza :: Profit Klijenata</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
		<!-- moji CSS stilovi -->
		<link href="css/stil.css" rel="stylesheet">
	</head>
	<body>
		<div id="container">
			<div class="row">
				<div class="col-md-12">
					<h1> <a href="/">Berza</a> </h1>
					<h3>Profit klijenata</h3>
				</div>
				<div class="col-md-12">
					<?php
					require 'include/veza.php';
					try {
						$conn = DB_Instance::getDBO();
						$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$stmt = $conn -> query("SELECT klijent_id, ime, prezime, p.brojAkcija, p.imeFirme, p.brojAkcija*c.cena as profit FROM se201_portfolio p JOIN se201_cenaPoAkciji c ON p.imeFirme = c.imeFirme JOIN se201_klijent k ON k.id = klijent_id ");
						$stmt -> execute();
						$count = $stmt -> rowCount();
					} catch (PDOException $Exception) {
						printf("Poruka: <strong>%s</strong> <br> Kod Greške: <strong>%s</strong>", $Exception -> getMessage(), $Exception -> getCode());
					}
					if ($count > 0) {
						echo "<table border='1'>";
						echo "<tr> <th>ID klijenta</th> <th>Ime</th> <th>Prezime</th> <th>Broj Akcija</th>  <th>Ime Firme</th> <th>Profit</th> </tr>";
						while ($row = $stmt -> fetch()) {
							echo "<tr> 
							<td>$row[klijent_id]</td>
							<td>$row[ime]</td>
							<td>$row[prezime]</td>
							<td>$row[brojAkcija]</td>
							<td>$row[imeFirme]</td>
							<td>$row[profit]</td>							
							</tr>";
						}
						echo "</table>";
					}
					?>
				</div>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	</body>
</html>