$(document).ready(function(){
    $('.hamburger-icon').click(function(e){
        $('.responsive-menu').css('display', 'block');
        $('.hamburger-icon').css('display', 'none');
        $('.exit-menu').css('display', 'block');
        e.preventDefault();
    });

    $('.exit-menu').click(function(e){
        $('.responsive-menu').css('display', 'none');
        $('.exit-menu').css('display', 'none');
        $('.hamburger-icon').css('display', 'block');
        e.preventDefault();
    });
});
