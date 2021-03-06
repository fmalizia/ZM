<?php
	//TODO: spreadsheet and worksheet names as parameter
	require 'vendor/autoload.php';
	use Google\Spreadsheet\DefaultServiceRequest;
	use Google\Spreadsheet\ServiceRequestFactory;
?>

<?php
	/**
	 * Retrieves a Google Spreadsheet file.
	 * Libreria spreadsheet: https://github.com/asimlqt/php-google-spreadsheet-client
	 * Discussione sui problemi di accesso: https://github.com/asimlqt/php-google-spreadsheet-client/issues/20
	 * Accesso tramite "Service account" (getGoogleTokenFromKeyFile):
	 * https://github.com/asimlqt/php-google-spreadsheet-client/wiki/How-to-use-%22Service-account%22-authorization-(rather-than-user-based-access-refresh-tokens) 
	 */
	function spreadSheetRetrive()
	{
		
		 
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
		return $listFeed;
	}
    
    /**
	 * Retrieves a Google API access token by using a P12 key file,
	 * client ID and email address
	 *
	 * These three things may be obtained from 
	 * https://console.developers.google.com/
	 * by creating a new "Service account"
	 */
	function getGoogleTokenFromKeyFile($clientId, $clientEmail, $pathToP12File) 
	{
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