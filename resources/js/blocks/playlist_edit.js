function playlist_edit_map() {
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


    /**
     * get location lat/long
     */

    if ( $("#playlist_location").data("lat") == 0 && $("#playlist_location").data("long ") == 0 ) {
        //  process text field
    } else {
        /**
         * we have a field,
         * go into map logic
         */

        //  input queue
        var _input_latlong = [
            $("#playlist_location").data("lat"),
            $("#playlist_location").data("long")
        ];

        //  map init
        var mymap = L.map('playlists_edit-map').setView(_input_latlong, 13);
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            dragging: false,
            accessToken: 'pk.eyJ1IjoiamFjb2Jub2xsZXR0ZSIsImEiOiJja2dpeW9rMzgxanVuMnJycjNqcjNsaHFpIn0.XQXUgLDmOs15mHZiey4YmA'
        }).addTo(mymap);

        /**
         * marker logic
         */
        mymap.on('click', function (ev) {
            L.marker(ev.latlng).addTo(mymap);
            //alert(); // ev is an event object (MouseEvent in this case)
        });
    }  //  end of map if statement






}

if ($("#playlists_edit").length > 0) {
    playlist_edit_map();
}
