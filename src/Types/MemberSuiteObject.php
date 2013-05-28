<?php
/*
 MemberSuite Object
*/
class Membersuiteobjects
{
    
    public function FromClassMetadata($resultobject)
    {
        $metadataarray = array();
        
        $responsearr = $this->object_to_array($resultobject);
        
        $metadataarray['ClassType'] = $responsearr['Name'];
        
        if($responsearr['bFields']['bFieldMetadata'])
        $resultset = $responsearr['bFields']['bFieldMetadata'];
        else if($responsearr['bFields']['bKeyValueOfstringanyType'])
        $resultset = $responsearr['bFields']['bKeyValueOfstringanyType'];
        
        foreach($resultset as $key)
        {
            $metadataarray[$key['bName']] = $key['bDefaultValue'];
            
        }
        
        return $metadataarray;
        
    }
    
    private function object_to_array($data) 
    {
    if ((! is_array($data)) and (! is_object($data))) return 'xxx'; //$data;
    
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