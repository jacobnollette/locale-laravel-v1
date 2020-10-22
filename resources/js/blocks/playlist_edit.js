function playlist_edit_load_map(location, initial) {

    //  map init
    var mymap = L.map('playlists_edit-map').setView(location, 13);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: 'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        dragging: false,
        accessToken: 'pk.eyJ1IjoiamFjb2Jub2xsZXR0ZSIsImEiOiJja2dpeW9rMzgxanVuMnJycjNqcjNsaHFpIn0.XQXUgLDmOs15mHZiey4YmA'
    }).addTo(mymap);


    var _add_marker = function (latlng) {
        /**
         * place marker in the database
         */
        var csrf = document.querySelector('meta[name="csrf-token"]').content;

        /**
         * add market to map
         */
        L.marker(latlng).addTo(mymap);

        /**
         * post location to database
         */
        var _given_url = window.location;
        _given_url = _given_url.pathname.split('/');
        var playlist_id = _given_url[2];
        var _location_url = "/playlist/" + playlist_id + "/update";
        console.log( _location_url );
        var _request = {
            "location": latlng
        }
        var xhr = new XMLHttpRequest();
        xhr.open("POST", _location_url, true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-Token', csrf);
        xhr.send(JSON.stringify(_request));
        xhr.onload = function () {
            /**
             * return
             */
            //console.log( this );
            //_return = JSON.parse(this.responseText);
            //console.log( _return );
        }
    }

    if (initial) {
        alert("Click a more specific location for your playlist");
        mymap.on('click', function (ev) {
            _add_marker(ev.latlng);
        });
    } else {
        /**
         * place mark marker logic
         */
        L.marker(location).addTo(mymap);
    }
}


function playlist_edit_map() {
    /**
     * we're going to verify the lat,lung from these three words
     * then we're going to display the location, or center the map on minneapolis
     */

    /**
     * basic variables for request
     */


    /**
     * get location lat/long
     */

    if ($("#playlist_location").data("lat") == 0 && $("#playlist_location").data("long") == 0) {
        //  process text field
        $('#playlists_edit-location_form').on('submit', function (e) {

            /**
             * validation code here
             */


            /**
             * remove previous list items, and start fresh
             */
            $("#playlist_edit-location_list ul li").remove();


            var request = {
                "location": $("#playlist_edit-location_field").val(),
                "limit": 5
            };
            var csrf = document.querySelector('meta[name="csrf-token"]').content;
            var _location_url = "/utility/location/get";
            var xhr = new XMLHttpRequest();
            xhr.open("POST", _location_url, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-Token', csrf);
            xhr.send(JSON.stringify(request));
            xhr.onload = function () {
                /**
                 * return
                 */
                _return = JSON.parse(this.responseText);
                //console.log( _return );

                _return.data.forEach(function (e) {
                    li_element = "<li data-lat=\"" + e.latitude + "\" data-long=\"" + e.longitude + "\"><a href=\"#\">" + e.label + "</li>";
                    $("#playlist_edit-location_list ul").append(li_element);
                })
                $("#playlist_edit-location_list ul li a").click(function (e) {
                    e.preventDefault();
                    _location = [
                        $(this).parent().data("lat"),
                        $(this).parent().data("long")
                    ];
                    $("#playlists_edit-location").hide();
                    playlist_edit_load_map(_location, true);
                    //alert("general location provide; please click for exact location");

                })
                // var _input_latlong = [
                //     _return.data[0].latitude,
                //     _return.data[0].longitude
                // ];

            }
            return false;
        });
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
        $("#playlists_edit-location").hide();
        playlist_edit_load_map(_input_latlong);


    }  //  end of map if statement
}

/**
 * ghetto iife
 */
if ($("#playlists_edit").length > 0) {
    playlist_edit_map();
}
