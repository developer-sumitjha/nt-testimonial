$ = jQuery;

$(document).ready(function(){

    $('#slider-setting-tab').click(function(){
        $('.setting-tab-content div').removeClass('active');
        $('.setting-tab-content div.slider-setting').addClass('active');
        $('.setting-tabs div').removeClass('active');
        $(this).addClass('active');

    })

    $('#grid-setting-tab').click(function(){
        $('.setting-tab-content div').removeClass('active');
        $('.setting-tab-content div.grid-setting').addClass('active');
        $('.setting-tabs div').removeClass('active');
        $(this).addClass('active');
    })

})