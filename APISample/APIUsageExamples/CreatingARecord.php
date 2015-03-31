<?php
  //include_once($_SERVER['DOCUMENT_ROOT'].'/ms_sdk/APISample/phpsdk.phar'); // Use PHAR Archive
  include_once($_SERVER['DOCUMENT_ROOT'].'/ms_sdk/src/MemberSuite.php'); // Use the SRC Directory

  include_once('config.php');

  $api = new MemberSuite();
 
  /*
    This sample is going to login to the association and create a record with a name, 
    email, and birthday that you specify. Once saved, the system will display the ID 
    of the individual created, the age (which MemberSuite calculates), and will automatically
    launch the 360 view of that record in the web browser
  */

  // First, we need to prepare the proxy with the proper security settings.
  // This allows the proxy to generate the appropriate security header. For more information
  // on how to get these settings, see http://api.docs.membersuite.com in the Getting Started section

  $api->accesskeyId = Userconfig::read('AccessKeyId');
  $api->associationId = Userconfig::read('AssociationId');
  $api->secretaccessId = Userconfig::read('SecretAccessKey');
 
  // run a WhoAmI to establish a session
  $response = $api->WhoAmI();
 
  if($response->aSuccess=='false')
  {
    echo ' Unable to login <br> '.$response->aErrors->bConciergeError->bMessage;
    die;
  }
 
  // now, we want to create a new individual
  // First, we need to get a description of the individual
  // The description will tell the client SDK how to "build" the object; in other words, what the fields are
  // and what the default values are. So if you set a default value for LastName to 'Smith', the Describe
  // operation will have that in the metadata. When you construct the object, it will then have the last name
  // defaulted to 'Smith'

  $ObjectResponse = $api->DescribeObject($objectType = 'Individual');
    
  $meta = $ObjectResponse->aResultValue;
    
  // now, create our MemberSuiteObject
  $mso = $api->FromClassMetadata($meta);
    
  /* it's always easier to use the typed MemberSuiteObject
  * You could just instantiate this directly by saying:
  * 
  *      $person = new msIndividual();
  *      
  * This would work - but without the class metadata, the object would not respect any of the defaults
  * that are set up. It would be a totally blank object.*/
    
  $person = new msIndividual($mso);
    
  // Now Assign the data that you want to save
  $person->FirstName = "Jitendra";
  $person->LastName = "Kumar shukla";
  $person->EmailAddress = "apitest@membersuite.com";
  $person->DateOfBirth = "10/5/1989";
  $person->FavoriteColors__c = array('Red', 'Blue', 'NONE');
  
  $address = new Address();
  $address->Line1 = '123 Fake St.';
  $address->Line2 = '';
  $address->City = 'Atlanta';
  $address->State = 'GA';
  $address->PostalCode = '23456';
  $address->Country = 'US';
  
  $person->Home_Address = $address;
  
  // Save Data Now
  $getsaveResult = $api->Save($person);
  if($getsaveResult->aSuccess=='false')
  {
    echo "Unable to save ".$getsaveResult->aErrors->bConciergeError->bMessage.'<br>';
    die;
  }
  
  $newpersondetail = new msIndividual($getsaveResult->aResultValue);
  
  echo 'Individual saved successfully.<br>';
  echo ' LocalId: '.$newpersondetail->LocalID.'<br> Name: '.$newpersondetail->Name.' <br> Age: '.$newpersondetail->Age.'<br>';
  
  echo 'Now run an update to it.<br>';
  $newpersondetail->DateOfBirth = "10/15/1989";
  $newpersondetail->FavoriteColors__c = array('Red', 'Green');
  
  // Need to clear this out as it is currently improperly formatted
  $newpersondetail->Addresses = '';
  
  $address = new Address();
  $address->Line1 = '222 Fake St.';
  $address->Line2 = '';
  $address->City = 'Atlanta';
  $address->State = 'GA';
  $address->PostalCode = '90909';
  $address->Country = 'US';
  
  $newpersondetail->Home_Address = $address;
  
  
  // Save Data Now
  $getsaveResult = $api->Save($newpersondetail);
    
  if($getsaveResult->aSuccess=='false')
  {
    echo "Unable to save ".$getsaveResult->aErrors->bConciergeError->bMessage.'<br>';
    die;
  }
  
  echo 'Individual updated successfully.<br>';
  echo ' LocalId: '.$newpersondetail->LocalID.'<br> Name: '.$newpersondetail->Name.' <br> Age: '.$newpersondetail->Age.'<br>';
?>
