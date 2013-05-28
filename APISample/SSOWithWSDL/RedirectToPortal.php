<?php
session_start();
include_once('App_Code/ConciergeApiHelper.php');
include_once('Config.php');

$api = new ApiHelper();
        
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    
    $call='http://membersuite.com/contracts/IConciergeAPIService/';
    
    $api->PortalUserName = $_POST['portalusername'];
    
    $api->AccesskeyId = Userconfig::read('AccessKeyId');
    $api->AssociationId = Userconfig::read('AssociationId');
    $api->SecretAccessKey = Userconfig::read('SecretAccessKey');
    
    $api->SigningCertificateId = Userconfig::read('SigningcertificateId');
    
    // Get Private XML Content
    $xmlPath = Userconfig::read('SigningcertificatePath');
    if(file_exists($xmlPath))
    {       
       
       $value = file_get_contents($xmlPath);
       $rsaXML = mb_convert_encoding($value , 'UTF-8' , 'UTF-16LE');
            
    }
    else{
        
        $_SESSION['loginerr'] = 'Signing certificate file does not exists.';
        header("location:index.php?error=credentialerror");
        exit(); 
        
    }
    
   // Generate Digital Signature
   $api->DigitalSignature = $api->DigitalSignature($rsaXML);
   
   // Generate Message Signature
   $api->MessageSignature = $api->MessageSignature($method='CreatePortalSecurityToken');
   
   // Get Token XML Content
    $xmlPath = Userconfig::read('PortalXMLPath');
    if(file_exists($xmlPath))
    {       
       
       $filecontent = file_get_contents($xmlPath);
            
    }
    else{
        
        $_SESSION['loginerr'] = 'Token Request Can Not be Generated.';
        header("location:index.php?error=credentialerror");
        exit(); 
        
    }
    
   // Create Security Token For Login
    $response = $api->CreatePortalSecurityToken($filecontent);
    
    $xml = new DOMDocument();
    
    $xml->loadXML($response);
    $sessionId = $xml->getElementsByTagName('SessionId')->item(0)->nodeValue;
    $success = $xml->getElementsByTagName('Success')->item(0)->nodeValue;
    $securityToken = $xml->getElementsByTagName('ResultValue')->item(0)->nodeValue;
    
    if($success=='false')
    {
      $_SESSION['loginerr'] = $xml->getElementsByTagName('Message')->item(0)->nodeValue;
      header("location:index.php?error=credentialerror");
      exit(); 
    }
    
}

?>

<form name="LoginForm" method="post" id="LoginForm" action="<?php echo Userconfig::read('PortalUrl');?>Login.aspx">
    <input type="hidden" name="Token" id="Token" value="<?php echo $securityToken;?>" />
    <input type="hidden" name="ReturnUrl" id="ReturnUrl" value="default.aspx" />
    <input type="hidden" name="NextUrl" id="NextUrl" value="" />
</form>
<script>
    document.LoginForm.submit();
</script>    
