//require('./bootstrap');
require('./vendor/leaflet');
/**
 * Dashboard index stuff
 */
$("#playlists_index .playlist_add").each(function(i, obj) {
    /**
     * playlist html, content fix
     */
    if ( $(this).hasClass("in_crate") ) {
        $(this).html("Unshare Playlist");
    }
})

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

    if ($(this).hasClass("in_crate")) {
        //  playlist in crate, removing
        $(this).html("Share Playlist");
        $(this).toggleClass("in_crate");
        var url = "/dashboard/playlist/remove";
    } else {
        //  playlist not in crate, adding
        $(this).html("Unshare Playlist");
        $(this).toggleClass("in_crate");
        var url = "/dashboard/playlist/add";
    }

    var request = {
        "playlist": _the_playlist_id
    };

    /**
     * post to dashboard endpoint
     */
    var csrf = document.querySelector('meta[name="csrf-token"]').content;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-Token', csrf);
    xhr.send(JSON.stringify(request));
    xhr.onload = function() {
        console.log( this.responseText );
        // _return = JSON.parse( this.responseText );
    }
});


/**
 * Explorer index stuff
 */
$("#explorer_index .playlist_add").each(function(i, obj) {
    /**
     * playlist html, content fix
     */
    if ( $(this).hasClass("in_library") ) {
        $(this).html("Remove Playlist");
    }
})

$("#explorer_index .playlist_add").on("click", function ( e ) {
    /**
     * prevent the browser from going to the anchor
     */
    e.preventDefault();

    /**
     * get the variables setup
     */
    var _the_playlist = $(this).parent().parent().parent();
    var _the_playlist_id = _the_playlist.data("playlist_id");

    if ($(this).hasClass("in_library")) {
        //  playlist in crate, removing
        $(this).html("Follow Playlist");
        $(this).toggleClass("in_library");
        var url = "/dashboard/explore/remove";
    } else {
        //  playlist not in crate, adding
        $(this).html("Unfollow Playlist");
        $(this).toggleClass("in_library");
        var url = "/dashboard/explore/add";
    }

    var request = {
        "playlist": _the_playlist_id
    };

    /**
     * post to dashboard endpoint
     */
    var csrf = document.querySelector('meta[name="csrf-token"]').content;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-Token', csrf);
    xhr.send(JSON.stringify(request));
    xhr.onload = function() {
        console.log( this.responseText );
        // _return = JSON.parse( this.responseText );
    }
});


function playlist_edit_map () {
    /**
     * we're going to verify the lat,lung from these three words
     * then we're going to display the location, or center the map on minneapolis
     */

    /**
     * basic variables for request
     */
    // var csrf = document.querySelector('meta[name="csrf-token"]').content;
    // var _location_url = "/playlist/location";
    // var _location_first = {
    //     "location": "darker.melt.fake"
    // };
    // var xhr = new XMLHttpRequest();
    // xhr.open("POST", _location_url, true);
    // xhr.setRequestHeader('Content-Type', 'application/json');
    // xhr.setRequestHeader('X-CSRF-Token', csrf);
    // xhr.send(JSON.stringify(request));
    // xhr.onload = function() {
    //     console.log( this.responseText );
    //     // _return = JSON.parse( this.responseText );
    // }





    //
    //
    // var mymap = L.map('playlists_edit-map').setView([44.956790, -93.274680], 13);
    // L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    //     attribution: 'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    //     maxZoom: 18,
    //     id: 'mapbox/streets-v11',
    //     tileSize: 512,
    //     zoomOffset: -1,
    //     dragging: false,
    //     accessToken: 'pk.eyJ1IjoiamFjb2Jub2xsZXR0ZSIsImEiOiJja2dpeW9rMzgxanVuMnJycjNqcjNsaHFpIn0.XQXUgLDmOs15mHZiey4YmA'
    // }).addTo(mymap);
    //
    // mymap.scrollWheelZoom.disable()
    // mymap.on('click', function(ev) {
    //     L.marker( ev.latlng ).addTo(mymap);
    //     //alert(); // ev is an event object (MouseEvent in this case)
    // });

}

if ( $("#playlists_edit").length > 0 ) {
    playlist_edit_map();
}
