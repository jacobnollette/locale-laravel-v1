//require('./bootstrap');

var _playlists_index = document.getElementById("playlists_index");
//_playlists_index = _playlists_index.querySelectorAll(".playlist");

$("#playlists_index .playlist_add").on("click", function ( e ) {
    /**
     * prevent the browser from going to the anchor
     */
    e.preventDefault();

    /**
     * get the variables setup
     */
    var _the_playlist = $(this).parent().parent().parent();
    var _the_playlist_id = _the_playlist.data("playlist_id");


    var request = {
        "playlist": _the_playlist_id
    };

    /**
     * post to dashboard endpoint
     */
    var csrf = document.querySelector('meta[name="csrf-token"]').content;
    var url = "/dashboard/playlist/add";
    var xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-Token', csrf);
    xhr.send(JSON.stringify(request));
    xhr.onload = function() {
        console.log( this.responseText );
         // _return = JSON.parse( this.responseText );
         // console.log( _return);
        // var redirect_url = _return.redirect_url;
        // window.location.href = redirect_url;
        //console.log( redirect_url );
    }

});
