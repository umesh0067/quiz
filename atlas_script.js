jQuery(document).ready(function($){
    var  current_que = $('.next1').data('id');
    var  answertime = $('.next1').data('time');
    var  next_que = current_que + 1;
    var gameTime = $('.at_timer');

    console.log('at_timer', at_timer);
    
    var interval = setInterval(function () {
        $('.next'+current_que).trigger('click');
    }, answertime);

    $('body').on('click','.gnext , .gskip',function () {
        current_que = $(this).data('id');
        answertime = $('.next'+next_que).data('time');
        next_que = current_que + 1;
        clearInterval(interval);
        var intervals = setInterval(function () {
            //$('.next'+next_que).trigger('click');
            if($('.next'+next_que).length > 0){
                $('.next'+next_que).trigger('click');
            }else{  
                $('button[name="quiz_save"]').trigger('click');
            }
        }, answertime);
        $('.question'+current_que).hide();
        $('.question'+next_que).show();
    });


});