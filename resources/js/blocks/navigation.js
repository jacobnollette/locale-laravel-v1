var _navigation = {
    init: function () {
        var _actual_this = this;
        _actual_this.mobile_nav();
    },
    mobile_nav: function () {
        var _actual_this = this;
        $(".header_mobile_hamburger a").click( function (e) {
            e.preventDefault();
            $(".header_mobile_nav").toggleClass("hidden");
        })
    }
}

/**
 * ghetto iife
 */
$(document).ready(function () {
    var _navigation_actual = Object.create(_navigation);
    _navigation_actual.init();
});
