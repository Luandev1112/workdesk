$(document).ready(function() {


	// language flag select2
	$('.country-flag-select').select2({
        templateResult: countryCodeFlag,
        templateSelection: countryCodeFlag,
        escapeMarkup: function(m) { return m; }
    });
    function countryCodeFlag(state) {
        var flagName = $(state.element).data('flag');
        if (!flagName) return state.text;
        return "<img class='flag' src='" + flagName + "' height='14' />" + state.text;
    }

});
