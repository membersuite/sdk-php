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
