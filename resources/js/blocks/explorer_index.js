var _explorer_index = {
    init: function () {

        var _actual_this = this;
        /**
         * Explorer index stuff
         */
        $("#explorer_index .playlist_add").each(function (i, obj) {
            /**
             * playlist html, content fix
             */
            if ($(this).hasClass("in_library")) {
                $(this).html("Remove Playlist");
            }
        });

        /**
         * playlist add click function
         */
        $("#explorer_index .playlist_add").on("click", function (e) {
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
            xhr.onload = function () {
                console.log(this.responseText);
                // _return = JSON.parse( this.responseText );
            }
        });
        _actual_this.get_location();
    },

    get_location: function () {
        var _actual_this = this;
        if ("geolocation" in navigator) {
            /**
             * check if geolocation is supported/enabled on current browser
             */
            var location =
                {
                    "long": null,
                    "lat": null
                }
            navigator.geolocation.getCurrentPosition(
                function success(position) {
                    /**
                     * for when getting location is a success
                     */
                    //console.log('latitude', position.coords.latitude,
                    // 'longitude', position.coords.longitude);
                    _actual_this.found_location(position.coords.longitude, position.coords.latitude);
                    // location.long = position.coords.longitude;
                    // location.lat = position.coords.latitude;
                },
                function error(error_message) {
                    /**
                     * for when getting location results in an error
                     */
                    console.error('An error has occured while retrieving location', error_message);
                }
            )


        } else {
            /**
             * geolocation is not supported
             * get your location some other way
             */
            console.log('geolocation is not enabled on this browser')
        }
    },
    found_location: function (long, lat) {
        var _actual_this = this;
        var request = {
            "lat": lat,
            "long": long
        };
        var url = "/dashboard/explore/list";
        var csrf = document.querySelector('meta[name="csrf-token"]').content;
        var xhr = new XMLHttpRequest();
        xhr.open("POST", url, true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-Token', csrf);
        xhr.send(JSON.stringify(request));
        xhr.onload = function () {
            //console.log(this.responseText);
            _return = JSON.parse(this.responseText);
            // console.log(_return);
            _actual_this.populate_map(_return, request);
        }
    },
    populate_map: function (given, location) {
        var _actual_this = this;
        location = {
            "lat": location.lat,
            "lng": location.long
        }
        var mymap = L.map('explorer_map').setView(location, 14);
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            dragging: false,
            accessToken: 'pk.eyJ1IjoiamFjb2Jub2xsZXR0ZSIsImEiOiJja2dpeW9rMzgxanVuMnJycjNqcjNsaHFpIn0.XQXUgLDmOs15mHZiey4YmA'
        }).addTo(mymap);
        console.log(given);
        if (given.length > 0) {

            given.forEach(function (playlist) {
                if (playlist.location !== null) {


                    var location = {
                        "lat": playlist.location.coordinates[1],
                        "lng": playlist.location.coordinates[0]
                    }
                    var mymarker = L.marker(location).addTo(mymap);
                    _actual_this.markers.push(mymarker);
                    console.log(playlist);
                }
            })
            _actual_this.markers.forEach(function (marker) {

            })
        }
        //console.log ( given );
    },
    markers: []
}

/**
 * ghetto iife
 */
$(document).ready(function () {
    if ($("#explorer_index").length > 0) {
        var _explorer_index_actual = Object.create(_explorer_index);
        _explorer_index_actual.init();
    }
});
