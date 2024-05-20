
;(function($){
    if( $('#qz_results_anchor').length > 0 ) {
        $('#qz_results_anchor').css('cursor','pointer')
        $(document).on('click','#qz_results_anchor',function(){
            window.location.href = $('#qz_results_anchor').attr('data-href')
        })
    }
    String.prototype.toHHMMSS = function () {
        var sec_num = parseInt(this, 10); // don't forget the second param
        var hours   = Math.floor(sec_num / 3600);
        var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
        var seconds = sec_num - (hours * 3600) - (minutes * 60);
    
        if (hours   < 10) {hours   = "0"+hours;}
        if (minutes < 10) {minutes = "0"+minutes;}
        if (seconds < 10) {seconds = "0"+seconds;}
        return hours+':'+minutes+':'+seconds;
    }
    let quiz_timmer = setInterval(function(){
        let seconds = $('#qz_duration_value').attr('data-time-seconds')
        let processed_time = String(seconds).toHHMMSS()
        $('#qz_duration_text').text(processed_time)
        $('#qz_duration_value').attr('data-time-seconds', parseInt(seconds) - 1)
        if( parseInt(seconds) <= 0 ) {
            clearInterval(quiz_timmer)
            Swal.fire({
                icon: "warning",
                text: "Time out. You've to start again."
            }).then( ok => {
                window.location.reload()
            })
        }
    },1000)
    var current_child = 0;
    var total = $('.qz_content .qz_content_childs').length;
    $('.qz_content').children().hide();
    $('.qz_content').children().eq(current_child).show();

    $(document).on('click','.qz_content_buttons .qz_btn_next',function() {
        if ( current_child < ( total - 1 ) ) {
            let checked_qtn = $('.qz_content .qz_content_childs').eq(current_child).find('input[type="checkbox"]:checked').length
            if( checked_qtn == 0 ) {
                Swal.fire({
                    icon: "warning",
                    text: "You've to select an answer to go to next question"
                })
                return
            }
            $('.qz_content .qz_content_childs').eq(current_child).fadeOut(function(){
                // Show the next child
                current_child++
                $('.qz_content .qz_content_childs').eq(current_child).show();
                // enable previous button
                $('.qz_btn_previous').prop('disabled',false)
                // disable next button if the last question
                $('.qz_progress').animate({
                    'width' : ( 100 / total * current_child ) + '%'
                },200)
            });
        }
        if( current_child >= ( total - 2 ) ) {
            $('.qz_btn_next').text('Finish')
            $('.qz_btn_next').attr('data-finish-quiz',true)
        }
    });
    $(document).on('click','.qz_btn[data-finish-quiz]',function(){
        let quiz_id = $('.qz_container').attr('data-quiz-id')
        let checked_qtn = $('.qz_content .qz_content_childs').eq(current_child).find('input[type="checkbox"]:checked').length
        if( checked_qtn == 0 ) {
            Swal.fire({
                icon: "warning",
                text: "You've to select an answer to go to next question"
            })
            return
        }
        $('.qz_progress').animate({
            'width' : '100%'
        },200)
        let quiz_data = []
        $.each($('.qz_content .qz_content_childs'),function(key,question){
            let qtn_id = $(question).attr('data-qtn-id')
            let checked_options_val = []
            $.each($(question).find('input[type="checkbox"]:checked'),(qtn_key, option) => {
                checked_options_val.push($(option).val())
            })
            quiz_data.push({
                qtn_id,
                checked_options_val
            })
        })
        $.LoadingOverlay('show')
        $.ajax({
            url: localize_ajax.ajaxurl,
            type: "POST",
            dataType: "json",
            // dataType: "dataType",
            data: {
                'action' : 'quiz_data',
                'quiz_data' : quiz_data,
                nonce: localize_ajax.nonce,
                quiz_id
            },
            success: function (response) {
                $.LoadingOverlay('hide')
                console.log(response)
                if( response.success && response.success == true ) {
                    if( response.data.redirect_url ) {
                        window.location.href = response.data.redirect_url
                    }
                }
            },
            error: function( err ) {
                console.log(err)
                $.LoadingOverlay('hide')
                // let response = JSON.parse(err.responseText)
                // console.log(response.data)
                Swal.fire({
                    icon: "error",
                    text: err.responseText
                })
            }
        });
    })
    // move previous question
    $('.qz_content_buttons .qz_btn_previous').click(function() {
        if( current_child > 0 ) {
            $('.qz_content .qz_content_childs').eq(current_child).fadeOut(function(){
                current_child--;
                // Show the previous child
                $('.qz_content .qz_content_childs').eq(current_child).show();
                // revert finish to next
                $('.qz_btn_next').text('Next')
                $('.qz_btn_next').removeAttr('data-finish-quiz')
                // disable previous button if at the first question
                // css('width', ( 100 / total * current_child ) + '%' )
                $('.qz_progress').animate({
                    'width' : ( 100 / total * current_child ) + '%'
                },200)
            });
        }
        if( current_child <= 1 ) $('.qz_btn_previous').prop('disabled',true)
    });
    // remove question option rows
    $(document).on('click','.row_remove_btn',function(){
        if( $('.row_remove_btn').length <= 1 ) return
        $(this).closest('.row').remove();
    });
    // add more question row
    $(document).on('click','.row_add_btn',function(e){
        e.preventDefault()
        let close_img = $(this).attr('data-remove-img')
        console.log('close_img',close_img)
        let row_count = $('#row_count').val()
        row_count++
        let row_template = `
            <div class="row">
                <label for="option_${row_count}_title" class="question_title">
                    <span>Question title</span>
                    <input type="text" name="options[${row_count}][title]" id="option_${row_count}_title">
                </label>
                <label for="option_${row_count}_correct">
                    <input type="checkbox" name="options[${row_count}][correct]" id="option_${row_count}_correct" value="yes">
                    <span>Correct answer</span>
                </label>
                <img src="${close_img}" alt="" class='row_remove_btn'>
            </div>
        `
        // append the row
        $('.row-container').append(row_template)
        $('#row_count').val(row_count)
    })
    if( $('#result_page_id').length > 0 ) {
        $('#result_page_id').select2({
            'placeholder' : "Select a page"
        })
        $(document).on('change.select2','#result_page_id',function(){
            $('#result_page_id_val').val( $('#result_page_id').select2('data')[0].id )
        })
        $('#result_page_id').val( $('#result_page_id_val').val() ).trigger('change')
    }
    if( $('#select_question').length > 0 ) {
        let select_box = $('#select_question').select2({
            placeholder: "Select a question",
            allowClear: true,
            width: 150
        })
        if( $('#selected_questions').length > 0 && $('#selected_questions').val() != "" ) {
            let selected_qtns = $('#selected_questions').val()
            $('#select_question').val(selected_qtns.split(',')).trigger('change')
        }
        $('#select_question').on('change.select2',function(e){
            let data = $(this).select2('data')
            data = data.map(( option ) => {
                return option.id
            })
            // console.log(data)
            $('#selected_questions').val(data.join(','))
        });
    }
})(jQuery)