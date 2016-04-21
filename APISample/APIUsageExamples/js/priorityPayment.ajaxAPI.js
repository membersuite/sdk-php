var membersuite = membersuite || {};
membersuite.priorityPaymentAjaxAPI = membersuite.priorityPaymentAjaxAPI || {};

membersuite.priorityPaymentAjaxAPI = (function ($, logger, cardTypeUtil) {
    var successData = {}, logObj = logger.logObj, token;

    var makeRequest = function (options) {
        logObj = logger.init({ logger: logObj, name: options.methodName });

        if ('XDomainRequest' in window && window.XDomainRequest !== null) {
            var deferred = $.Deferred();
            var xdr = new XDomainRequest();

            xdr.open("POST", options.url);

            xdr.onload = function () {
                logObj = logger.log({ logger: logObj, isSuccess: true, response: $.parseJSON(xdr.responseText) });
                logger.post({ logger: logObj, isXhr: true });
                options.success($.parseJSON(xdr.responseText));
                json = xdr.responseText;
                parsed_json = $.parseJSON(options.data);
                deferred.resolve(parsed_json);
                successData = xdr.responseText;
            }

            xdr.onerror = function () {
                logObj = logger.log({ logger: logObj, isSuccess: false, response: $.parseJSON(xdr) });
                logger.post({ logger: logObj, isXhr: true });
                options.error(xdr);
                alert('An unknown error has occurred.');
            }

            xdr.send(options.data);
            return deferred;
        } else {
            return $.ajax({
                url: options.url,
                headers: options.headers,
                contentType: options.contentType,
                method: options.method,
                dataType: options.dataType,
                data: options.data,
                success: function (response) {
                    logObj = logger.log({ logger: logObj, isSuccess: true, response: response });
                    logger.post({ logger: logObj, isXhr: false });
                    successData = response;
                    options.success(response);
                },
                error: function (response) {
                    logObj = logger.log({ logger: logObj, isSuccess: false, response: response.responseText });
                    logger.post({ logger: logObj, isXhr: false });
                    options.error(response);
                    var errMsg = JSON.parse(response.responseText);
                    alert(errMsg.details);
                }
            });
        }
    };

    var createCustomerVaultToken = function (parms) {
        var self = this;
        logObj.guid = parms.guid;
        logObj.logUrl = parms.logUrl;

        self.options = {
            url: parms.uri + 'vault/customer?token=' + parms.requestToken,
            methodName: 'createCustomerVaultToken',
            headers: {
                'Content-Type': 'application/json'
            },
            contentType: 'application/json; charset=utf-8',
            method: 'POST',
            dataType: 'json',
            data: parms.data,
            success: function (response) {
                token = response;
            },
            error: function (response) {
                //do whatever work you want on error
            }
        }

        $.when(makeRequest(self.options)).then(function () {
            var ocn = parms.originalCardNumber;
            var lastFour = ocn.substring(ocn.length - 4);
            var cardType = cardTypeUtil.getType(ocn);
            return parms.callback({ isSuccessful: true, vaultToken: token.id + '|' + token.cardAccount.token + '|' + lastFour + '|' + cardType });
        })
        .fail(function () {
            //do whatever work you want on failure
        });
    };

    var createVaultToken = function (parms) {
        var self = this;
        logObj.guid = parms.guid;
        logObj.logUrl = parms.logUrl;

        self.options = {
            url: parms.uri + 'vault?token=' + parms.requestToken + '&customerId=' + parms.customerId,
            methodName: 'createVaultToken',
            headers: {
                'Content-Type': 'application/json'
            },
            contentType: 'application/json; charset=utf-8',
            method: 'POST',
            dataType: 'json',
            data: parms.data,
            success: function (response) {
                token = response;
            },
            error: function (response) {
                //do whatever work you want on error
            }
        }

        $.when(makeRequest(self.options)).then(function () {
            var ocn = parms.originalCardNumber;
            var lastFour = ocn.substring(ocn.length - 5);
            var cardType = cardTypeUtil.getType(ocn);
            return parms.callback({ isSuccessful: true, vaultToken: parms.customerId + '|' + token + '|' + lastFour + '|' + cardType });
        })
        .fail(function () {
            //do whatever work you want on failure
        });
    };

    return {
        createCustomerVaultToken: createCustomerVaultToken,
        createVaultToken: createVaultToken
    };

})(jQuery, membersuite.paymentProcessorLogger, membersuite.cardTypeUtil);