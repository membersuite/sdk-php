<?php
session_start();
  //include_once($_SERVER['DOCUMENT_ROOT'].'/ms_sdk/APISample/phpsdk.phar'); // Use PHAR Archive
  include_once($_SERVER['DOCUMENT_ROOT'].'/ms_sdk/src/MemberSuite.php'); // Use the SRC Directory

include_once('config.php');

$api = new MemberSuite();

$api->accesskeyId = Userconfig::read('AccessKeyId');

$api->associationId = Userconfig::read('AssociationId');

$api->secretaccessId = Userconfig::read('SecretAccessKey');

$response = $api->WhoAmI();

 if($response->aSuccess=='false')
  {
    echo $response->aErrors->bConciergeError->bMessage;
    die;
  }


 $Query = "select LocalID, LastName, FirstName from Individual where LastName like 'A*' or FirstName like 'A*' order by LastName";
		
 $Startrecord = "0";
 
 $NumberofRecords = "";

$response = $api->ExecuteMSQL($Query,$Startrecord,$NumberofRecords);
$result = $response->aResultValue->aSearchResult->aTable->diffgrdiffgram->NewDataSet;

if($result->Table) {
	
	foreach($result->Table as $row) {
				
		echo "LocalID : ".$row->LocalID."<br/>";
		echo "FirstName : ".$row->FirstName."<br/>";
		if(isset($row->LastName)) {
			echo "LastName : ".$row->LastName."<br/>";
		}
		echo "--------------------------------------------------------<br/><br/>";	
		
	}
}
else {

	echo "Search Faild";
	die;
	
}
	
?>
