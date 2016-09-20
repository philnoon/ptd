$(document).ready(function($) {
    $(function(){
        
        $('.datepicker').datepicker({autoclose:true,});
        $('[data-toggle="popover"]').popover();
        $('[data-toggle="tooltip"]').tooltip();
    
        $('.dropdown').hover(function() {
            $(this).addClass('open');
        }, function() {
            $(this).removeClass('open');
        });
    });

    $('#nav').affix({
        offset: {
            top: $('header').height()
        }
    }); 

});