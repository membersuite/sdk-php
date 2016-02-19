<?php
  //include_once($_SERVER['DOCUMENT_ROOT'].'/ms_sdk/APISample/phpsdk.phar'); // Use PHAR Archive
  include_once($_SERVER['DOCUMENT_ROOT'].'/ms_sdk/src/MemberSuite.php'); // Use the SRC Directory
 
  include_once('config.php');

  $api = new MemberSuite();
    
  $api->accesskeyId = Userconfig::read('AccessKeyId');
  $api->associationId = Userconfig::read('AssociationId');
  $api->secretaccessId = Userconfig::read('SecretAccessKey');
    
	// Get product information 
	$product1 = $api->GetObject('2537d8c3-00ce-cee4-8a33-0b371e6de173');
	$product2 = $api->GetObject('2537d8c3-00ce-c5f2-873e-0b371e6de173');
  
  // Get user information
  $user = $api->GetObject('2537d8c3-0006-ceb0-8352-0b371e6de173');
    		
	echo "Individual <strong>".$user->Name."</strong> tries to by following items: <br/>";
	echo $product1->Name." for $".$product1->Price."<br/>"; 	    	
	echo $product2->Name." for $".$product2->Price."<br/>"; 	
	    	
  $order = new stdClass();
  $order->ClassType = 'Order';

 	$order->BillTo = '2537d8c3-0006-ceb0-8352-0b371e6de173';   
 	$order->ShipTo = '2537d8c3-0006-ceb0-8352-0b371e6de173';
	
	$order->BillingAddress = new stdClass();
	$order->BillingAddress->RecordType = 'Address';
	$order->BillingAddress->City = 'Atlanta';	 	
	$order->BillingAddress->Country = 'US';	 	 	
	$order->BillingAddress->Line1 = '1 Str';
	$order->BillingAddress->PostalCode = '30303';
	$order->BillingAddress->State = 'GA';
    
	$order->LineItems = array();

 	$lineItem = new stdClass();
 	$lineItem->ClassType = 'OrderLineItem';
 	$lineItem->Product = $product1->ID; 	 	 	
 	$lineItem->Quantity = 1;
 	$lineItem->UnitPrice = $product1->Price;
 	$lineItem->Total = $lineItem->Quantity * $lineItem->UnitPrice;
 	$order->LineItems[0] = $lineItem;
 	
 	$lineItem = new stdClass();
 	$lineItem->ClassType = 'OrderLineItem';
 	$lineItem->Product = $product2->ID; 	 	 	
 	$lineItem->Quantity = 1;
 	$lineItem->UnitPrice = $product2->Price;
 	$lineItem->Total = $lineItem->Quantity * $lineItem->UnitPrice;
 	$order->LineItems[1] = $lineItem;
 	
 	$order->Total = 0;
 	foreach($order->LineItems as $lineItem) { 		
		$order->Total = $order->Total + $lineItem->Total;		
	}
	
	echo "Order total: $".$order->Total."<br/>";
 	
 	echo "Preprocessing...<br/>"; 	
 	$response = $api->PreprocessOrder($order);
 	 	
 	if($response->aSuccess == 'true'){
 		echo "Positive response!<br/>"; 	
	 	$finOrder = $api->data->ConvertToObject($response->aResultValue->bFinalizedOrder);
	 	
	 	//for($i = 0; $i < count($finOrder->LineItems); $i++) {
		//	var_dump($finOrder->LineItems[$i]);
		//}
    
		$finOrder->PaymentMethod = 'Cash';
				
		echo "Placing order...<br/>";
	 	$response = $api->ProcessOrder($finOrder);
		
		if($response->aSuccess == 'true'){ 	
			echo "Tracking token is: ".$response->aResultValue->bRunID."<br/>";
			echo "Workflow is: ".$response->aResultValue->bWorkflowID."<br/>";
						
			echo "Waiting for a response...<br/>";		
			$result = null;
			$counter = 0;
			do {
				$status = $api->CheckLongRunningTaskStatus($response->aResultValue);
				$result = $status->aResultValue;
				
				echo $result->bStatus;
				
				if ($result->bStatus == 'Running') {
					echo "...<br/>";
					$counter += 1;
					sleep(2);
				}
				else {
					$counter = 999;
				}
			} while ($counter < 20);
			
			echo "<br/>";
			
			
			
		} else {
			var_dump($response);					
		}		
	} else {
		var_dump($response);
	}
?>


