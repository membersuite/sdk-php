<?php
  //include_once($_SERVER['DOCUMENT_ROOT'].'/ms_sdk/APISample/phpsdk.phar'); // Use PHAR Archive
  include_once($_SERVER['DOCUMENT_ROOT'].'/ms_sdk/src/MemberSuite.php'); // Use the SRC Directory
  
  include_once('config.php');

  $api = new MemberSuite();
  
  $CurrentEntityId = '2537d8c3-0006-ceb0-8352-0b371e6de173';
  
  $api->accesskeyId = Userconfig::read('AccessKeyId');
  $api->associationId = Userconfig::read('AssociationId');
  $api->secretaccessId = Userconfig::read('SecretAccessKey');
  
  $response = $api->GetPriorityConfiguration($CurrentEntityId);
  
  //var_dump($response);
  $ppConfig = new stdClass();
  $ppConfig->IsPreferredConfigured = $response->aResultValue->bIsPreferredConfigured == 'true';
  $ppConfig->CustomerID = $response->aResultValue->bCustomerID;
  $ppConfig->AccessToken = $response->aResultValue->bAccessToken;
  $ppConfig->EndpointUri = $response->aResultValue->bEndpointUri;
?>
<html>
<head>
	<title>PPS Test</title>
    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <!--script type="text/javascript" src="js/membersuite.payment-processor.min.js"></script-->
    <script type="text/javascript" src="js/membersuite.payment-processor.API.js"></script>
    <script type="text/javascript" src="js/priorityPayment.logger.js"></script>
    <script type="text/javascript" src="js/cardType-util.js"></script>
    <script type="text/javascript" src="js/priorityPayment.ajaxAPI.js"></script>
    <script type="text/javascript" src="js/membersuite.payment-processor-1.0.js"></script>
</head>
<body>
    <form method="post" action="PPSCreditCard.php">
        <div id="dvPriorityData" class="pp-config" style="display: none;"><?php echo stripslashes(json_encode($ppConfig))?></div>
		<!--{"IsPreferredConfigured":true,"CustomerID":"8295083","AccessToken":"VvzYDaf28ZNjeLPXbn0JC6Bm","EndpointUri":"https://api.mxmerchant.com/checkout/v3/"}-->
        <table>
            <tr>
                <td>Name on Card: </td>
                <td>
                    <input name="tbNameOnCard" type="text" value="test" id="tbNameOnCard" />
                </td>
            </tr>
            <tr>
                <td>Card Number: </td>
                <td>
                    <input name="tbCardNumber" type="text" id="tbCardNumber" class="cc-number" />
                </td>
            </tr>
            <tr>
                <td>Expiration: </td>
                <td>
                    <select name="ddlMonth" id="ddlMonth" class="mypMonth">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
						<option value="11">11</option>
						<option value="12">12</option>
					</select>
                    <select name="ddlYear" id="ddlYear" class="mypYear">
						<option value="2016">2016</option>
						<option value="2017">2017</option>
						<option value="2018">2018</option>
						<option value="2019">2019</option>
						<option value="2020">2020</option>
						<option value="2021">2021</option>
						<option value="2022">2022</option>
						<option value="2023">2023</option>
					</select>
                </td>
            </tr>
        </table>
        <input type="submit" name="CreateOrder" value="" id="CreateOrder" class="save-token" style="display: none;" />
        <input onclick="javascript: requestToken();" type="button" value="Create Order" />
	</form>
	<script type="text/javascript">
        function requestToken() {
            if ($('#tbNameOnCard').val() == '' || $('#tbCardNumber').val() == '') {
                alert('Please complete Name On Card and Card Number.');
                return false;
            }

            var config = JSON.parse($('.pp-config').text());

            var saveBtnId = '.save-token';

            var $cardNumberElem = $('.cc-number');
            var $expiryMonthElem = $('.mypMonth');
            var $expiryYearElem = $('.mypYear');
            var id = '<?php echo $CurrentEntityId?>';

            config["Address1"] = '123 Fake St.';
            config["City"] = 'Nowhere';
            config["State"] = 'GA';
            config["Zip"] = '12345';
			
            var parms = {
                ppConfig: config,
                msConfig: {
                    guid: id,
                    $cardNumberElem: $cardNumberElem,
                    $expiryMonthElem: $expiryMonthElem,
                    $expiryYearElem: $expiryYearElem,
                    saveBtnId: saveBtnId
                }
            }

            membersuite.paymentProcessor.init(parms);

            return false;
        };
    </script>
</body>
</html>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$order = new stdClass();
	$order->ClassType = 'Order';

	$order->BillTo = $CurrentEntityId;   
	$order->ShipTo = $CurrentEntityId;
	
	$order->LineItems = array();

 	$lineItem = new stdClass();
 	$lineItem->ClassType = 'OrderLineItem';
 	$lineItem->Product = '3afa700f-00ce-ceed-660b-0b3ab514ec91'; 	 	 	
 	$lineItem->Quantity = 1;
 	$order->LineItems[0] = $lineItem;

 	echo "Preprocessing...<br/>"; 	
 	$response = $api->PreprocessOrder($order);
 	 	
 	if($response->aSuccess == 'true'){
 		echo "Positive response!<br/>"; 	
	 	$finOrder = $api->data->ConvertToObject($response->aResultValue->bFinalizedOrder);
	 	
	 	//for($i = 0; $i < count($finOrder->LineItems); $i++) {
		//	var_dump($finOrder->LineItems[$i]);
		//}
    
		$finOrder->PaymentMethod = 'CreditCard';
		$finOrder->CreditCardNumber = $_POST['tbCardNumber'];
		$finOrder->Status = 'Pending';
		$finOrder->CreditCardExpirationDate = '01/'.$_POST['ddlMonth'].'/'.$_POST['ddlYear'];
		$finOrder->NameOnCreditCard = $_POST['tbNameOnCard'];
		$finOrder->ProcessOrderEvenIfPaymentFails = 'false';
				
		echo "Placing order...<br/>";
	 	$response = $api->ProcessOrder($finOrder);
		if($response->aSuccess == 'true'){ 	
			echo "Tracking token is: ".$response->aResultValue."<br/>";
						
			echo "Waiting for a response...<br/>";		
			$result = null;			
			do {
				$status = $api->CheckLongRunningTaskStatus($response->aResultValue);					
				$result = (array)$status->aResultValue;
			} while (count($result) == 0);
			
			echo "<br/>";
			
			$result = $result['bFields']->bKeyValueOfstringanyType;			
			foreach($result as $value){
				if ($value->bKey == 'Description'){
					echo $value->bValue."<br/>";
					break;
				}
			}
		} else {
			var_dump($response);					
		}		
	} else {
		var_dump($response);
	}
}
?>
