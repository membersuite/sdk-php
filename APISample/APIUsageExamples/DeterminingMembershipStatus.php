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


$Query = "select LocalID,FirstName, LastName, Membership.ReceivesMemberBenefits from Individual order by LastName";
// If I needed to check the membership status of someone whose ID I knew, I would say:
// string msql = "select TOP 1 LocalID,FirstName, LastName, Membership.ReceivesMemberBenefits from Individual where ID = '%%Id%%' order by LastName";		

$Startrecord = "0";
$NumberofRecords = "";

$response = $api->ExecuteMSQL($Query,$Startrecord,$NumberofRecords);
$result = $response->aResultValue->aSearchResult->aTable->diffgrdiffgram->NewDataSet;

if($result->Table) {
	foreach($result->Table as $row) {
	if(isset($row->Membership.ReceivesMemberBenefits)) {	
	$member = $row->Membership.ReceivesMemberBenefits;
	}
	else {
	$member = 'false';
	}
	echo "LocalID : ".$row->LocalID."<br/>";
	echo "FirstName : ".$row->FirstName."<br/>";
	if(isset($row->LastName)) {
	echo "LastName : ".$row->LastName."<br/>";
	}
	echo "Member ? : ".$member."<br/>";	
	echo "--------------------------------------------------------<br/><br/>";	
	}
}
else {
	echo 'Search failed.';
	die;
	
}

?>
