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
		<script>
			function naDrugiKorak() {
				window.location.assign("korak2.php?id=" + $("#klijent").val());
				//alert( $( "#klijent" ).val() );
			}
		</script>
	</head>
	<body>
		<div id="container">
			<div class="row">
				<div class="col-md-12">
					<h1><a href="/">Berza</a> - Korak 1</h1>
				</div>
				<div class="col-md-3">
					Odaberi Kupca
				</div>
				<div class="col-md-9">
					<?php
					require 'include/veza.php';
					try {
						$conn = DB_Instance::getDBO();
						$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$stmt = $conn -> query("SELECT * FROM `se201_klijent`");
						$stmt -> execute();
						$count = $stmt -> rowCount();
					} catch (PDOException $Exception) {
						printf("Poruka: <strong>%s</strong> <br> Kod Greške: <strong>%s</strong>", $Exception -> getMessage(), $Exception -> getCode());
					}
					echo "<select name='klijent' id='klijent' onchange='naDrugiKorak()'>";
					echo "<option value='--'> -- </option>";
					if ($count > 0) {
						while ($row = $stmt -> fetch()) {
							echo "<option value='$row[id]'>$row[id] - $row[ime] $row[prezime]</option>";
						}
					}
					echo "</select>";
					?>
				</div>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	</body>
</html>