<?php

define('base_path',dirname(__FILE__));
include_once('phpseclib/Crypt/RSA_XML.php');

class ConciergeApiHelper{

    var $accesskeyId;
    var $associationId;
    var $messagesignature;
    var $portalusername;
    var $signingcertificateId;
    var $secretaccessId;
    var $digitalsignature;
    var $error;
    var $debug;

    public function __construct(){

        $this->accesskeyId = null;
        $this->associationId = null;
        $this->messagesignature = null;
        $this->portalusername = null;
        $this->signingcertificateId = null;
        $this->secretaccessId = null;
        $this->digitalsignature = null;
        $this->error = null;
        $this->debug = null;

    }


    // This function is to create token request
    public function CreatePortalSecurityToken(){

        // Get file content
        $filepath = "bin/CreatePortalSecurityTokenRequest.xml";

        if(!file_exists($filepath)){
            $error = 'Error';
            return $error;
        }

        $filecontent = file_get_contents($filepath);

        if($filecontent == 'Error'){
            $errormsg = 'API Request can not be generated';
            return false;
        }

        $action = "http://membersuite.com/contracts/IConciergeAPIService/CreatePortalSecurityToken";

        // Values that needs to be changed
        $replacearr = array('<To></To>',
                            '<Action></Action>',
                        '<AccessKeyId></AccessKeyId>',
                        '<AssociationId></AssociationId>',
                        '<Signature></Signature>',
                        );

        // By these values
        $replacevalue = array('<To>https://api.membersuite.com</To>',
                              '<Action>'.$action.'</Action>',
                          '<AccessKeyId>'.$this->accesskeyId.'</AccessKeyId>',
                          '<AssociationId>'.$this->associationId.'</AssociationId>',
                          '<Signature>'.$this->messagesignature.'</Signature>',
                          );

        // Replace strings
        $apiheaderrequest = str_replace($replacearr,$replacevalue,$filecontent);


        // Construct Body
        $body = '<s:Body>
                       <CreatePortalSecurityToken xmlns="http://membersuite.com/contracts">
                       <portalUserName>'.$this->portalusername.'</portalUserName>
                       <signingCertificateId>'.$this->signingcertificateId.'</signingCertificateId>
                       <signature>'.$this->digitalsignature.'</signature>
                       </CreatePortalSecurityToken>
                       </s:Body>
                       ';

        // Replace strings
        $apirequest = str_replace('<s:Body></s:Body>',$body,$apiheaderrequest);

        $url = 'https://api.membersuite.com';
        $header = array (
               "SOAPAction:http://membersuite.com/contracts/IConciergeAPIService/CreatePortalSecurityToken",
               'Content-Type: text/xml; charset=utf-8',
              );
        $postdata = $apirequest;

        $result =  $this->curl($url,$header,$postdata);

        return $result;

    }


    public static function DigitalSignature($portalUsername,$rsaXML){

        $xmlrsa = new Crypt_RSA_XML();
        $xmlrsa->loadKeyfromXML($rsaXML);
        $signature = $xmlrsa->sign($portalUsername);

        return base64_encode($signature);

    }

    public static function MessageSignature($method, $SecretAccessKey, $AssociationId, $SessionId = ""){

        $call  = "http://membersuite.com/contracts/IConciergeAPIService/$method";

        $secret = base64_decode($SecretAccessKey);
        $data = "$call$AssociationId$SessionId";

        return base64_encode(hash_hmac('sha1', $data, $secret, True));

    }

   public function curl($url,$header,$postdata){

        // cURL initilization
        $curl = curl_init();

        // setting up the cURL URL
        curl_setopt ($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);

        // setting up the cURL Header
        curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
        curl_setopt ($curl, CURLOPT_POST, true);

        // setting the postdata in the cURL that needs to be posted
        curl_setopt ($curl, CURLOPT_POSTFIELDS, $postdata);

        $result = curl_exec($curl);

        // Show curl errors
        if($this->debug){
            $response = curl_error($curl);
            return $response;
        }

        curl_close ($curl);

        return $result;

    }
}

?>
