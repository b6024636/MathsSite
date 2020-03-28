
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

$('.topic-link').click(function(){
    event.preventDefault();
    let $row = $(this).closest('.topic-row'),
        $title = $(this).attr('data-title'),
        $tasks = JSON.parse($row.find('.topic-tasks:first').html());
    console.log($tasks);


    let $html = '<a href="#" id="topic-back">&laquo Back to topics</a>';

    if($tasks != '[]') {
        $html += '<div class="row p-2 task-row font-weight-bold">' +
            '<div class="col-md-6">' +
            '<p>Title</p>' +
            '</div>' +
            '<div class="col-md-3">' +
            '<p>Marks</p>' +
            '</div>' +
            '<div class="col-md-3">' +
            '<p>Rating</p>' +
            '</div>' +
            '</div>';
        for (var k in $tasks) {
            $html += '' +
                '<div class="row p-2 task-row">' +
                '<div class="col-md-6">' +
                '<p>' + $tasks[k].title + '</p>' +
                '</div>' +
                '<div class="col-md-3">' +
                '<p>' + $tasks[k].marks + '</p>' +
                '</div>' +
                '<div class="col-md-3">' +
                '<p>' + $tasks[k].rating + '</p>' +
                '</div>' +
                '</div>';
        }
    }else{
        $html += '<div class="row p-2 task-row font-weight-bold">' +
            '<p>N/A</p>' +
            '</div>'
    }
    $('#tasks-body').html($html);
    $('#topics-body').hide();
    $('#tasks-body').show();
    $('.modal-title').html($title);
    $('#topic-back').click(function(){
        event.preventDefault();
        $('#tasks-body').hide();
        $('#tasks-body').html('');
        $('.modal-title').html('Add a task for the group');
        $('#topics-body').show();
    })
});
