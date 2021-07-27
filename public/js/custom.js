(function ($) {

    "use strict";

    $(".datepicker").datepicker({
        startDate: new Date().toDateString(),
        format: 'yyyy-mm-dd'
    });

})(jQuery);