
;(function($){
    var current_child = 0;
    var total = $('.qz_content .qz_content_childs').length;
    $('.qz_content').children().hide();
    $('.qz_content').children().eq(current_child).show();

    console.log(total);
    // move next question
   
    $(document).on('click','.qz_content_buttons .qz_btn_next',function() {
        console.log(current_child)
        if ( current_child < ( total - 1 ) ) {
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
        console.log('finished the quiz')
        $('.qz_progress').animate({
            'width' : '100%'
        },200)
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
        $(this).closest('.row').remove();
    });
    // add more question row
    $(document).on('click','.row_add_btn',function(){
        let close_img = $('.row_remove_btn').attr('src')
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
    if( $('#select_question').length > 0 ) {
        let select_box = $('#select_question').select2({
            placeholder: "Select a question",
            allowClear: true
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