<?php
    //Libreria spreadsheet: https://github.com/asimlqt/php-google-spreadsheet-client
    //Discussione sui problemi di accesso: https://github.com/asimlqt/php-google-spreadsheet-client/issues/20
    //Accesso tramite "Service account":
    //https://github.com/asimlqt/php-google-spreadsheet-client/wiki/How-to-use-%22Service-account%22-authorization-(rather-than-user-based-access-refresh-tokens)
	 
    require 'vendor/autoload.php';
    use Google\Spreadsheet\DefaultServiceRequest;
    use Google\Spreadsheet\ServiceRequestFactory;
    require_once 'spreadsheetRetrive.php';
    
    //Dati per token ottenuti da https://console.developers.google.com (Service account)
    $token = getGoogleTokenFromKeyFile("770028550182-57jd7uh6cr9ont0hkivsj6oq1a139ovf.apps.googleusercontent.com",
                                    "770028550182-57jd7uh6cr9ont0hkivsj6oq1a139ovf@developer.gserviceaccount.com",
                                    "auth/p12.p12");

     	
      $serviceRequest = new DefaultServiceRequest($token);
      
      ServiceRequestFactory::setInstance($serviceRequest);
      $spreadsheetService = new Google\Spreadsheet\SpreadsheetService();
      $spreadsheetFeed = $spreadsheetService->getSpreadsheets();
      $spreadsheet = $spreadsheetFeed->getByTitle('testClass');
      $worksheetFeed = $spreadsheet->getWorksheets();
      $worksheet = $worksheetFeed->getByTitle('Foglio1');
      $listFeed = $worksheet->getListFeed();
      
      foreach ($listFeed->getEntries() as $entry)
      {
          $values = $entry->getValues();
         echo $values["id"] . " | ";
         echo $values["classe"] . " | ";
         echo $values["cognome"] . " | ";
         echo $values["nome"] . " | ";
         echo $values["cf"] . " | ";
         echo $values["sesso"] . " | ";
         echo $values["mail"] . " | ";
       
        echo "<hr>";
      }
?>