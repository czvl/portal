jQuery.fn.filterByText = function() {
    return this.each(function() {
        var input = this;
        var labels = [];
        var select = $(input).next('div').children('span');

        $(select).children('label').each(function(i) {
            labels.push(this);
        });

        $(input).bind('change keyup', function() {
            var search = $(this).val().trim();
            var regex = new RegExp(search, "gi");

            $.each(labels, function(i) {
                var label = labels[i];
                if ($(label).text().match(regex) === null) {
                    $(label).hide();
                } else {
                    $(label).show();
                }
            });
        });
    });
};

$(function() {
    $('.filter').filterByText();
});

function selectAge(ui) {
    var min = ui.values[0];
    var max = ui.values[1];
    $('input[name=age_min]').val(min);
    $('input[name=age_max]').val(max);
    $("#age > .min").html(min);
    $("#age > .max").html(max);
}