@extends('layout')

@section('content')


    <h2>{{$task}}</h2>
    <input type="submit" value="Ready to start?" class="btn btn-primary" id="beginTask">
    <h1 id="question"></h1>
    <div id="mc">

    </div>
    <div id="sa">

    </div>
    <input type="submit" value="Next" class="btn btn-success hide" id="next-button">
@endsection
{{--{{ HTML::script('js/maths/taskprocess.js') }}--}}
<script>
    let score = 0,
        questionCount = 0,
        thisData = {};
    var questionsScores = {
        taskId: '{{$taskId}}'
    };
    window.onload = function(){
        let $button = $('#beginTask'),
            questions = '{{$questions}}'.split(','),
            maxQuestions = questions.length;

        //console.log(maxQuestions);
        $button.click(function () {
            doNewQuestion(questions, questionCount, maxQuestions);
            $button.remove();
        });
        $('#next-button').click(function(){
            questionsScores[questionCount] = 0;
            if(thisData.question_type == 'MC') {
                if ($('input[name="questionradio"]:checked').val() == thisData.answer){
                    score += thisData.marks;
                    questionsScores[questionCount] = thisData.marks;
                }
            }else if(thisData.question_type == 'SA'){
                if ($('#sc-answer').val() == thisData.answer) {
                    score += thisData.marks;
                    questionsScores[questionCount] = thisData.marks;
                }
            }
            if(questionCount + 1 < maxQuestions) {
                // quesitonId++;
                questionCount++;
                doNewQuestion(questions, questionCount, maxQuestions);
            }else{
                console.log(JSON.stringify(questionsScores));
                $.ajax({
                    url: '/tasks/task/finishtask/',
                    data: { json:true },
                    // data: { scores: JSON.stringify(questionsScores) },
                    type: 'GET',
                    success: function(_data, status){
                        console.log(_data);
                    }
                })
            }
        });

    }
    function doNewQuestion(questions, questionCount, maxQuestions){
        let questionId = questions[questionCount];
        $.ajax({
            url: '/questions/question/' + questionId,
            data: {json:true},
            type: 'GET',
            success: function(data, status){
                // console.log(data);
                thisData = data;
                $('#next-button').removeClass('hide');
                $('#question').html(data.question);
                if(data.question_type == 'MC'){
                    $('#sc').html('');
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
                else if(data.question_type == 'SA'){
                    $('#mc').html('');
                    let html = '' +
                        '<div class="form-group">' +
                        '<label for="answer">Enter answer here: ' +
                        '</label>' +
                        '<input name="answer" type="text" id="sc-answer"/>' +
                        '</div>';
                    $('#sa').html(html);

                }
                // $('#next-button').click(function(){
                //     questionsScores[questionCount] = 0;
                //     if(data.question_type == 'MC') {
                //         // console.log($('input[name="questionradio"]:checked').val() + ' Given Answer');
                //         // console.log(data.answer + ' Answer');
                //         if ($('input[name="questionradio"]:checked').val() == data.answer){
                //             score += data.marks;
                //             questionsScores[questionCount] = data.marks;
                //         }
                //     }else if(data.question_type == 'SA'){
                //         if ($('#sc-answer').val() == data.answer) {
                //             score += data.marks;
                //             questionsScores[questionCount] = data.marks;
                //         }
                //     }
                //     if(questionCount + 1 < maxQuestions) {
                //         // quesitonId++;
                //         questionCount++;
                //         doNewQuestion(questions, questionCount, maxQuestions);
                //     }else{
                //         console.log(questionsScores);
                //         $.ajax({
                //             url: '/tasks/task/finishtask',
                //             data: { scores: JSON.stringify(questionsScores) },
                //             type: 'GET',
                //             success: function(_data, status){
                //                 console.log(_data);
                //             }
                //         })
                //     }
                // });

            }
        })
    }

</script>
