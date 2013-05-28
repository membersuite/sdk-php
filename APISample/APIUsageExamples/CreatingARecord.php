<?php
 include_once($_SERVER['DOCUMENT_ROOT'].'/APISample/phpsdk.phar');
 

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
    $metadata = new Membersuiteobjects();
    
    
    $mso = $metadata->FromClassMetadata($meta);
   
    
        /* it's always easier to use the typed MemberSuiteObject
        
        * You could just instantiate this directly by saying:
        * 
        *      $person = new msIndividual();
        *      
        * This would work - but without the class metadata, the object would not respect any of the defaults
        * that are set up. It would be a totally blank object.*/
    
    $person = new ConvertTomsIndividual($mso);
    
    // Now Assign the value that you want to save
    
    $person->FirstName = "Jitendra";
    
    $person->LastName = "Kumar shukla";
    
    $person->EmailAddress = "apitest@membersuite.com";
    
    $person->DateOfBirth = "10/5/1989";
   
    // Save Data Now
    $getsaveResult = $api->Save($person);
    
    if($getsaveResult->aSuccess=='false')
    {
      echo "Unable to save ".$getsaveResult->aErrors->bConciergeError->bMessage;
      die;
    }
    
    $newpersondetail = new ConvertTomsIndividual($getsaveResult->aResultValue);
    
    echo 'Individual saved successfully .<br>';
    echo ' LocalId '.$newpersondetail->LocalID.'<br> Name '.$newpersondetail->Name.' <br> Age '.$newpersondetail->Age;
    
    
    
    
?>
