<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="projekni zadatak iz se201">
		<meta name="author" content="Nikola">
		<title>Berza</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
		<!-- moji CSS stilovi -->
		<link href="css/stil.css" rel="stylesheet">
	</head>
	<body>
		<div id="container">
			<div class="row">
				<div class="col-md-12">
					<h1><a href="/">Berza</a> - Korak 2</h1>
				</div>
				<div class="col-md-3">
					Odaberi Prodavca
				</div>
				<div class="col-md-9">
					<?php
					$id = (int)$_GET['id'];
					$_SESSION['kupac_id'] = $id;
					//var_dump($_SESSION['kupac_id']);
					require 'include/veza.php';
					try {
						$conn = DB_Instance::getDBO();
						$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$stmt = $conn -> query("SELECT k.id as kid, ime, prezime, imeFirme, brojAkcija FROM `se201_klijent` k JOIN `se201_portfolio` p ON k.id = p.klijent_id  WHERE k.id != $id");
						$stmt -> execute();
						$count = $stmt -> rowCount();
					} catch (PDOException $Exception) {
						printf("Poruka: <strong>%s</strong> <br> Kod Greške: <strong>%s</strong>", $Exception -> getMessage(), $Exception -> getCode());
					}
					$b = 0;
					if ($count > 0) {
						echo "<table border='1'>";
						echo "<tr> <th>id</th> <th>ime i prezime</th> <th>Ime Firme</th>  <th>Broj Akcija</th> </tr>";
						while ($row = $stmt -> fetch()) {
							++$b;
							echo "<tr id='red$b'>  
					           		<td>$row[kid]</td>  
					           		<td>$row[ime] $row[prezime]</td>  
					           		<td>$row[imeFirme]</td> 
					           		<td> <input id='in$b' type='number' name='$row[imeFirme]'  value='$row[brojAkcija]' min='0'> </td>
					           		<td> <a href='#'> Kreni </a> </td> 
				           		</tr>";
						}
						echo "</table>";
					}
					?>
				</div>
				<div class="col-md-12">
					<h1>Portfolio za
					<?php
					try {
						$conn = DB_Instance::getDBO();
						$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$stmt = $conn -> query("SELECT * FROM `se201_klijent` WHERE id = " . $id . " LIMIT 1");
						$stmt -> execute();
						$count = $stmt -> rowCount();
					} catch (PDOException $Exception) {
						printf("Poruka: <strong>%s</strong> <br> Kod Greške: <strong>%s</strong>", $Exception -> getMessage(), $Exception -> getCode());
					}
					if ($count > 0) {
						while ($row = $stmt -> fetch()) {
							echo "$row[id] - $row[ime] $row[prezime] </h1>";
						}
					}
					?>
				</div>
				<div id="rez" class="col-md-12">
					<?php
					try {
						$conn = DB_Instance::getDBO();
						$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$stmt = $conn -> query("SELECT * FROM se201_portfolio WHERE klijent_id = " . $_SESSION['kupac_id']);
						$stmt -> execute();
						$count = $stmt -> rowCount();
					} catch (PDOException $Exception) {
						printf("Poruka: <strong>%s</strong> <br> Kod Greške: <strong>%s</strong>", $Exception -> getMessage(), $Exception -> getCode());
					}

					if ($count == 0) {
						echo "Kupac nema nikakve akcije";
					} else {
						echo "<table border='1'>";
						echo "<tr>  <th>Ime Firme</th>  <th>Broj Akcija</th> </tr>";
						while ($row = $stmt -> fetch()) {
							++$b;
							echo "<tr id='red$b'> 
					           		<td>$row[imeFirme]</td> 
					           		<td><input type='text' value='$row[brojAkcija]' disabled='disabled'></td> 
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
		<script>
			$(document).ready(function() {
				$("a").click(function(event) {
					var koren = $(this).parent().parent();
					var id = koren.find('td:eq(0)').html();
					var firma = koren.find('td:eq(2)').html();
					var brAkcija = koren.find('input').val();
					//var in = '#in'+event.target.id;
					//$(in).attr('max') = $(in).val();
					// alert(event.target.id);
					// alert(id + firma + brAkcija);

					$.post("obradiAJAX.php", {
						id : id,
						firma : firma,
						brAkcija : brAkcija
					}).done(function(data) {
						// alert("Data Loaded: " + data);
						$('#rez').html(data);
					});
				});
			});
		</script>
	</body>
</html>