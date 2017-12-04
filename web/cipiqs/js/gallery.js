$(document).ready(function(){
    $('#link-gallery').click(function(e) {
        $('#modal-img').css('display', 'block');
        e.preventDefault();
    });
    
    $('.close').click(function(e) {
        $('#modal-img').css('display', 'none');
        e.preventDefault();
    });
    
    $('.select').click(function(e) {
        $('#modal-img').css('display', 'none');
        e.preventDefault();
    });
    
    $('.gallery img').click(function(e){
        $('.gallery img').removeClass("actived");
        $(this).addClass("actived");
        $image_id = $(this).attr('id');
        $('#hidden-input').attr({value: $image_id});
        console.log($image_id);
        e.preventDefault();
    });
});

//var form = document.getElementById("myform");
//// or with jQuery
////var form = $("#myform")[0];
//
//$.ajax({
//    url:"/web-service/that/will-process/our-image",
//    data: new FormData(form),// the formData function is available in almost all new browsers.
//    type:"post",
//    contentType:false,
//    processData:false,
//    cache:false,
//    dataType:"json", // Change this according to your response from the server.
//    error:function(err){
//        console.error(err);
//    },
//    success:function(data){
//        console.log(data);      
//    },
//    complete:function(){
//        console.log("Request finished.");
//    }
//});
