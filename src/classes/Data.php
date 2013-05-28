<?php
/*
 This class is used for calling different category methods like database and metadata.
 Created Date: 03/April/2013
 Created By: SmartdataInc.
*/
include_once('Concierge.php');

class Data extends Concierge{
  
  public function __construct(){
   // Create object of the concierge class
    $this->api = new Concierge();
  }
  
  // function to save data
  public function SaveDataRequest($accesskey,$associationid,$secreteaccessid,$object){
   // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='Save',$accesskey,$associationid,$secreteaccessid);
     $objectarr = $this->object_to_array($object);
     // Construct Body
     $objecttype = '';
     foreach($objectarr as $key=>$value){
       if($key<>'ClassType' && $value<>""){
      $objecttype.= '<mem:KeyValueOfstringanyType>
        <mem:Key>'.$key.'</mem:Key>
        <mem:Value i:type="a:string">'.$value.'</mem:Value>
        </mem:KeyValueOfstringanyType>';  
       }
      }
     
     $body = '<s:Body>
                    <Save xmlns="http://membersuite.com/contracts">
                    <objectToSave>
                    <mem:ClassType>'.$objectarr['ClassType'].'</mem:ClassType>
                    <mem:Fields>
                    '.$objecttype.'
                    </mem:Fields>
                    </objectToSave>
                    </Save>
                    </s:Body>
                    ';
    // Replace strings
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
   $getsaveResult = $this->api->SendSoapRequest($apirequest,$method='Save');
   
   return $this->api->createobject($getsaveResult,'Save'); 
  }
  
  public function GetDataRequest($accesskey,$associationid,$secreteaccessid,$Id){
    // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='Get',$accesskey,$associationid,$secreteaccessid);
     // Construct Body
     
     $body = '<s:Body>
                    <Get xmlns="http://membersuite.com/contracts">
                    <id>'.$Id.'</id>
                    </Get>
                    </s:Body>
                    ';
    // Replace strings
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    $getResult = $this->api->SendSoapRequest($apirequest,$method='Get');
    
    return $this->api->createobject($getResult,'Get'); 
  }
  
  public function RecordJobRequest($accesskey,$associationid,$secreteaccessid,$jobID,$additionalLogText,$newStatus){
    // Get file content
    
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='RecordJobProgress',$accesskey,$associationid,$secreteaccessid);
     // Construct Body
     
     $body = '<s:Body>
                    <RecordJobProgress xmlns="http://membersuite.com/contracts">
                    <jobID>'.$jobID.'</jobID>
                    <additionalLogText>'.$additionalLogText.'</additionalLogText>
                    <newStatus>'.$newStatus.'</newStatus>
                    </RecordJobProgress>
                    </s:Body>
                    ';
    // Replace strings
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    $getResult = $this->api->SendSoapRequest($apirequest,$method='RecordJobProgress');
    
    return $this->api->createobject($getResult,'RecordJobProgress'); 
  }
  
  public function DataQuery($accesskey,$associationid,$secreteaccessid,$objectType,$whereClause,$orderBy,$startIndex){
    // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='Query',$accesskey,$associationid,$secreteaccessid);
     // Construct Body
 
     $body = '<s:Body>
                    <Query xmlns="http://membersuite.com/contracts">
                    <objectType>'.$objectType.'</objectType>
                    <whereClause>'.$whereClause.'</whereClause>
                    <orderBy>'.$orderBy.'</orderBy>
                    <startIndex>'.$startIndex.'</startIndex>
                    </Query>
                    </s:Body>
                    ';
    // Replace strings
         
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    $getResult = $this->api->SendSoapRequest($apirequest,$method='Query');
    return $this->api->createobject($getResult,'Query'); 
    
  }
  
  public function DataQuerySingle($accesskey,$associationid,$secreteaccessid,$objectType,$whereClause){
    // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='QuerySingle',$accesskey,$associationid,$secreteaccessid);
     // Construct Body
 
     $body = '<s:Body>
                    <QuerySingle xmlns="http://membersuite.com/contracts">
                    <objectType>'.$objectType.'</objectType>
                    <whereClause>'.$whereClause.'</whereClause>
                    </QuerySingle>
                    </s:Body>
                    ';
    // Replace strings
         
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    $getResult = $this->api->SendSoapRequest($apirequest,$method='QuerySingle');
    return $this->api->createobject($getResult,'QuerySingle'); 
    
  }
  
  public function DownloadFileRequest($accesskey,$associationid,$secreteaccessid,$fileID){
    // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='DownloadFile',$accesskey,$associationid,$secreteaccessid);
     // Construct Body
 
     $body = '<s:Body>
                    <DownloadFile xmlns="http://membersuite.com/contracts">
                    <fileID>'.$fileID.'</fileID>
                    </DownloadFile>
                    </s:Body>
                    ';
    // Replace strings
         
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    $getResult = $this->api->SendSoapRequest($apirequest,$method='DownloadFile');
    return $this->api->createobject($getResult,'DownloadFile'); 
    
  }
  
  public function GetNameRequest($accesskey,$associationid,$secreteaccessid,$recordID){
    // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='GetName',$accesskey,$associationid,$secreteaccessid);
     // Construct Body
 
     $body = '<s:Body>
                    <GetName xmlns="http://membersuite.com/contracts">
                    <recordID>'.$fileID.'</recordID>
                    </GetName>
                    </s:Body>
                    ';
    // Replace strings
         
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    $getResult = $this->api->SendSoapRequest($apirequest,$method='GetName');
    return $this->api->createobject($getResult,'GetName'); 
    
  }
  
  public function GetNamesRequest($accesskey,$associationid,$secreteaccessid,$recordID){
    // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='GetNames',$accesskey,$associationid,$secreteaccessid);
     // Construct Body
     $string = '';
     foreach($recordID as $recordID)
     {
      $string.='<string>'.$recordID.'</string>';
     }
     
     $body = '<s:Body>
                    <GetNames xmlns="http://membersuite.com/contracts">
                    <recordID>'.$string.'</recordID>
                    </GetNames>
                    </s:Body>
                    ';
    // Replace strings
         
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    $getResult = $this->api->SendSoapRequest($apirequest,$method='GetNames');
    return $this->api->createobject($getResult,'GetNames'); 
    
  }
  
  public function DeleteRecord($accesskey,$associationid,$secreteaccessid,$id){
    // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='Delete',$accesskey,$associationid,$secreteaccessid);
     // Construct Body
     $body = '<s:Body>
                    <Delete xmlns="http://membersuite.com/contracts">
                    <id>'.$id.'</id>
                    </Delete>
                    </s:Body>
                    ';
    // Replace strings
         
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    $getResult = $this->api->SendSoapRequest($apirequest,$method='Delete');
    return $this->api->createobject($getResult,'Delete'); 
    
  }
  
  public function GetAutoNumberSeedInfoRequest($accesskey,$associationid,$secreteaccessid,$objectName){
    // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='GetAutoNumberSeedInfo',$accesskey,$associationid,$secreteaccessid);
     // Construct Body
     $body = '<s:Body>
                    <GetAutoNumberSeedInfo xmlns="http://membersuite.com/contracts">
                    <objectName>'.$objectName.'</objectName>
                    </GetAutoNumberSeedInfo>
                    </s:Body>
                    ';
    // Replace strings
         
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    $getResult = $this->api->SendSoapRequest($apirequest,$method='GetAutoNumberSeedInfo');
    return $this->api->createobject($getResult,'GetAutoNumberSeedInfo'); 
    
  }
  
  public function UpdateAutoNumberSeedRequest($accesskey,$associationid,$secreteaccessid,$objectName,$newSeed){
    // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='UpdateAutoNumberSeed',$accesskey,$associationid,$secreteaccessid);
     // Construct Body
     $body = '<s:Body>
                    <UpdateAutoNumberSeed xmlns="http://membersuite.com/contracts">
                    <objectName>'.$objectName.'</objectName>
                    <newSeed>'.$newSeed.'</newSeed>
                    </UpdateAutoNumberSeed>
                    </s:Body>
                    ';
    // Replace strings
         
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    $getResult = $this->api->SendSoapRequest($apirequest,$method='UpdateAutoNumberSeed');
    return $this->api->createobject($getResult,'UpdateAutoNumberSeed'); 
    
  }
  
  public function MergeRequest($accesskey,$associationid,$secreteaccessid,$source,$destination,$sourceFieldsToUse){
    // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='Merge',$accesskey,$associationid,$secreteaccessid);
     // Construct Body
     $body = '<s:Body>
                    <Merge xmlns="http://membersuite.com/contracts">
                    <source>'.$source.'</source>
                    <destination>'.$destination.'</destination>
                    <sourceFieldsToUse>'.$sourceFieldsToUse.'</sourceFieldsToUse>
                    </Merge>
                    </s:Body>
                    ';
    // Replace strings
         
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    $getResult = $this->api->SendSoapRequest($apirequest,$method='Merge');
    return $this->api->createobject($getResult,'Merge'); 
    
  }
  
  public function ValidateMultipleAddressesRequest($accesskey,$associationid,$secreteaccessid,$entityIdentifiers){
    // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='ValidateMultipleAddresses',$accesskey,$associationid,$secreteaccessid);
     // Construct Body
     
     $entity='';
     foreach($entityIdentifiers as $entityIdentifiers)
     {
      $entity.='<string>'.$entityIdentifiers.'</string>';
     }
     
     $body = '<s:Body>
                    <ValidateMultipleAddresses xmlns="http://membersuite.com/contracts">
                    <entityIdentifiers>'.$entity.'</entityIdentifiers>
                    </ValidateMultipleAddresses>
                    </s:Body>
                    ';
    // Replace strings
         
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    $getResult = $this->api->SendSoapRequest($apirequest,$method='ValidateMultipleAddresses');
    return $this->api->createobject($getResult,'ValidateMultipleAddresses'); 
    
  }
  
  public function MassUpdateRequest($accesskey,$associationid,$secreteaccessid,$recordType,$recordIdentifiers,$msoNewValues){
    // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='MassUpdate',$accesskey,$associationid,$secreteaccessid);
     // Construct Body
     $record='';
     foreach($recordIdentifiers as $recordIdentifiers)
     {
      $record.='<string>'.$recordIdentifiers.'</string>';
     }
     
     $body = '<s:Body>
                    <MassUpdate xmlns="http://membersuite.com/contracts">
                    <recordType>'.$recordType.'</recordType>
                    <recordIdentifiers>'.$record.'</recordIdentifiers>
                    <msoNewValues>'.$msoNewValues.'</msoNewValues>
                    </MassUpdate>
                    </s:Body>
                    ';
    // Replace strings
         
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    $getResult = $this->api->SendSoapRequest($apirequest,$method='MassUpdate');
    return $this->api->createobject($getResult,'MassUpdate'); 
    
  }
  
  public function MassDeleteRequest($accesskey,$associationid,$secreteaccessid,$recordType,$recordIdentifiers){
    // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='MassDelete',$accesskey,$associationid,$secreteaccessid);
     // Construct Body
     $record='';
     foreach($recordIdentifiers as $recordIdentifiers)
     {
      $record.='<string>'.$recordIdentifiers.'</string>';
     }
     
     $body = '<s:Body>
                    <MassDelete xmlns="http://membersuite.com/contracts">
                    <recordType>'.$recordType.'</recordType>
                    <recordIdentifiers>'.$record.'</recordIdentifiers>
                    </MassDelete>
                    </s:Body>
                    ';
    // Replace strings
         
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    $getResult = $this->api->SendSoapRequest($apirequest,$method='MassDelete');
    return $this->api->createobject($getResult,'MassDelete'); 
    
  }
  
  public function MassAssignEntitlementsRequest($accesskey,$associationid,$secreteaccessid,$msoEntitlement,$idsToAssign){
    // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='MassAssignEntitlements',$accesskey,$associationid,$secreteaccessid);
     // Construct Body
     $ids='';
     foreach($idsToAssign as $idsToAssign)
     {
      $ids.='<string>'.$idsToAssign.'</string>';
     }
     $objectarr = $this->object_to_array($msoEntitlement);
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
                    <MassAssignEntitlements xmlns="http://membersuite.com/contracts">
                    <msoEntitlement>
                    <mem:ClassType>'.$objectarr['ClassType'].'</mem:ClassType>
                    <mem:Fields>
                    '.$objecttype.'
                    </mem:Fields>
                    </msoEntitlement>
                    <idsToAssign>'.$ids.'</idsToAssign>
                    </MassAssignEntitlements>
                    </s:Body>
                    ';
    // Replace strings
         
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    $getResult = $this->api->SendSoapRequest($apirequest,$method='MassAssignEntitlements');
    return $this->api->createobject($getResult,'MassAssignEntitlements'); 
    
  }
  
  public function RecordErrorAuditLogRequest($accesskey,$associationid,$secreteaccessid,$msoErrorAuditLog){
    // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='RecordErrorAuditLog',$accesskey,$associationid,$secreteaccessid);
     // Construct Body
    
     $objectarr = $this->object_to_array($msoErrorAuditLog);
     $objecttype = '';
     foreach($objectarr as $key=>$value){
       if($key<>'ClassType'){ 
      $objecttype.= '<mem:FieldMetadata>
        <mem:Key>'.$key.'</mem:Key>
        <mem:Value i:type="a:string">'.$value.'</mem:Value>
        </mem:FieldMetadata>';  
       }
      }
     
     $body = '<s:Body>
                    <RecordErrorAuditLog xmlns="http://membersuite.com/contracts">
                    <msoErrorAuditLog>
                    <mem:ClassType>'.$objectarr['ClassType'].'</mem:ClassType>
                    <mem:Fields>
                    '.$objecttype.'
                    </mem:Fields>
                    </msoErrorAuditLog>
                    </RecordErrorAuditLog>
                    </s:Body>
                    ';
    // Replace strings
         
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    $getResult = $this->api->SendSoapRequest($apirequest,$method='RecordErrorAuditLog');
    return $this->api->createobject($getResult,'RecordErrorAuditLog'); 
    
  }
  
  public function ValidateAddressRequest($accesskey,$associationid,$secreteaccessid,$addressToValidate){
    // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='ValidateAddress',$accesskey,$associationid,$secreteaccessid);
     // Construct Body
     $addressvalidate = $this->object_to_array($addressToValidate);
     $address='';
     foreach($addressvalidate as $key=>$value)
     {
      $address.='<'.$key.'>'.$value.'</'.$key.'>';
     }
     
     $body = '<s:Body>
                    <ValidateAddress xmlns="http://membersuite.com/contracts">
                    <addressToValidate>
                    '.$address.'
                    </addressToValidate>
                    </ValidateAddress>
                    </s:Body>
                    ';
    // Replace strings
         
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    $getResult = $this->api->SendSoapRequest($apirequest,$method='ValidateAddress');
    return $this->api->createobject($getResult,'ValidateAddress'); 
    
  }
  
  public function PopulateCityStateFromPostalCodeRequest($accesskey,$associationid,$secreteaccessid,$addressToProcess){
    // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='PopulateCityStateFromPostalCode',$accesskey,$associationid,$secreteaccessid);
     // Construct Body
     $addressvalidate = $this->object_to_array($addressToProcess);
     $address='';
     foreach($addressvalidate as $key=>$value)
     {
      $address.='<'.$key.'>'.$value.'</'.$key.'>';
     }
     
     $body = '<s:Body>
                    <PopulateCityStateFromPostalCode xmlns="http://membersuite.com/contracts">
                    <addressToProcess>
                    '.$address.'
                    </addressToProcess>
                    </PopulateCityStateFromPostalCode>
                    </s:Body>
                    ';
    // Replace strings
         
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    $getResult = $this->api->SendSoapRequest($apirequest,$method='PopulateCityStateFromPostalCode');
    return $this->api->createobject($getResult,'PopulateCityStateFromPostalCode'); 
    
  }
  
  public function GetDefaultDuplicateDetectionRulesRequest($accesskey,$associationid,$secreteaccessid,$recordType){
    // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='GetDefaultDuplicateDetectionRules',$accesskey,$associationid,$secreteaccessid);
     // Construct Body
     $addressvalidate = $this->object_to_array($addressToProcess);
     $address='';
     foreach($addressvalidate as $key=>$value)
     {
      $address.='<'.$key.'>'.$value.'</'.$key.'>';
     }
     
     $body = '<s:Body>
                    <GetDefaultDuplicateDetectionRules xmlns="http://membersuite.com/contracts">
                    <recordType>'.$recordType.'</recordType>
                    </GetDefaultDuplicateDetectionRules>
                    </s:Body>
                    ';
    // Replace strings
         
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    $getResult = $this->api->SendSoapRequest($apirequest,$method='GetDefaultDuplicateDetectionRules');
    return $this->api->createobject($getResult,'GetDefaultDuplicateDetectionRules'); 
    
  }
  
  public function GetObjectBySearchRequest($accesskey,$associationid,$secreteaccessid,$searchToUse,$fieldToUseAsObjectIdentifier='ID'){
    // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='GetObjectBySearch',$accesskey,$associationid,$secreteaccessid);
     // Construct Body
     $search = '';
    $criteria='';
    $grouptype='';
    $search= $this->api->createsearch($searchToUse);
    
    
    $objectidentyfier = $fieldToUseAsObjectIdentifier==''?'ID':$fieldToUseAsObjectIdentifier;
    
     $body = '<s:Body>
                    <GetObjectBySearch xmlns="http://membersuite.com/contracts">
                    <searchToUse>'.$search.'</searchToUse>
                    <fieldToUseAsObjectIdentifier>'.$objectidentyfier.'</fieldToUseAsObjectIdentifier>
                    </GetObjectBySearch>
                    </s:Body>
                    ';
    // Replace strings
         
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    $getResult = $this->api->SendSoapRequest($apirequest,$method='GetObjectBySearch');
    return $this->api->createobject($getResult,'GetObjectBySearch'); 
    
  }
  
  public function GetObjectsBySearchRequest($accesskey,$associationid,$secreteaccessid,$searchToUse,$fieldToUseAsObjectIdentifier='ID',$startRecord,$maximumNumberOfRecordsToReturn){
    // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='GetObjectsBySearch',$accesskey,$associationid,$secreteaccessid);
     // Construct Body
     $search = '';
    $criteria='';
    $grouptype='';
    $search= $this->api->createsearch($searchToUse);
    
    $objectidentyfier = $fieldToUseAsObjectIdentifier==''?'ID':$fieldToUseAsObjectIdentifier;
     $body = '<s:Body>
                    <GetObjectsBySearch xmlns="http://membersuite.com/contracts">
                    <searchToUse>'.$search.'</searchToUse>
                    <fieldToUseAsObjectIdentifier>'.$objectidentyfier.'</fieldToUseAsObjectIdentifier>
                    <startRecord>'.$startRecord.'</startRecord>
                    <maximumNumberOfRecordsToReturn>'.$maximumNumberOfRecordsToReturn.'</maximumNumberOfRecordsToReturn>
                    </GetObjectsBySearch>
                    </s:Body>
                    ';
    // Replace strings
         
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    $getResult = $this->api->SendSoapRequest($apirequest,$method='GetObjectsBySearch');
    return $this->api->createobject($getResult,'GetObjectsBySearch'); 
    
  }
  
  public function FindPotentialDuplicatesRequest($accesskey,$associationid,$secreteaccessid,$mso,$ruleIDs,$spec,$startRecord,$pageSize){
    // Get file content
     $filecontent = $this->api->GetFormat();
     if($filecontent=='Error')
     {
      $errormsg = 'API Request can not be generated';
      return false;
     }
     // Create API Request Headers
     $apirequestheaders = $this->api->ConstructSoapHeaders($filecontent,$method='FindPotentialDuplicates',$accesskey,$associationid,$secreteaccessid);
     // Construct Body
     $search = '';
      $search= $this->api->createsearch($spec);
      $ruleID='';
      
      foreach($ruleIDs as $ruleIDs)
      {
        $ruleID.='<string>'.$ruleIDs.'<string>';
      }
      
      $objectarr = $this->object_to_array($mso);
     $objecttype = '';
     foreach($objectarr as $key=>$value){
       if($key<>'ClassType'){ 
      $objecttype.= '<mem:FieldMetadata>
        <mem:Key>'.$key.'</mem:Key>
        <mem:Value i:type="a:string">'.$value.'</mem:Value>
        </mem:FieldMetadata>';  
       }
      }
      
     $body = '<s:Body>
                    <FindPotentialDuplicates xmlns="http://membersuite.com/contracts">
                    <mso>'.$mso.'
                    <mem:ClassType>'.$objectarr['ClassType'].'</mem:ClassType>
                    <mem:Fields>
                    '.$objecttype.'
                    </mem:Fields>
                    </mso>
                    <ruleIDs>'.$ruleID.'</ruleIDs>
                    <spec>'.$search.'</spec>
                    <startRecord>'.$startRecord.'</startRecord>
                    <pageSize>'.$pageSize.'</pageSize>
                    </FindPotentialDuplicates>
                    </s:Body>
                    ';
    // Replace strings
         
    $apirequest = str_replace('<s:Body></s:Body>',$body,$apirequestheaders);
    // Create Response
    $getResult = $this->api->SendSoapRequest($apirequest,$method='FindPotentialDuplicates');
    return $this->api->createobject($getResult,'FindPotentialDuplicates'); 
    
  }
  
  public function str_replace_last( $search , $replace , $str ) {
        if( ( $pos = strrpos( $str , $search ) ) !== false ) {
            $search_length  = strlen( $search );
            $str    = substr_replace( $str , $replace , $pos , $search_length );
        }
        return $str;
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