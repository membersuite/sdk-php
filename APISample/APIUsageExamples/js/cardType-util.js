var membersuite = membersuite || {};
membersuite.cardTypeUtil = membersuite.cardTypeUtil || {};

membersuite.cardTypeUtil = (function () {
    var cardTypes = {
        americanExpress: { prefix: ['34', '37'], ccLength: [15] },
        dinersClub: { prefix: ['300', '301', '302', '303', '304', '305', '36', '38'], ccLength: [14] },
        discover: { prefix: ['6011'], ccLength: [16] },
        jcb: { prefix: ['35', '2131', '1800'], ccLength: [16, 15] },
        masterCard: { prefix: ['51', '52', '53', '54', '55'], ccLength: [16] },
        visa: { prefix: ['4'], ccLength: [13, 16] }
    }

    var cleanCard = function (card) {
        var cardNo = card.replace(/ /g, '').replace(/-/g, '');
        return cardNo;
    };

    var filterCards = function (parms) {
        var isSelectedCard = false;
        var prefixArr = cardTypes[parms.ccType].prefix;
        var prefixArrLength = prefixArr.length;
        for (var cardPrefix = 0; cardPrefix < prefixArrLength; cardPrefix++) {
            var prefix = prefixArr[cardPrefix];
            if (parms.firstFour.indexOf(prefix) > -1) {
                isSelectedCard = true;
                break;
            }
        }
        return isSelectedCard;
    };

    var creditCardType = function (card) {
        var isValid = (card.length < 13 || typeof (parseInt(card)) !== 'number') ? false : true;
        if (!isValid) return 'invalidCardType';

        var ccType = 'unknown';
        var cardNo = cleanCard(card);
        var firstFour = cardNo.substring(0, 4);
        var cardLength = cardNo.length;
        var possibleCards = [];

        for (var type in cardTypes) {
            var cctype = type;
            var ccLength = cardTypes[type].ccLength;
            var ccArrLength = cardTypes[type].ccLength.length;
            for (var cLength = 0; cLength < ccArrLength; cLength++) {
                if (ccLength[cLength] === cardLength) possibleCards.push(cctype);
            }
        }

        var possibleCardsLength = possibleCards.length;

        if (possibleCardsLength > 1) {
            for (var i = 0; i < possibleCardsLength; i++) {
                var actualCard = possibleCards[i];
                var pCard = cardTypes[possibleCards[i]];
                var pCardPrefixes = pCard.prefix;
                var pCardPrefixesLength = pCardPrefixes.length;
                var selectedCard = 'unknown';

                for (var j = 0; j < pCardPrefixesLength; j++) {
                    var selected = 'unknown';
                    var prefix = pCardPrefixes[j];
                    switch (prefix) {
                        case '34', '37':
                            if (filterCards({ firstFour: firstFour, ccType: actualCard })) {
                                selected = actualCard;
                            }
                            break;
                        case '300', '301', '302', '303', '304', '305', '36', '38':
                            if (filterCards({ firstFour: firstFour, ccType: actualCard })) {
                                selected = actualCard;
                            }
                            break;
                        case '51', '52', '53', '54', '55':
                            if (filterCards({ firstFour: firstFour, ccType: actualCard })) {
                                selected = actualCard;
                            }
                            break;
                        case '35', '2131', '1800':
                            if (filterCards({ firstFour: firstFour, ccType: actualCard })) {
                                selected = actualCard;
                            }
                            break;
                        case '6011':
                            if (filterCards({ firstFour: firstFour, ccType: actualCard })) {
                                selected = actualCard;
                            }
                            break;
                        case '4':
                            if (filterCards({ firstFour: firstFour, ccType: actualCard })) {
                                selected = actualCard;
                            }
                            break;
                    };

                    if (selected != 'unknown') {
                        selectedCard = selected;
                        break;
                    }
                };

                if (selectedCard != 'unknown') {
                    ccType = selectedCard;
                    break;
                }
            };
        } else {
            ccType = possibleCards[0];
        };

        return ccType;
    };


    return {
        getType: creditCardType
    }
})();