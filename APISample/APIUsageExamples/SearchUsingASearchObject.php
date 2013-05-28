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

$search = new Search();

$expr = new Expr();//Expression

$search->Type="Individual"; // Type is mandatory

$search->AddCriteria($expr->Contains('FirstName','A*'));
$search->AddCriteria($expr->Contains('LastName','A*'));

$search->SearchOperationGroupType('Or');


$sow = new SearchOperationGroup();
$sow->CriteriaAdd($expr->IsGreaterThan("Age", 15));
$sow->CriteriaAdd($expr->Equals("Gender__c", "Male"));
$sow->SearchOperationGroupType('And');

$search->AddCriteria($sow);


$search->AddOutputColumn('FirstName');
$search->AddOutputColumn('LastName');
$search->AddOutputColumn('LocalID');

$search->AddSortColumn('LastName');

$result = $api->ExecuteSearch($search,0,15);

$response = $result->aResultValue->aTable->diffgrdiffgram->NewDataSet;

if($response) {
	
	foreach($response->Table as $row) {
				
		echo "LocalID : ".$row->LocalID."<br/>";
		echo "FirstName : ".$row->FirstName."<br/>";
		echo "LastName : ".$row->LastName."<br/>";		
		echo "--------------------------------------------------------<br/><br/>";	
		
	}
}
else {

	echo 'Search failed.';
	die;
	
}
	
?>
