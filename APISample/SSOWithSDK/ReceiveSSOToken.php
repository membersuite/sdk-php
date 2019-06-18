<?php
session_start();
ob_start();

//include_once($_SERVER['DOCUMENT_ROOT'].'/ms_sdk/APISample/phpsdk.phar'); // Use PHAR Archive
include_once($_SERVER['DOCUMENT_ROOT'].'/ms_sdk/src/MemberSuite.php'); // Use the SRC Directory

include_once('./ConciergeApiHelper.php');
include_once('./config.php');


// Get Private XML Content
$xmlPath = Userconfig::read('SigningcertificatePath');
if (file_exists($xmlPath)) {
    $value = file_get_contents($xmlPath);
    $rsaXML = mb_convert_encoding($value, 'UTF-8', 'UTF-16LE');
} else {
    $_SESSION['loginerr'] = 'Signing certificate file does not exists.';
    header("location:index.php?error=credentialerror");
    exit();
}

$api = new MemberSuite();
$api->accesskeyId = Userconfig::read('AccessKeyId');
$api->associationId = Userconfig::read('AssociationId');
$api->secretaccessId = Userconfig::read('SecretAccessKey');

$helper = new ConciergeApiHelper();
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nextUrl = $_POST['NextUrl'];
    $returnUrl = $_POST['ReturnUrl'];
    $tokenString = $_POST["Token"];

    $token = base64_decode($tokenString);

    $portalTokenSignature = $helper->DigitalSignature($token, $rsaXML);
    $api->digitalsignature = $helper->DigitalSignature($api->portalusername, $rsaXML);

    $response = $api->LoginWithToken($tokenString, Userconfig::read('SigningcertificateId'), $portalTokenSignature);

    if($response->aSuccess == 'false'){
        $loginarr = $response->aErrors->bConciergeError->bMessage;
        $_SESSION['loginerr'] = $loginarr;
        header("location:index.php?error=credentialerror");
        exit();
    }

    $loginResult = $response->aResultValue;
    $currentUser = new msPortalUser($loginResult->aPortalUser);
    $individual = new msIndividual($loginResult->aPortalEntity);
    $currentAssociation = new msAssociation($loginResult->aAssociation);
    ?>
    Successfully validated login from:<br/>
    <ul>
        <li>id: <?php echo($currentUser->ID)?></li>
        <li>user: <?php echo($currentUser->Name)?></li>
        <li>last login: <?php echo($currentUser->LastLoggedInAs)?></li>
        <li>first name: <?php echo($currentUser->FirstName)?></li>
        <li>last name: <?php echo($currentUser->LastName)?></li>
        <li>email: <?php echo($currentUser->EmailAddress)?></li>
    </ul>
    <?php
}


