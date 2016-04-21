var membersuite = membersuite || {};
membersuite.paymentProcessorLogger = membersuite.paymentProcessorLogger || {};

membersuite.paymentProcessorLogger = (function () {
    var logistics = {
        guid: 0,
        methodName: null,
        success: null,
        response: '',
        startTime: null,
        completedTime: null,
        duration: '',
        logMsg: '',
        logUrl: ''
    };

    var initialize = function (parms) {
        parms.logger.startTime = new Date().getTime();
        parms.logger.methodName = parms.name;
        return parms.logger;
    };

    var elapseTime = function (parms) {
        var time = (parms.logger.completedTime - parms.logger.startTime) / 1000;
        var secNum = parseInt(time, 10);
        var hours = Math.floor(secNum / 3600);
        var minutes = Math.floor((secNum - (hours * 3600)) / 60);
        var seconds = secNum - (hours * 3600) - (minutes * 60);
        var milliseconds = 0;
        if (hours <= 0 && minutes <= 0 && seconds <= 0)
            milliseconds = parseInt(parseFloat(time.toFixed(2)).toString().replace('0.', ''), 10);
        if (hours < 10) { hours = "0" + hours; }
        if (minutes < 10) { minutes = "0" + minutes; }
        if (seconds < 10) { seconds = "0" + seconds; }
        if (milliseconds < 10) { milliseconds = "0" + milliseconds; }
        var format = hours + ':' + minutes + ':' + seconds + ':' + milliseconds;
        parms.logger.duration = format;
        return parms.logger;
    };

    var formatLog = function (logger) {
        var successMsg = 'Portal Priority Payments API call was successful. | ';
        var errorMsg = 'Portal Priority Payments API response from the server was ' + logger.response + '. | ';
        var output = '';
        output += 'Priority Payment API call: ' + logger.methodName + '. | ';
        output += logger.success ? 'was successful. | ' : 'failed. | ';
        output += 'The call lasted ' + logger.duration + ' and was made by user ' + logger.guid + '. | ';
        output += logger.success ? successMsg : errorMsg;
        logger.logMsg = output;
        return logger;
    };

    var postLog = function (parms) {
        if (parms.isXhr) {
            var xdr = new XDomainRequest();
            xdr.open("POST", parms.logger.logUrl);
            xdr.onload = function () {
                console.log(xdr);
            };
            xdr.onerror = function () {
                console.log(xdr);
            };
            //xdr.send(parms.logger.logMsg);
        } else {
            var success = function (response) {
                console.log('logger logged');
            };
            //$.post(parms.logger.logUrl, parms.logger.logMsg, success);
        }
    };

    var completeLog = function (parms) {
        parms.logger.completedTime = new Date().getTime();
        parms.logger.success = parms.isSuccess;
        parms.logger.response = parms.response;
        parms.logger = elapseTime({ logger: parms.logger });
        parms.logger = formatLog(parms.logger);
        return parms.logger;
    };

    return {
        logObj: logistics,
        init: initialize,
        log: completeLog,
        post: postLog
    };
})();