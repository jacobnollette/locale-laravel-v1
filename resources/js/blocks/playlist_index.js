var _playlist_index = {
    init: function () {
        $("#playlists_index .playlist_add").each(function (i, obj) {
            /**
             * playlist html, content fix
             */
            if ($(this).hasClass("in_crate")) {
                $(this).html("Unshare Playlist");
            }
        })
        $("#playlists_index .playlist_add").on("click", function (e) {
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
            xhr.onload = function () {
                console.log(this.responseText);
                // _return = JSON.parse( this.responseText );
            }
        });
    }
}

/**
 * ghetto iife
 */
$(document).ready(function () {
    if ($("#playlists_edit").length > 0) {
        var _playlist_index_actual = Object.create(_playlist_index);
        _playlist_index_actual.init();
    }
});
