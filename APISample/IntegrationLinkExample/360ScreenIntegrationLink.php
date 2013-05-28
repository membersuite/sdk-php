<?php
session_start();
ob_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/APISample/phpsdk.phar');

include_once('config.php');

$api = new MemberSuite();

 $api->accesskeyId = Userconfig::read('AccessKeyId');
 
 $api->associationId = Userconfig::read('AssociationId');
 
 $api->secretaccessId = Userconfig::read('SecretAccessKey');

 $contextID = '00000000-0008-4f71-8a98-45f86f1a49fd';
  
 $getresponse = $api->Get($contextID);
 
 $ResponseResult = new msUser($getresponse->aResultValue);
 
 $Getresultdata = $ResponseResult->ConvertToArray($ResponseResult);
 
 
?>

<html>
   <head>
      <title>360 Screen Integration Link Example</title>
   </head>
   <body>
      <h4>360 Screen Integration Link Example</h4>
      
      <table cellpadding="5" cellspacing="0" width="50%">
        <?php
        foreach($Getresultdata as $key=>$value){?>
        <tr>
         <td align="left"><?php echo $key;?></td>
         <td align="left"><?php print_r($value); ?></td>
        </tr>
        
        <?php }?>
         
         
      </table>
      
      
   </body>
   
</html>




