<?php
/*
 Created Date: 7/May/2013
 Created By: SmartdataInc.
*/
include_once('Concierge.php');

class Order extends Concierge{
  
  public function __construct(){
   
   // Create object of the concierge class
    $this->api = new Concierge();
  }
  
  // Get File Cabinet Request
  public function VoidOrderRequest($accesskey,$associationid,$secreteaccessid,$orderID){
    
    // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='VoidOrder',$accesskey,$associationid,$secreteaccessid);
     
     // Construct Body
      $body = '<s:Body>
                    <VoidOrder xmlns="http://membersuite.com/contracts">
                    <orderID>'.$orderID.'</orderID>
                    </VoidOrder>
                    </s:Body>
                    ';
    
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    
    $response = $this->api->SendSoapRequest($apirequest,$method='VoidOrder');
    return $this->api->createobject($response,'VoidOrder'); 
  }
  
  // Get File Cabinet Request
  public function GetOrderFormForProductRequest($accesskey,$associationid,$secreteaccessid,$productID){
    
    // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='GetOrderFormForProduct',$accesskey,$associationid,$secreteaccessid);
     
     // Construct Body
      $body = '<s:Body>
                    <GetOrderFormForProduct xmlns="http://membersuite.com/contracts">
                    <productID>'.$productID.'</productID>
                    </GetOrderFormForProduct>
                    </s:Body>
                    ';
    
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    
    $response = $this->api->SendSoapRequest($apirequest,$method='GetOrderFormForProduct');
    return $this->api->createobject($response,'GetOrderFormForProduct'); 
  }
  
  // Get File Cabinet Request
  public function CheckLongRunningTaskStatusRequest($accesskey,$associationid,$secreteaccessid,$taskTracingID){
    
    // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='CheckLongRunningTaskStatus',$accesskey,$associationid,$secreteaccessid);
     
     // Construct Body
      $body = '<s:Body>
                    <CheckLongRunningTaskStatus xmlns="http://membersuite.com/contracts">
                    <taskTracingID>'.$taskTracingID.'</taskTracingID>
                    </CheckLongRunningTaskStatus>
                    </s:Body>
                    ';
    
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    
    $response = $this->api->SendSoapRequest($apirequest,$method='CheckLongRunningTaskStatus');
    return $this->api->createobject($response,'CheckLongRunningTaskStatus'); 
  }
  
  // Get File Cabinet Request
  public function UpdateOrderBillingInfoRequest($accesskey,$associationid,$secreteaccessid,$orderID,$ccNumber,$ccvCode,$expDate,$billingAddress){
    
     // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='UpdateOrderBillingInfo',$accesskey,$associationid,$secreteaccessid);
     
     // Construct Body
      $body = '<s:Body>
                    <UpdateOrderBillingInfo xmlns="http://membersuite.com/contracts">
                    <orderID>'.$orderID.'</orderID>
                    <ccNumber>'.$ccNumber.'</ccNumber>
                    <ccvCode>'.$ccvCode.'</ccvCode>
                    <expDate>'.$expDate.'</expDate>
                    <billingAddress>'.$billingAddress.'</billingAddress>
                    </UpdateOrderBillingInfo>
                    </s:Body>
                    ';
    
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    
    $response = $this->api->SendSoapRequest($apirequest,$method='UpdateOrderBillingInfo');
    return $this->api->createobject($response,'UpdateOrderBillingInfo'); 
  }
  
  // Get File Cabinet Request
  public function UpdateInvoiceBillingInfoRequest($accesskey,$associationid,$secreteaccessid,$invoiceID,$poNumber,$billingEmailAddress,$billingAddress){
    
     // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='UpdateInvoiceBillingInfo',$accesskey,$associationid,$secreteaccessid);
     
     // Construct Body
      $body = '<s:Body>
                    <UpdateInvoiceBillingInfo xmlns="http://membersuite.com/contracts">
                    <invoiceID>'.$invoiceID.'</invoiceID>
                    <poNumber>'.$poNumber.'</poNumber>
                    <billingEmailAddress>'.$billingEmailAddress.'</billingEmailAddress>
                    <billingAddress>'.$billingAddress.'</billingAddress>
                    </UpdateInvoiceBillingInfo>
                    </s:Body>
                    ';
    
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    
    $response = $this->api->SendSoapRequest($apirequest,$method='UpdateInvoiceBillingInfo');
    return $this->api->createobject($response,'UpdateInvoiceBillingInfo'); 
  }
  
  // Get File Cabinet Request
  public function ProcessFulfillmentBatchRequest($accesskey,$associationid,$secreteaccessid,$fulfillmentBatchID){
    
     // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='ProcessFulfillmentBatch',$accesskey,$associationid,$secreteaccessid);
     
     // Construct Body
      $body = '<s:Body>
                    <ProcessFulfillmentBatch xmlns="http://membersuite.com/contracts">
                    <fulfillmentBatchID>'.$fulfillmentBatchID.'</fulfillmentBatchID>
                    </ProcessFulfillmentBatch>
                    </s:Body>
                    ';
    
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    
    $response = $this->api->SendSoapRequest($apirequest,$method='ProcessFulfillmentBatch');
    return $this->api->createobject($response,'ProcessFulfillmentBatch'); 
  }
  
  // Get File Cabinet Request
  public function GenerateRenewalOrderRequest($accesskey,$associationid,$secreteaccessid,$targetID){
    
     // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='GenerateRenewalOrder',$accesskey,$associationid,$secreteaccessid);
     
     // Construct Body
      $body = '<s:Body>
                    <GenerateRenewalOrder xmlns="http://membersuite.com/contracts">
                    <targetID>'.$targetID.'</targetID>
                    </GenerateRenewalOrder>
                    </s:Body>
                    ';
    
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    
    $response = $this->api->SendSoapRequest($apirequest,$method='GenerateRenewalOrder');
    return $this->api->createobject($response,'GenerateRenewalOrder'); 
  }
  
  // Get File Cabinet Request
  public function FulfillOrderRequest($accesskey,$associationid,$secreteaccessid,$orderID,$itemsToFulfill){
    
     // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='FulfillOrder',$accesskey,$associationid,$secreteaccessid);
     
     // Construct Body
      $body = '<s:Body>
                    <FulfillOrder xmlns="http://membersuite.com/contracts">
                    <orderID>'.$orderID.'</orderID>
                    <itemsToFulfill>'.$itemsToFulfill.'</itemsToFulfill>
                    </FulfillOrder>
                    </s:Body>
                    ';
    
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    
    $response = $this->api->SendSoapRequest($apirequest,$method='FulfillOrder');
    return $this->api->createobject($response,'FulfillOrder'); 
  }
  
  // Get File Cabinet Request
  public function ShipOrderRequest($accesskey,$associationid,$secreteaccessid,$orderID,$itemsToShip,$shipDate,$shippingMethod,$trackingNumber){
    
     // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='ShipOrder',$accesskey,$associationid,$secreteaccessid);
     
     // Construct Body
      $body = '<s:Body>
                    <ShipOrder xmlns="http://membersuite.com/contracts">
                    <orderID>'.$orderID.'</orderID>
                    <itemsToShip>'.$itemsToShip.'</itemsToShip>
                    <shipDate>'.$shipDate.'</shipDate>
                    <shippingMethod>'.$shippingMethod.'</shippingMethod>
                    <trackingNumber>'.$trackingNumber.'</trackingNumber>
                    </ShipOrder>
                    </s:Body>
                    ';
    
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    
    $response = $this->api->SendSoapRequest($apirequest,$method='ShipOrder');
    return $this->api->createobject($response,'ShipOrder'); 
  }
  
  // Get File Cabinet Request
  public function BillOrderRequest($accesskey,$associationid,$secreteaccessid,$orderID){
    
     // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='BillOrder',$accesskey,$associationid,$secreteaccessid);
     
     // Construct Body
      $body = '<s:Body>
                    <BillOrder xmlns="http://membersuite.com/contracts">
                    <orderID>'.$orderID.'</orderID>
                    </BillOrder>
                    </s:Body>
                    ';
    
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    
    $response = $this->api->SendSoapRequest($apirequest,$method='BillOrder');
    return $this->api->createobject($response,'BillOrder'); 
  }
  
  public function GetOrderFormRequest($accesskey,$associationid,$secreteaccessid,$order){
    
     // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='GetOrderForm',$accesskey,$associationid,$secreteaccessid);
     
     // Construct Body
     $objectarr = $this->object_to_array($order);
     $objecttype = '';
     foreach($objectarr as $key=>$value){
       if($key<>'ClassType'){ 
      $objecttype.= '<mem:FieldMetadata>
        <mem:Name>'.$key.'</mem:Name>
        <mem:Value>'.$value.'</mem:Value>
        </mem:FieldMetadata>';  
       }
      }
      $body = '<s:Body>
                    <GetOrderForm xmlns="http://membersuite.com/contracts">
                    <order>
                    <mem:ClassType>'.$objectarr['ClassType'].'</mem:ClassType>
                    <mem:Fields>
                    '.$objecttype.'
                    </mem:Fields>
                    </order>
                    </GetOrderForm>
                    </s:Body>
                    ';
    
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    
    $response = $this->api->SendSoapRequest($apirequest,$method='GetOrderForm');
    return $this->api->createobject($response,'GetOrderForm'); 
  }
  
  public function ProcessOrderRequest($accesskey,$associationid,$secreteaccessid,$msOrderToProcess,$antiDuplicationKey=""){
    
     // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='ProcessOrder',$accesskey,$associationid,$secreteaccessid);
     
     // Construct Body
     $objectarr = $this->object_to_array($msOrderToProcess);
     $objecttype = '';
     foreach($objectarr as $key=>$value){
       if($key<>'ClassType'){ 
      $objecttype.= '<mem:FieldMetadata>
        <mem:Name>'.$key.'</mem:Name>
        <mem:Value>'.$value.'</mem:Value>
        </mem:FieldMetadata>';  
       }
      }
      $body = '<s:Body>
                    <ProcessOrder xmlns="http://membersuite.com/contracts">
                    <msOrderToProcess>
                    <mem:ClassType>'.$objectarr['ClassType'].'</mem:ClassType>
                    <mem:Fields>
                    '.$objecttype.'
                    </mem:Fields>
                    </msOrderToProcess>
                    <antiDuplicationKey>'.$antiDuplicationKey.'</antiDuplicationKey>
                    </ProcessOrder>
                    </s:Body>
                    ';
    
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    
    $response = $this->api->SendSoapRequest($apirequest,$method='ProcessOrder');
    return $this->api->createobject($response,'ProcessOrder'); 
  }
  
  public function SaveDetailsRequest($accesskey,$associationid,$secreteaccessid,$msoOrder){
    
     // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='SaveDetails',$accesskey,$associationid,$secreteaccessid);
     
     // Construct Body
     $objectarr = $this->object_to_array($msoOrder);
     $objecttype = '';
     foreach($objectarr as $key=>$value){
       if($key<>'ClassType'){ 
      $objecttype.= '<mem:FieldMetadata>
        <mem:Name>'.$key.'</mem:Name>
        <mem:Value>'.$value.'</mem:Value>
        </mem:FieldMetadata>';  
       }
      }
      $body = '<s:Body>
                    <SaveDetails xmlns="http://membersuite.com/contracts">
                    <msoOrder>
                    <mem:ClassType>'.$objectarr['ClassType'].'</mem:ClassType>
                    <mem:Fields>
                    '.$objecttype.'
                    </mem:Fields>
                    </msoOrder>
                    </SaveDetails>
                    </s:Body>
                    ';
    
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    
    $response = $this->api->SendSoapRequest($apirequest,$method='SaveDetails');
    return $this->api->createobject($response,'SaveDetails'); 
  }
  
  public function ProcessReturnRequest($accesskey,$associationid,$secreteaccessid,$msReturn,$autoGenerateRefunds=true){
    
     // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='ProcessReturn',$accesskey,$associationid,$secreteaccessid);
     
     // Construct Body
     $objectarr = $this->object_to_array($msReturn);
     $objecttype = '';
     foreach($objectarr as $key=>$value){
       if($key<>'ClassType'){ 
      $objecttype.= '<mem:FieldMetadata>
        <mem:Name>'.$key.'</mem:Name>
        <mem:Value>'.$value.'</mem:Value>
        </mem:FieldMetadata>';  
       }
      }
      $body = '<s:Body>
                    <ProcessReturn xmlns="http://membersuite.com/contracts">
                    <msReturn>
                    <mem:ClassType>'.$objectarr['ClassType'].'</mem:ClassType>
                    <mem:Fields>
                    '.$objecttype.'
                    </mem:Fields>
                    </msReturn>
                    <autoGenerateRefunds>'.$autoGenerateRefunds.'</autoGenerateRefunds>
                    </ProcessReturn>
                    </s:Body>
                    ';
    
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    
    $response = $this->api->SendSoapRequest($apirequest,$method='ProcessReturn');
    return $this->api->createobject($response,'ProcessReturn'); 
  }
  
  public function SaveFulfillmentBatchRequest($accesskey,$associationid,$secreteaccessid,$msoFulfillmentBatch){
    
     // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='SaveFulfillmentBatch',$accesskey,$associationid,$secreteaccessid);
     
     // Construct Body
     $objectarr = $this->object_to_array($msoFulfillmentBatch);
     $objecttype = '';
     foreach($objectarr as $key=>$value){
       if($key<>'ClassType'){ 
      $objecttype.= '<mem:FieldMetadata>
        <mem:Name>'.$key.'</mem:Name>
        <mem:Value>'.$value.'</mem:Value>
        </mem:FieldMetadata>';  
       }
      }
      $body = '<s:Body>
                    <SaveFulfillmentBatch xmlns="http://membersuite.com/contracts">
                    <msoFulfillmentBatch>
                    <mem:ClassType>'.$objectarr['ClassType'].'</mem:ClassType>
                    <mem:Fields>
                    '.$objecttype.'
                    </mem:Fields>
                    </msoFulfillmentBatch>
                    </SaveFulfillmentBatch>
                    </s:Body>
                    ';
    
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    
    $response = $this->api->SendSoapRequest($apirequest,$method='SaveFulfillmentBatch');
    return $this->api->createobject($response,'SaveFulfillmentBatch'); 
  }
  
  public function AdjustOrderRequest($accesskey,$associationid,$secreteaccessid,$msOrderToAdjust){
    
     // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='AdjustOrder',$accesskey,$associationid,$secreteaccessid);
     
     // Construct Body
     $objectarr = $this->object_to_array($msOrderToAdjust);
     $objecttype = '';
     foreach($objectarr as $key=>$value){
       if($key<>'ClassType'){ 
      $objecttype.= '<mem:FieldMetadata>
        <mem:Name>'.$key.'</mem:Name>
        <mem:Value>'.$value.'</mem:Value>
        </mem:FieldMetadata>';  
       }
      }
      $body = '<s:Body>
                    <AdjustOrder xmlns="http://membersuite.com/contracts">
                    <msOrderToAdjust>
                    <mem:ClassType>'.$objectarr['ClassType'].'</mem:ClassType>
                    <mem:Fields>
                    '.$objecttype.'
                    </mem:Fields>
                    </msOrderToAdjust>
                    </AdjustOrder>
                    </s:Body>
                    ';
    
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    
    $response = $this->api->SendSoapRequest($apirequest,$method='AdjustOrder');
    return $this->api->createobject($response,'AdjustOrder'); 
  }
  
  public function PreProcessOrderRequest($accesskey,$associationid,$secreteaccessid,$msOrderToFinalize){
    
     // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='PreProcessOrder',$accesskey,$associationid,$secreteaccessid);
     
     // Construct Body
     $objectarr = $this->object_to_array($msOrderToFinalize);
     $objecttype = '';
     foreach($objectarr as $key=>$value){
       if($key<>'ClassType'){ 
      $objecttype.= '<mem:FieldMetadata>
        <mem:Name>'.$key.'</mem:Name>
        <mem:Value>'.$value.'</mem:Value>
        </mem:FieldMetadata>';  
       }
      }
      $body = '<s:Body>
                    <PreProcessOrder xmlns="http://membersuite.com/contracts">
                    <msOrderToFinalize>
                    <mem:ClassType>'.$objectarr['ClassType'].'</mem:ClassType>
                    <mem:Fields>
                    '.$objecttype.'
                    </mem:Fields>
                    </msOrderToFinalize>
                    </PreProcessOrder>
                    </s:Body>
                    ';
    
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    
    $response = $this->api->SendSoapRequest($apirequest,$method='PreProcessOrder');
    return $this->api->createobject($response,'PreProcessOrder'); 
  }
  
  public function ProcessInventoryTransactionRequest($accesskey,$associationid,$secreteaccessid,$inventoryTransaction){
    
     // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='ProcessInventoryTransaction',$accesskey,$associationid,$secreteaccessid);
     
     // Construct Body
     $objectarr = $this->object_to_array($inventoryTransaction);
     $objecttype = '';
     foreach($objectarr as $key=>$value){
       if($key<>'ClassType'){ 
      $objecttype.= '<mem:FieldMetadata>
        <mem:Name>'.$key.'</mem:Name>
        <mem:Value>'.$value.'</mem:Value>
        </mem:FieldMetadata>';  
       }
      }
      $body = '<s:Body>
                    <ProcessInventoryTransaction xmlns="http://membersuite.com/contracts">
                    <inventoryTransaction>
                    <mem:ClassType>'.$objectarr['ClassType'].'</mem:ClassType>
                    <mem:Fields>
                    '.$objecttype.'
                    </mem:Fields>
                    </inventoryTransaction>
                    </ProcessInventoryTransaction>
                    </s:Body>
                    ';
    
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    
    $response = $this->api->SendSoapRequest($apirequest,$method='ProcessInventoryTransaction');
    return $this->api->createobject($response,'ProcessInventoryTransaction'); 
  }
  
  private function object_to_array($data) 
    {
    if ((! is_array($data)) and (! is_object($data))) return $data;
    
      $result = array();
      
      $data = (array) $data;
      foreach ($data as $key => $value) {
      if (is_object($value)) $value = (array) $value;
      if (is_array($value)) 
      $result[$key] = $this->object_to_array($value);
      else
          $result[$key] = $value;
      }
    
    return $result;
  }
}
?>