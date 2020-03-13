{{$taskId
}}
{{$questions}}

@extends('layout')

@section('content')


    <input type="submit" value="Ready to start?" class="btn btn-primary" id="beginTask">
    <h1 id="question"></h1>
    <div id="mc">

    </div>
    <div id="sc">

    </div>
    <input type="submit" value="Next" class="btn btn-success hide" id="next-button">
@endsection
{{--{{ HTML::script('js/maths/taskprocess.js') }}--}}
<script>
    let score = 0;
    window.onload = function(){
        let $button = $('#beginTask'),
            questionCount = 0,
            questions = '{{$questions}}'.split(','),
            maxQuestions = questions.length;

        console.log(maxQuestions);
        $button.click(function () {
            doNewQuestion(questions, questionCount);
            questionCount++;
            $button.remove();
        });
    }
    function doNewQuestion(questions, count){
        let questionId = questions[count];
        $.ajax({
            url: '/questions/question/' + questionId,
            data: {json:true},
            type: 'GET',
            success: function(data, status){
                //console.log(data);
                $('#next-button').removeClass('hide');
                $('#question').html(data.question);
                if(data.question_type == 'MC'){
                    var optionalAnswersArr = (data.optional_answers).split(',');
                    var $html = '<div class="form-group">';
                    for(i = 0; i < optionalAnswersArr.length; i++)
                    {
                        $html += '' +
                            '<label class="container question-container">' +
                            optionalAnswersArr[i] +
                            '<input type="radio" name="questionradio" value='+ optionalAnswersArr[i] +'>' +
                            '<span class="checkmark"></span>' +
                            '</label>'
                    }
                    $html += '</div>';
                    $('#mc').html($html);
                }
                $('#next-button').click(function(){
                    if($('input[name="questionradio"]:checked').val() == data.answer)
                        score += data.marks;
                    // quesitonId++;
                    count++;
                    console.log(score);
                    doNewQuestion(questions, count);
                });

            }
        })
    }

</script>
