
<?php
    require 'vendor/autoload.php';
    /*use Google\Spreadsheet\DefaultServiceRequest;
    use Google\Spreadsheet\ServiceRequestFactory;
    
    function IterateSpreadSheets($client)
    {
       
      $token = json_decode($client->getAccessToken());
   
      echo $token->token_type;
      $serviceRequest = new DefaultServiceRequest($token->accessToken, $token->token_type);
      
      ServiceRequestFactory::setInstance($serviceRequest);
      $spreadsheetService = new Google\Spreadsheet\SpreadsheetService();
      $spreadsheetFeed = $spreadsheetService->getSpreadsheets();
      echo "ciao";
      print_r($spreadsheetFeed);
      foreach ($spreadsheetFeed as $value)
      {
        echo $value.getTitle() . "<br>";
      }
      
    }*/
    
    /**
 * Retrieves a Google API access token by using a P12 key file,
 * client ID and email address
 *
 * These three things may be obtained from 
 * https://console.developers.google.com/
 * by creating a new "Service account"
 */
function getGoogleTokenFromKeyFile($clientId, $clientEmail, $pathToP12File) {
    $client = new Google_Client();
    $client->setClientId($clientId);

    $cred = new Google_Auth_AssertionCredentials(
        $clientEmail,
        array('https://spreadsheets.google.com/feeds'),
        file_get_contents($pathToP12File)
    );

    $client->setAssertionCredentials($cred);

    if ($client->getAuth()->isAccessTokenExpired()) {
        $client->getAuth()->refreshTokenWithAssertion($cred);
    }

    $service_token = json_decode($client->getAccessToken());
    return $service_token->access_token;
}

?>