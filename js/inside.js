jQuery.fn.filterByText = function() {
    return this.each(function() {
        var input = this;
        var select = $(input).next('div').children('span');
        var labels = [];
        $(select).children('label').each(function() {
            labels.push(this);
        });
        
        $(select).data('labels', labels);
        $(input).bind('change keyup', function() {
            var labels = $(select).empty().scrollTop(0).data('labels');
            var search = $(this).val().trim();
            var regex = new RegExp(search, "gi");
            
            $.each(labels, function(i) {
                var label = labels[i];
                if ($(label).text().match(regex) !== null) {
                    $(select).append(
                        label
                    );
                }
            });
        });
    });
};

$(function() {
    $('.filter').filterByText();
});