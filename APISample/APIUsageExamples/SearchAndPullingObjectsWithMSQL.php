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
    echo ' Unable to login <br> '.$response->aErrors->bConciergeError->bMessage;
    die;
  }


$Query = "select OBJECTS() from Individual where LastName like 'A*' or FirstName like 'A*' order by LastName";
		
$Startrecord = "0";

$NumberofRecords = "";

$response = $api->ExecuteMSQL($Query,$Startrecord,$NumberofRecords);
$result = $response->aResultValue->aSearchResult->aTable->diffgrdiffgram->NewDataSet;		
//you can use 'print_r()' to print the result for use.

if(!empty($result)) {
	
foreach($result->Table as $row) {
			
	echo "LocalID : ".$row->LocalID."<br/>";
	echo "FirstName : ".$row->FirstName."<br/>";
	echo "LastName : ".$row->LastName."<br/>";		
	echo "--------------------------------------------------------<br/>";
	foreach($row->Fields as $entry)
	{
		if ($entry->Value != null)
		echo $entry->Key." : ".$entry->Value."<br/>";
	}
	echo "<br/><br/>";
}
}
else {

	echo 'Search failed.';	
	die; 

}
	
?>
