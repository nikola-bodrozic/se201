<?php
session_start();
$klijent_id = $_POST["id"];
$firma = $_POST["firma"];
$brAkcija = $_POST["brAkcija"];
$ba = 0;
require 'include/veza.php';

// Provera broja akcija - da li je broj akcija ispravan
// Ne mozete preneti više akcija nego što ih prodavac ima
try {
	$conn = DB_Instance::getDBO();
	$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$q = $conn -> prepare("SELECT brojAkcija FROM `se201_portfolio` WHERE `klijent_id`= :klijent_id AND `imeFirme`=:imeFirme");
	$q -> execute(array(':klijent_id' => $klijent_id, ':imeFirme' => $firma));
} catch (PDOException $Exception) {
	printf("Poruka: <strong>%s</strong> <br> Kod Greške: <strong>%s</strong>", $Exception -> getMessage(), $Exception -> getCode());
}
while ($row = $q -> fetch()) {
	$x = $row[brojAkcija] - $brAkcija;
	if($x >= 0)	{
		echo "<div class=\"alert alert-success\" role=\"alert\">Preneto je " . $x . " akcija</div>";
	} else {
		echo "<div class=\"alert alert-danger\" role=\"alert\">Ne mozete preneti više akcija nego što ih prodavac ima!</div>";
		// prikaz akcija - kandidat za include
		try {
			$conn = DB_Instance::getDBO();
			$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$q = $conn -> prepare("SELECT imeFirme, brojAkcija FROM `se201_portfolio` WHERE `klijent_id`= :klijent_id");
			$q -> execute(array(':klijent_id' => $_SESSION['kupac_id']));
		} catch (PDOException $Exception) {
			printf("Poruka: <strong>%s</strong> <br> Kod Greške: <strong>%s</strong>", $Exception -> getMessage(), $Exception -> getCode());
		}
		echo "<table border='1'>";
		echo "<tr> <th>Ime Firme</th> <th>Broj Akcija</th>    </tr>";
		while ($row = $q -> fetch()) {
			echo "<tr> <td>$row[imeFirme]</td> <td><input type='text' value='$row[brojAkcija]' disabled='disabled'></td> </tr>";
		}
		echo "</table>";		
		die();
	}

}

try {
	$conn = DB_Instance::getDBO();
	$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $conn -> query("SELECT * FROM  se201_portfolio WHERE '$firma' = `imefirme` AND klijent_id = " . $_SESSION['kupac_id']);
	$stmt -> execute();
	$count = $stmt -> rowCount();
} catch (PDOException $Exception) {
	printf("Poruka: <strong>%s</strong> <br> Kod Greške: <strong>%s</strong>", $Exception -> getMessage(), $Exception -> getCode());
}

if ($count == 0) {
	try {
		$conn = DB_Instance::getDBO();
		$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn -> prepare("SELECT brojAkcija FROM `se201_portfolio` WHERE `klijent_id`= :klijent_id AND `imeFirme`=:imeFirme");
		$q -> execute(array(':klijent_id' => $klijent_id, ':imeFirme' => $firma));
	} catch (PDOException $Exception) {
		printf("Poruka: <strong>%s</strong> <br> Kod Greške: <strong>%s</strong>", $Exception -> getMessage(), $Exception -> getCode());
	}
	while ($row = $q -> fetch()) {
		$ba = $row[brojAkcija] - $brAkcija;

		// skidanje akcija prodavcu
		$conn = DB_Instance::getDBO();
		$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn -> prepare("UPDATE `se201_portfolio` SET brojAkcija = $brAkcija WHERE `klijent_id`= :klijent_id AND `imeFirme`=:imeFirme");
		$q -> execute(array(':klijent_id' => $klijent_id, ':imeFirme' => $firma));

		// dodavanje akcija kupcu
		$conn = DB_Instance::getDBO();
		$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn -> prepare("INSERT INTO `se201_portfolio`(`id`, `klijent_id`, `imeFirme`, `brojAkcija`) VALUES (NULL, :klijent_id, :imeFirme, $ba)");
		$q -> execute(array(':klijent_id' => $_SESSION['kupac_id'], ':imeFirme' => $firma));

		// prikaz akcija - kandidat za include
		try {
			$conn = DB_Instance::getDBO();
			$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$q = $conn -> prepare("SELECT imeFirme, brojAkcija FROM `se201_portfolio` WHERE `klijent_id`= :klijent_id");
			$q -> execute(array(':klijent_id' => $_SESSION['kupac_id']));
		} catch (PDOException $Exception) {
			printf("Poruka: <strong>%s</strong> <br> Kod Greške: <strong>%s</strong>", $Exception -> getMessage(), $Exception -> getCode());
		}
		echo "<table border='1'>";
		echo "<tr> <th>Ime Firme</th> <th>Broj Akcija</th>    </tr>";
		while ($row = $q -> fetch()) {
			echo "<tr> <td>$row[imeFirme]</td> <td><input type='text' value='$row[brojAkcija]' disabled='disabled'></td> </tr>";
		}
		echo "</table>";
	}
} else {
	$conn = DB_Instance::getDBO();
	$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$q = $conn -> prepare("SELECT brojAkcija FROM `se201_portfolio` WHERE `klijent_id`= :klijent_id AND `imeFirme`=:imeFirme");
	$q -> execute(array(':klijent_id' => $klijent_id, ':imeFirme' => $firma));
	while ($row = $q -> fetch()) {
		$ba2 = $row[brojAkcija] - $brAkcija;
	}

	// skidanje akcija prodavcu
	$conn = DB_Instance::getDBO();
	$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$q = $conn -> prepare("UPDATE `se201_portfolio` SET brojAkcija = $brAkcija WHERE `klijent_id`= :klijent_id AND `imeFirme`=:imeFirme");
	$q -> execute(array(':klijent_id' => $klijent_id, ':imeFirme' => $firma));

	
	$conn = DB_Instance::getDBO();
	$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$q = $conn -> prepare("SELECT brojAkcija FROM `se201_portfolio` WHERE `klijent_id`= :klijent_id AND `imeFirme`=:imeFirme");
	$q -> execute(array(':klijent_id' => $_SESSION['kupac_id'], ':imeFirme' => $firma));
	while ($row = $q -> fetch()) {
		// dodavanje akcija kupcu na postojeci iznos
		$pba = $row[brojAkcija] + $ba2;
	}

	// dodavanje akcija kupcu
	// upis akcija u bazu
	$conn = DB_Instance::getDBO();
	$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$q = $conn -> prepare("UPDATE `se201_portfolio` SET brojAkcija = $pba WHERE `klijent_id`= :klijent_id AND `imeFirme`=:imeFirme");
	$q -> execute(array(':klijent_id' => $_SESSION['kupac_id'], ':imeFirme' => $firma));

	// prikaz akcija - kandidat za include
	try {
		$conn = DB_Instance::getDBO();
		$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn -> prepare("SELECT imeFirme, brojAkcija FROM `se201_portfolio` WHERE `klijent_id`= :klijent_id");
		$q -> execute(array(':klijent_id' => $_SESSION['kupac_id']));
	} catch (PDOException $Exception) {
		printf("Poruka: <strong>%s</strong> <br> Kod Greške: <strong>%s</strong>", $Exception -> getMessage(), $Exception -> getCode());
	}
	echo "<table border='1'>";
	echo "<tr>  <th>Ime Firme</th>   <th>Broj Akcija</th></tr>";
	while ($row = $q -> fetch()) {
		echo "<tr> <td>$row[imeFirme]</td> <td><input type='text' value='$row[brojAkcija]' disabled='disabled'></td> </tr>";
	}
	echo "</table>";
}

try {
	$conn = DB_Instance::getDBO();
	$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$q = $conn -> prepare("DELETE FROM `se201_portfolio` WHERE brojAkcija=0");
	$q -> execute();
} catch (PDOException $Exception) {
	printf("Poruka: <strong>%s</strong> <br>  Kod Greške: <strong>%s</strong>", $Exception -> getMessage(), $Exception -> getCode());
}
?>