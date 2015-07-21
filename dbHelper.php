<?php
	require_once 'spreadsheetRetrive.php';
	$_GET["fill"](spreadSheetRetrive());

?>

<?php
	function getPDO() {
		//  The "connection string"
		$col = 'mysql:host=localhost;dbname=zappa';
		// try block, if we have succsfully connected
		try { 
		  $db = new PDO($col , 'root', 'root');
		  echo 'Succesfully connected';
		}
		// in case of errors or exceptions
		catch(PDOException $e) {
		  // Otify te error message
		  echo 'Eror: '.$e->getMessage();
		}
		return $db;
	}
?>	

<?php
	function fillClasses($listFeed) {
		$db = getPDO();
		$a =array();
		
		foreach ($listFeed->getEntries() as $entry)
      {
        $values = $entry->getValues();
        if (!in_array($values["classe"], $a))
        {
        		array_push($a, $values["classe"]);
        }
      }
      foreach ($a as $class)
      {
      	$statement = $db->prepare("INSERT INTO Classe(idClasse)
      							   VALUES (:class)");
   		$statement->execute(array("class" => $class));
      }
	  echo "Tabella Classi riempita con successo"; 
   }
      
?>

<?php
	function fillStudent($listFeed) {
		$db = getPDO();
		$a =array();
		
		foreach ($listFeed->getEntries() as $entry)
      	{
          $values = $entry->getValues();
          $statement = $db->prepare("INSERT INTO Studente(idClasse,cognome,nome,sesso,email,cf)
      										VALUES (:class,:cogn,:nom,:sesso,:email,:cf)");
      	 $statement->execute(array("class" => $values["classe"],
      									 "cogn"=>  $values["cognome"],
      									 "nom"=> $values["nome"],
      									 "sesso"=> $values["sesso"],
      									 "email"=> $values["mail"],
      									 "cf"=> $values["cf"] ));
      	

      	}
		echo "Tabella studenti riempita con successo"; 
      
   }
      
?>