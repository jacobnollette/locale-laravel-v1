var _navigation = {
    init: function () {
        var _actual_this = this;
        _actual_this.mobile_nav();
    },
    mobile_nav: function () {
        var _actual_this = this;
    }
}

/**
 * ghetto iife
 */
$(document).ready(function () {

        var _navigation_actual = Object.create(_navigation);
    _navigation_actual.init();

});
