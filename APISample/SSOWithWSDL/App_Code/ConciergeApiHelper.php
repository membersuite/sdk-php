<?php
/*
 This class is used to create request and generate response.
 Created Date: 12/April/2013
 Created By: SmartdataInc.
*/
$filedir = dirname(__FILE__);

define('base_path',$filedir);
include_once('phpseclib/Crypt/RSA_XML.php');

class ApiHelper{
  
  var $AccesskeyId;
  var $AssociationId;
  var $SecretAccessKey;
  var $MessageSignature;
  var $PortalUserName;
  var $SigningCertificateId;
  var $DigitalSignature;
  
  public function __construct(){
  
  $this->AccesskeyId = null;
  $this->AssociationId = null;
  $this->SecretAccessKey = null;
  $this->MessageSignature = null;
  $this->PortalUserName = null;
  $this->SigningCertificateId = null;
  $this->DigitalSignature = null;
    
  }
  
  
  
 // Generate Message Signature   
 public function MessageSignature($method='CreatePortalSecurityToken'){
    
        $call  = "http://membersuite.com/contracts/IConciergeAPIService/$method";
        
        $secret = base64_decode($this->SecretAccessKey);
        $AssociationId = $this->AssociationId;
        $SessionId = "";
        $data = "$call$AssociationId$SessionId";
        
        return base64_encode(hash_hmac('sha1', $data, $secret, True));
    
    }    
    
   // Generate Digital Signature
   public function DigitalSignature($rsaXML){
    
        $xmlrsa = new Crypt_RSA_XML();
        $xmlrsa->loadKeyfromXML($rsaXML);
        $signature = $xmlrsa->sign($this->PortalUserName);
        
        return base64_encode($signature);
    
   }
   
   //Generate Portal Security Token
   public function CreatePortalSecurityToken($filecontent){
    
    // Values that needs to be changed   
    $replacearr = array('<To></To>',
                        '<AccessKeyId></AccessKeyId>',
                        '<AssociationId></AssociationId>',
                        '<Signature></Signature>',
                        '<portalUserName></portalUserName>',
                        '<signingCertificateId></signingCertificateId>',
                        '<signature></signature>'
                        );
         
    // By these values
    $replacevalue = array('<To>https://api.membersuite.com/</To>',
                          '<AccessKeyId>'.$this->AccesskeyId.'</AccessKeyId>',
                          '<AssociationId>'.$this->AssociationId.'</AssociationId>',
                          '<Signature>'.$this->MessageSignature.'</Signature>',
                          '<portalUserName>'.$this->PortalUserName.'</portalUserName>',
                          '<signingCertificateId>'.$this->SigningCertificateId.'</signingCertificateId>',
                          '<signature>'.$this->DigitalSignature.'</signature>'
                          );
         
    // Replace strings
         
    $apiheaderrequest = str_replace($replacearr,$replacevalue,$filecontent);
    
    $soap = new SoapClient('https://api.membersuite.com/mex');
 
    $response = $soap-> __doRequest($apiheaderrequest, 'https://api.membersuite.com', 'http://membersuite.com/contracts/IConciergeAPIService/CreatePortalSecurityToken', '1.0');
    
    return $response;

  }
    
}

?>