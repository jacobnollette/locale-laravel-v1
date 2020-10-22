function explorer_index_map() {
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
    })

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
}

if ($("#explorer_index").length > 0) {
    explorer_index_map();
}
