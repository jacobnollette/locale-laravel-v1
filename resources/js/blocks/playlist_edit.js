var _playlist_edit = {

    markers: [],

    playlist_edit_load_map: function (location, initial) {
        /**
         * function to load map feature
         */
        var _this_actual = this;

        /**
         * map initi
         */
        var mymap = L.map('playlists_edit-map').setView(location, 15);
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
         * marker feature
         */
        var _add_marker = function (latlng) {
            /**
             * place marker in the database
             */
            var csrf = document.querySelector('meta[name="csrf-token"]').content;

            _this_actual.markers.forEach( function ( the_marker ) {
                mymap.removeLayer(the_marker);
            })
            /**
             * add market to map
             */
            var mymarker = L.marker(latlng).addTo(mymap);
            _this_actual.markers.push( mymarker );
            /**
             * post location to database
             */
            // console.log(latlng);
            var _given_url = window.location;
            _given_url = _given_url.pathname.split('/');
            var playlist_id = _given_url[2];
            var _location_url = "/playlist/" + playlist_id + "/location/update";
            //console.log(_location_url);
            var _request = {
                "lat": latlng.lat,
                "lng": latlng.lng
            }
            $("#playlist_location").data("lat", latlng.lat);
            $("#playlist_location").data("long", latlng.lng);


            /**
             * post to api server
             */
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
                _return = JSON.parse(this.responseText);
                console.log( _return );
            }
        }

        console.log( location );

        var _sans_location = {
            "lat":location[0],
            "lng":location[1]
        };

        _add_marker( _sans_location );

        /**
         * initial marker logic
         */
        //if (initial) {
            //alert("Click a more specific location for your playlist");
            mymap.on('click', function (ev) {
                _add_marker(ev.latlng);
            });
        //} else {
            /**
             * place mark marker logic
             */
            //L.marker(location).addTo(mymap);
        //}
    },
    share_playlist: function () {
        $("#playlists_edit-header_share a").click(function (e) {
            /**
             * default stuff
             */
            e.preventDefault();


            var _textBlock = $("#playlists_edit-header_share a");
            var share = "yes";
            if ( _textBlock.html() == "Share Playlist" ) {
                _textBlock.html( "Unshare Playlist" );
                share = "yes";
            } else {
                _textBlock.html( "Share Playlist");
                share = "no";
            }



            /**
             * share url logic, and variables
             */
            var csrf = document.querySelector('meta[name="csrf-token"]').content;
            var _given_url = window.location;
            _given_url = _given_url.pathname.split('/');
            var playlist_id = _given_url[2];
            var _location_url_add = "/playlist/" + playlist_id + "/playlist/add";
            var _location_url_remove = "/playlist/" + playlist_id + "/playlist/remove";

            if ( share == "yes" ) {
                _location_share = _location_url_add;
            } else {
                _location_share = _location_url_remove;
            }




            var request = {
                "playlist": playlist_id
            };
            var xhr = new XMLHttpRequest();
            xhr.open("POST", _location_share, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-Token', csrf);
            xhr.send(JSON.stringify(request));
            xhr.onload = function () {
                /**
                 * return
                 */
                _return = JSON.parse(this.responseText);
                console.log(_return);
            }
        })
    },
    init: function () {
        /**
         * we're going to verify the lat,lung from these three words
         * then we're going to display the location, or center the map on minneapolis
         */

        /**
         * basic variables for request
         */
        var _this_actual = this;

        _this_actual.share_playlist();


        /**
         * get location lat/long
         */
        if ($("#playlist_location").data("lat") == 0 && $("#playlist_location").data("long") == 0) {

            /**
             * process text field
             */
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

                /**
                 * get location from api server
                 */
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

                    /**
                     * build out list lists
                     */
                    $("#playlist_edit-location_list ul li a").click(function (e) {
                        e.preventDefault();
                        _location = [
                            $(this).parent().data("lat"),
                            $(this).parent().data("long")
                        ];
                        $("#playlists_edit-location").hide();
                        _this_actual.playlist_edit_load_map(_location, true);
                        //alert("general location provide; please click for exact location");
                    })

                    /**
                     * debug logic
                     */
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
            _this_actual.playlist_edit_load_map(_input_latlong);
        }
    }
}

/**
 * ghetto iife
 */
$(document).ready(function () {
    if ($("#playlists_edit").length > 0) {
        var _playlist_edit_actual = Object.create(_playlist_edit);
        _playlist_edit_actual.init();
    }
});
