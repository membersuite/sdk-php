<?php
/*
Membersuite Address Object
*/

class Address
{
    var $Company;
    var $Line1;
    var $Line2;
    var $City;
    var $State;
    var $PostalCode;
    var $Country;
    var $County;
    var $CongressionalDistrict;
    var $CASSCertificationDate;
    var $CarrierRoute;
    var $DeliveryPointCode;
    var $DeliveryPointCheckDigit;
    var $GeocodeLat;
    var $GeocodeLong;
    var $LastGeocodeDate;
    
}

class EmailTemplate
{
      var $SenderID;
      var $DisplayName;
      var $SearchType;
      var $SearchContext;
      var $FromName;
      var $To;
      var $Cc;
      var $Bcc;
      var $Subject;
      var $HtmlBody;
      var $TextBody;
      var $ReplyTo;
}

class ClassMetadataOverride
{
    var $Name;
    var $Module;
    var $Createable;
    var $Updateable;
    var $Deletable;
    var $Label;
    var $LabelPlural;
    var $IsAbstract;
    var $IsSecurable;
    var $Fields;// list of fields
    var $ValidationRules;// list validation rules
    var $FieldCalculationRules;// list of calculation rules
}

class ValidationRule
{
    var $Name;
    var $Expression;
    var $ErrorMessage;
    var $IsActive;
}

class FieldCalculationRule
{
    var $Name;
    var $IsActive;
    var $TargetField;
    var $EvaluationOrder;
    var $Expression;
    var $Criteria;
    var $SkipIfTargetFieldIsSet;
    var $RunOnNewRecordsOnly;
    var $Notes;
    
}

?>
