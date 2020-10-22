

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
