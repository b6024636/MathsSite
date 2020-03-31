
let card;
$('#student-card-hide').click(function(){
    card = $('#student-card');
    $('#student-card-hide').html(toggleCard(card));
});
$('#teacher-card-hide').click(function(){
    card = $('#teacher-card');
    $('#teacher-card-hide').html(toggleCard(card));
});

function toggleCard( card ){
    if($(card).hasClass('rotate-back'))
    {
        $(card).removeClass('hide');
        setTimeout(function(){
            $(card).removeClass('rotate-back');
        }, 200);
        return 'Hide';
    }else{
        $(card).addClass('rotate-back');
        setTimeout(function() {
            $(card).addClass('hide');
        },220);
        return 'Show';
    }
}


