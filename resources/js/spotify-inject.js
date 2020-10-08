require('./bootstrap');

var hash = window.location.hash.substr(1);

var result = hash.split('&').reduce(function (result, item) {
    var parts = item.split('=');
    result[parts[0]] = parts[1];
    return result;
}, {});
var input = {
    "access_token": result.access_token,
    "token_type": result.token_type,
    "expires_in": result.expires_in,
    "token_type": result.token_type
}

console.log( input );

var csrf = document.querySelector('meta[name="csrf-token"]').content;

var url = "/spotify/input";
var xhr = new XMLHttpRequest();
xhr.open("POST", url, true);
xhr.setRequestHeader('Content-Type', 'application/json');
xhr.setRequestHeader('X-CSRF-Token', csrf);
xhr.send(JSON.stringify(input));
xhr.onload = function() {
    console.log("HELLO")
    console.log(this.responseText);
}

