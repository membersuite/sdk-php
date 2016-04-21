$(document).ready(function () {
    $("input[id$='CardNumber']").attr('maxLength', 16);
    $("input[id$='CCV']").attr('maxLength', 4);
    $("input[id$='CardNumber'],input[id$='CCV']").bind('keypress', function (e) {
        var k = e.which || e.keyCode;
        var allow = [8, 9, 13, 27,36, 37, 38, 39, 40, 46,118];
        var sKey = String.fromCharCode(k);

        if (sKey !== "" && $.inArray(k, allow) < 0 && !sKey.match(/[0-9]/)) {
            e.preventDefault();
        }
    });
});


var membersuite = membersuite || {};
membersuite.ajaxAPI = membersuite.ajaxAPI || {};

membersuite.ajaxAPI = (function ($) {
    function persistToken(parms) {
        parms.$cardNumberElem.val(parms.vaultToken).hide();
        $(parms.saveBtnId).trigger("click");
        return true;
    };

    return {
        persistToken: persistToken
    }
})(jQuery);