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
        _actual_this.start_load();
    },
    start_load: function () {
        /**
         * get location
         */
        console.log("start load");
        var _actual_this = this;
        /**
         * get the location from the browser
         */
        _actual_this.get_location();

    },
    get_location: function () {
        /**
         * get location from browser
         */
        var _actual_this = this;
        if (navigator.geolocation) {
            console.log("navigator");
            navigator.geolocation.getCurrentPosition(function (position) {
                console.log("this location found");
                _actual_this.received_location(position.coords.longitude, position.coords.latitude);
                $("#explorer_map_no_location").toggleClass("hidden");
            });

        } else {
            /**
             * geolocation is not supported
             * get your location some other way
             */
            console.log('geolocation is not enabled on this browser')
        }
    },
    received_location: function (long, lat) {
        /**
         * parse location, and load up map
         */
        console.log("received location");
        var _actual_this = this;
        var _the_map_location = [lat, long];
        _actual_this.load_map(_the_map_location);

        /**
         * add circle
         */
        L.circle({lat: lat, lng: long}, {
            color: 'steelblue',
            radius: 900,
            fillColor: 'steelblue',
            opacity: 0.5
        }).addTo(_actual_this.mymap);

        _actual_this.center_lat = lat;
        _actual_this.center_lng = long;
        /**
         * 69 miles per degree
         * 111044.7 per 69 miles
         * 0.002701615 degrees
         */

        _actual_this.unlock_location(lat, long);
    },
    unlock_location: function (lat, long) {
        var _actual_this = this;

        var request = {
            "lat": lat,
            "lng": long
        };
        var url = "/dashboard/explore/unlock/list";
        var csrf = document.querySelector('meta[name="csrf-token"]').content;
        var xhr = new XMLHttpRequest();
        xhr.open("POST", url, true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-Token', csrf);
        xhr.send(JSON.stringify(request));
        xhr.onload = function () {
            console.log(this.responseText);

            _return = JSON.parse(this.responseText);
            _actual_this.playlists = _return;

            // console.log(_return);
            // _actual_this.populate_map(_return, request);
        }
    },
    playlists:{},
    playlists_available: function () {
        /**
         * create prompt and make playlists available.
         */
        var _actual_this = this;
        var location = {
            "lat": _actual_this.center_lat,
            "lng": _actual_this.center_lng
        };
        var mymarker = L.marker(location).addTo(_actual_this.mymap);

        var playlist_copy = '<div id="playlists_popup"><h2>You are here</h2><h4>Playlists Available</h4><ul>'
        if ( _actual_this.playlists.length > 0 ) {
            _actual_this.playlists.forEach( function ( playlist ) {
                playlist_copy = playlist_copy + '<li data-playlist_id="' + playlist.playlist_id + '"><a href="#">' + playlist.playlist_name + '</a></li>';
            })
        } else {
            playlist_copy = playlist_copy + '<li>No Playlists available</li>';
        }
        console.log( _actual_this.playlists );
        playlist_copy = playlist_copy + '</ul></h2>';
        mymarker.bindPopup(playlist_copy ).openPopup();
        _actual_this.markers.push(mymarker);

        $("#explorer_index #playlists_popup li a").click( function (e) {
            e.preventDefault();
            var _link_this = this;
            /**
             * request playlist add
             */

            $(this).parent().toggleClass("checked");
            var request = {
                playlist_id: $(this).parent().data("playlist_id")
            };

            var url = "/dashboard/explore/unlock/add";
            var csrf = document.querySelector('meta[name="csrf-token"]').content;
            var xhr = new XMLHttpRequest();
            xhr.open("POST", url, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-Token', csrf);
            xhr.send(JSON.stringify(request));
            xhr.onload = function () {
                console.log(this.responseText);

                // _return = JSON.parse(this.responseText);
                // _actual_this.playlists = _return;

                // console.log(_return);
                // _actual_this.populate_map(_return, request);
            }

        })


    },


    load_map: function (location) {
        /**
         * load map
         */
        var _actual_this = this;
        _actual_this.mymap = L.map('explorer_map').setView(location, 14);
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            dragging: false,
            accessToken: 'pk.eyJ1IjoiamFjb2Jub2xsZXR0ZSIsImEiOiJja2dpeW9rMzgxanVuMnJycjNqcjNsaHFpIn0.XQXUgLDmOs15mHZiey4YmA'
        }).addTo(_actual_this.mymap);

        /**
         * drag listener
         */
        var width = _actual_this.mymap.getBounds().getEast() - _actual_this.mymap.getBounds().getWest();
        var height = _actual_this.mymap.getBounds().getNorth() - _actual_this.mymap.getBounds().getSouth();
        var mapcenter = _actual_this.mymap.getCenter();
        if (width >= height) {
            range = width;
        } else {
            range = height;
        }
        _actual_this.found_location(location[1], location[0], range);


        _actual_this.mymap.on("dragend", function () {
            var width = _actual_this.mymap.getBounds().getEast() - _actual_this.mymap.getBounds().getWest();
            var height = _actual_this.mymap.getBounds().getNorth() - _actual_this.mymap.getBounds().getSouth();
            var mapcenter = _actual_this.mymap.getCenter();

            if (width >= height) {
                range = width;
            } else {
                range = height;
            }
            _actual_this.found_location(mapcenter.lng, mapcenter.lat, range);
        })
        $(window).on("resize", function () {
            var _the_height = $(window).height() - 200;
            $("#explorer_map").height(_the_height);
            _actual_this.mymap.invalidateSize();
        }).trigger("resize");


    },
    found_location: function (long, lat, mean_range) {
        var _actual_this = this;
        var request = {
            "lat": lat,
            "long": long,
            "mean_range": mean_range
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

        /**
         * remove previous markers, on populate
         */
        _actual_this.markers.forEach(function (_the_marker) {
            _actual_this.mymap.removeLayer(_the_marker);
            //console.log ( _the_marker );
        })

        _actual_this.markers = [];

        _actual_this.playlists_available();

        if (given.length > 0) {

            given.forEach(function (playlist) {
                if (playlist.location !== null) {
                    var location = {
                        "lat": playlist.location.coordinates[1],
                        "lng": playlist.location.coordinates[0]
                    }
                    var mymarker = L.marker(location).addTo(_actual_this.mymap);
                    _actual_this.markers.push(mymarker);
                    //console.log(playlist);
                }
            })

            _actual_this.markers.forEach(function (marker) {

            })
        }
        //console.log ( given );
    },

    markers: [],
    center_lat:"",
    center_lng:""
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
