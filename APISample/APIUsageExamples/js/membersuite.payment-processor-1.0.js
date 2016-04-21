var membersuite = membersuite || {};
membersuite.paymentProcessor = membersuite.paymentProcessor || {};

membersuite.paymentProcessor = (function ($, ppAPI, msAPI) {
    var
        ppConfig = {
            IsPreferredConfigured: false,
            CustomerID: "0",
            AccessToken: "0",
            EndpointUri: '',
            LoggingUri: ''
        },
        msConfig = {
            guid: '',
            $cardNumberElem: null,
            $expiryMonthElem: null,
            $expiryYearElem: null,
            saveBtnId: null,
            postback: null

        },
        originalCardNum = '',
        saveLastUnderscore = false;

    function init(parms) {
        ppConfig = parms.ppConfig;
        msConfig = parms.msConfig;
        if (parms.hasOwnProperty('saveLastUnderscore'))
            saveLastUnderscore = parms.saveLastUnderscore;
        ppConfig.CustomerID == null ? createCustomerAndCard() : addCardToCustomer();
        console.log(1);
        console.log(ppConfig);
        console.log(2);
    };

    function vaultTokenCreated(response) {
        if (response.isSuccessful) {
            var parms = {
                vaultToken: response.vaultToken,
                saveBtnId: msConfig.saveBtnId,
                postback: msConfig.postback,
                originalCardNumber: originalCardNum,
                $cardNumberElem: msConfig.$cardNumberElem,
                saveLastUnderscore: saveLastUnderscore,
                logUrl: ppConfig.LoggingUri
            };
            msAPI.persistToken(parms);
        }
        return true;
    };

    function addCardToCustomer() {
        var cardNumber = msConfig.$cardNumberElem.val();
        var expiryMonth = msConfig.$expiryMonthElem.val();
        var expiryYear = msConfig.$expiryYearElem.val();
        originalCardNum = cardNumber;

        var payload = {
            "number": cardNumber,
            "expiryMonth": expiryMonth,
            "expiryYear": expiryYear
        };

        var jsonFormData = JSON.stringify(payload);

        var parms = {
            guid: msConfig.guid,
            data: jsonFormData,
            requestToken: ppConfig.AccessToken,
            customerId: ppConfig.CustomerID,
            uri: ppConfig.EndpointUri,
            postback: msConfig.postback,
            originalCardNumber: originalCardNum,
            callback: vaultTokenCreated,
            logUrl: ppConfig.LoggingUri
        }

        //start progress animation
        ppAPI.createVaultToken(parms);
    };

    function createCustomerAndCard(response) {
        var cardNumber = msConfig.$cardNumberElem.val();
        var expiryMonth = msConfig.$expiryMonthElem.val();
        var expiryYear = msConfig.$expiryYearElem.val();
        originalCardNum = cardNumber;





        var payload = {
            "number": msConfig.guid,
            "customerType": ppConfig["CustomerType"],//"person",
            "name": ppConfig["Name"],
            "firstName": ppConfig["FirstName"],
            "lastName": ppConfig["LastName"],
            "email": ppConfig["EmailAddress"],
            "addressName": ppConfig["AddressName"],
            "address1": ppConfig["Address1"],
            "city": ppConfig["City"],
            "state": (ppConfig["State"] ? ppConfig["State"] :'No State/Province' ),
            "zip": ppConfig["Zip"],
            "cardAccount": {
                "number": cardNumber,
                "expiryMonth": expiryMonth,
                "expiryYear": expiryYear,
            }
        }

        var jsonFormData = JSON.stringify(payload);

        var parms = {
            guid: msConfig.guid,
            data: jsonFormData,
            requestToken: ppConfig.AccessToken,
            uri: ppConfig.EndpointUri,
            saveBtnId: msConfig.saveBtnId,
            originalCardNumber: originalCardNum,
            callback: vaultTokenCreated,
            logUrl: ppConfig.LoggingUri
        }

        //start progress animation
        ppAPI.createCustomerVaultToken(parms);
    };

    return {
        init: init
    };
})(jQuery, membersuite.priorityPaymentAjaxAPI, membersuite.ajaxAPI);
