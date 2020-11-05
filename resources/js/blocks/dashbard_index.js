var _dashboard_index = {
    init: function () {
        $("#playlists_index").masonry({
            itemSelector:".playlist",
            //columnWidth: 300
        })
    }
}

/**
 * ghetto iife
 */
$(document).ready(function () {
    if ($("#playlists_index").length > 0) {
        var _dashboard_index_actual = Object.create(_dashboard_index);
        _dashboard_index_actual.init();
    }
});
