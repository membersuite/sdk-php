<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/APISample/phpsdk.phar');

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
