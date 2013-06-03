<?php
/*
 This class is used to create request and generate response.
 Created Date: 02/April/2013
 Created By: SmartdataInc.
*/

$filedir = dirname(__FILE__);
$filedir = substr($filedir,0,-7);
include_once($filedir.'lib/Config.php');
include_once($filedir.'lib/Curl.php');

class Concierge{
    
    function __construct(){
     $this->crypt = new CryptoManager(); 
      
    }
    
    // Get Request Format
  
  protected function Getformat(){
   
    $filecontent = Config::read("Commonxml");
    /*
     if(!file_exists($filepath)){      
      $error = 'Error';
      return $error;    
    }
    $filecontent = file_get_contents($filepath);
    */
    return $filecontent;
  }
  
   // This function to construct SOAP Action and Headers
  protected function ConstructSoapHeaders($xmlformat,$method,$accesskey,$associationid,$SecretAccessKey){
    
   $action = "http://membersuite.com/contracts/IConciergeAPIService/$method";
   $messagesignature = $this->crypt->GenerateMessageSignature($method, $SecretAccessKey, $associationid, $SessionId = "");
    // Values that needs to be changed   
    $replacearr = array('<Action></Action>',
                        '<AccessKeyId></AccessKeyId>',
                        '<AssociationId></AssociationId>',
                        '<Signature></Signature>',
                        );
    // By these values
    $replacevalue = array('<Action>'.$action.'</Action>',
                          '<AccessKeyId>'.$accesskey.'</AccessKeyId>',
                          '<AssociationId>'.$associationid.'</AssociationId>',
                          '<Signature>'.$messagesignature.'</Signature>',
                          );
         
    // Replace strings
    $apiheaderrequest = str_replace($replacearr,$replacevalue,$xmlformat);
    return $apiheaderrequest;
  } 
   
   // This function sends the request api to the Concierge Server
  protected function SendSoapRequest($requestapi,$method){
    
    // Calling cURL class
    $curl = new Curl();
    $curl->url = 'https://api.membersuite.com';
    $curl->header = array (
           "SOAPAction:http://membersuite.com/contracts/IConciergeAPIService/$method",
           'Content-Type: text/xml; charset=utf-8',
          ); 
    $curl->postdata = $requestapi;
    $result = $curl->init();
    return $result;      
  }
  
  protected function createobject($xmlresponse,$method){
    
   $string = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xmlresponse);
   $xml = simplexml_load_string($string);
   $json = json_encode($xml);
   $responseObject = json_decode($json,False);
   
   if(isset($responseObject->sBody->sFault->faultstring))
   {
    return $responseObject->sBody->sFault->faultstring;
   }
   else
   {
   $response = $method.'Response';
   $gvresponse = $method.'Result';
   
   return $responseObject->sBody->$response->$gvresponse;
   }
  }
  
  
  protected function createsearch($searchToUse)
  {
    $search = '';
    if($searchToUse->Criteria)
    {
        $search.='<b:Criteria>';
        foreach($searchToUse->Criteria as $criteria)
        {
            
            if(isset($criteria->Criteria))
            {
                $search.='<b:Criteria>';
               foreach($criteria->Criteria as $objcriteria)
               {
                $search.='<b:SearchOperation i:type="c:'.$objcriteria['Type'].'" xmlns:c="http://schemas.datacontract.org/2004/07/MemberSuite.SDK.Searching.Operations">
                <b:FieldName>'.$objcriteria['FieldName'].'</b:FieldName>
                <b:ValuesToOperateOn xmlns:d="http://schemas.microsoft.com/2003/10/Serialization/Arrays">';
                $value= $objcriteria['Value'];
                if(is_array($value))
                {
                foreach($value as $value)
                {
                $search.='<d:anyType i:type="a:string">'.$value.'</d:anyType>';  
                }
                }
                else
                {
                $search.='<d:anyType i:type="a:string">'.$value.'</d:anyType>';  
                }
                
                $search.='</b:ValuesToOperateOn></b:SearchOperation>';
                }
                $search.='</b:Criteria>';
                
                if(isset($criteria->GroupType))
                {
                    foreach($criteria->GroupType as $GroupType)
                    {
                        $search.='<b:GroupType>'.$GroupType['GroupType'].'</b:GroupType>';    
                    }
                }
                else
                {
                    $search.='<b:GroupType>And</b:GroupType>'; 
                }
                
            }
            else
            {
                $search.='<b:SearchOperation i:type="c:'.$criteria['Type'].'" xmlns:c="http://schemas.datacontract.org/2004/07/MemberSuite.SDK.Searching.Operations">
                <b:FieldName>'.$criteria['FieldName'].'</b:FieldName>
                <b:ValuesToOperateOn xmlns:d="http://schemas.microsoft.com/2003/10/Serialization/Arrays">';
                $value= $criteria['Value'];
                if(is_array($value))
                {
                 foreach($value as $value)
                 {
                     $search.='<d:anyType i:type="a:string">'.$value.'</d:anyType>';  
                 }
                }
                else
                {
                 $search.='<d:anyType i:type="a:string">'.$value.'</d:anyType>';  
                }
                
                $search.='</b:ValuesToOperateOn></b:SearchOperation>';
                
                }
                
            }
         $search.='</b:Criteria>';   
    }
    else
    {
        $search.='<b:Criteria></b:Criteria>';
    }
    
    if($searchToUse->GroupType)
    {
        foreach($searchToUse->GroupType as $GroupType)
        {
            $search.='<b:GroupType>'.$GroupType['GroupType'].'</b:GroupType>';    
        }
        
    }
    else
    {
        $search.='<b:GroupType>And</b:GroupType>';
    }
    
    if($searchToUse->OutputColumn)
    {
        $search.='<b:OutputColumns>';
        foreach($searchToUse->OutputColumn as $outputcoloumn)
        {
            $search.='<b:SearchOutputColumn><b:AggregateFunction>'.$outputcoloumn['Aggregate'].'</b:AggregateFunction><b:ColumnWidth>0</b:ColumnWidth>';
            $search.='<b:DisplayName>'.$outputcoloumn['ColoumnName'].'</b:DisplayName><b:Hidden>false</b:Hidden><b:Name>'.$outputcoloumn['ColoumnName'].'</b:Name></b:SearchOutputColumn>';
        }
        $search.='</b:OutputColumns>';
    }
    else
    {
        $search.='<b:OutputColumns></b:OutputColumns>';
    }
    
    if($searchToUse->Sortcolumn)
    {
        $search.='<b:SortColumns>';
        foreach($searchToUse->Sortcolumn as $SortColumn)
        {
            $search .= '<b:SearchSortColumn><b:IsDescending>'.$SortColumn['isDescending'].'</b:IsDescending>';
            $search .='<b:Name>'.$SortColumn['ColoumnName'].'</b:Name></b:SearchSortColumn>';
        }
        $search.='</b:SortColumns>';
        
    }
    else
    {
        $search.='<b:SortColumns></b:SortColumns>';
    }
    $search.='<b:Type>'.$searchToUse->Type.'</b:Type>';
    return $search;
  }
}

?>