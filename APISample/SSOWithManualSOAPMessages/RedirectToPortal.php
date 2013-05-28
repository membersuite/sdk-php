<?php
session_start();
ob_start();

include_once('App_Code/ConciergeApiHelper.php');
include_once('config.php');

$ConciergeApiHelper = new ConciergeApiHelper();

        
if($_SERVER['REQUEST_METHOD'] == 'POST')
{     
    $portalusername = $_POST['portalusername'];   
    
    $ConciergeApiHelper->accesskeyId = Userconfig::read('AccessKeyId');
    $ConciergeApiHelper->associationId = Userconfig::read('AssociationId');
    $ConciergeApiHelper->secretaccessId = Userconfig::read('SecretAccessKey');
    $ConciergeApiHelper->portalusername = $portalusername;
    $ConciergeApiHelper->signingcertificateId = Userconfig::read('SigningcertificateId');
    
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
    
    
    $ConciergeApiHelper->digitalsignature = $ConciergeApiHelper->DigitalSignature($ConciergeApiHelper->portalusername,$rsaXML);
    
    $xml = new DOMDocument();    
    
    // Get Message Signature
    $ConciergeApiHelper->messagesignature = $ConciergeApiHelper->MessageSignature($method='CreatePortalSecurityToken', $ConciergeApiHelper->secretaccessId, $ConciergeApiHelper->associationId, $SessionId="");
    $response = $ConciergeApiHelper->CreatePortalSecurityToken();
    
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
