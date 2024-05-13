;(function($){
    $(document).on('click','.row_remove_btn',function(){
        $(this).closest('.row').remove();
    });
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
    
})(jQuery)