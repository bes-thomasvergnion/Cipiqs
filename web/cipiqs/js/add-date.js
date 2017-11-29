$(document).ready(function() {
    var $container = $('div#tv_congresbundle_congres_dates');
    var index = $container.find(':input').length;

    $('#add-date').click(function(e) {
        addDate($container);
        e.preventDefault();
        return false;
    });

    if(index === 0) {
        addDate($container);
    } 

    function addDate($container) {
        var template = $container.attr('data-prototype')
          .replace(/__name__label__/g, '')
          .replace(/__name__/g,        index)
        ;

        var $prototype = $(template);
        $container.append($prototype);
        
        $( function() {
            $( "#tv_congresbundle_congres_dates input" ).datepicker({
                dateFormat: 'dd/mm/yy'
            });
        });
        
        index++;
    }
});
