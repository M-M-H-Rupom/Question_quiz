(function($){
    $(document).on('click','.row_remove_btn',function(){
        $(this).closest('.row').remove();
    });
    $(document).on('click','.row_add_btn',function(){
        let row_count = $('.row-container').attr('data-row-count')
        row_count++
        let row_template = `
            <div class="row">
                <label for="option_${row_count}_title">
                    <span>Question title</span>
                    <input type="text" name="options[${row_count}][title]" id="option_${row_count}_title">
                </label>
                <label for="option_${row_count}_correct">
                    <input type="radio" name="options[${row_count}][correct]" id="option_${row_count}_correct">
                    <span>Correct answer?</span>
                </label>
                <div class="remove">
                    <button type="button" class='row_remove_btn'>Remove</button>
                </div>
            </div>
        `
        // append the row
        $('.row-container').append(row_template)
        $('#row_count').val(row_count)
    })
    
})(jQuery)