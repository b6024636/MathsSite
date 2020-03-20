window.onload = function(){
    var $button = $('#beginTask');

    $button.click(function () {
        console.log('hello');
        $.ajax({
            url: '/questions/question',
            data: {id:1, json:true},
            type: 'POST',
            success: function(data, status){
                console.log(data);
                console.log(status);
            }
        })
    })
}
