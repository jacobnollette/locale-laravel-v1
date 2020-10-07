(function ($) {

    var hash = window.location.hash.substr(1);
    var results = hash.split('&').reduce(function (result, item) {
        var parts = item.split('=');
        result[parts[0]] = parts[1];
        return result;
    }, {});
    var input = {
        "access_token": results.access_token,
        "token_type": results.token_type,
        "expires_in": results.expires_in,
        "token_type": results.token_type
    }
    var url = "/spotify/input";
    $.post(url, input, function (success) {
        console.log(success);
    });


})(jQuery);

