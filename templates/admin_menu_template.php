<h1>Quiz builder settings</h1>
<form method="post">
    <table class="form-table">
        <tr>
            <th>User result page</th>
            <td>
                <input type="hidden" value="<?php echo $result_page_id; ?>" id="result_page_id_val" name="result_page_id_val">
                <?php
                $pages = new WP_Query(array(
                    'post_type' => 'page',
                    'post_status' => 'publish',
                    'posts_per_page' => -1
                ));
                if( $pages->have_posts() ) {
                    echo '<select name="result_page_id" id="result_page_id">';
                        while( $pages->have_posts() ) {
                            $pages->the_post();
                            printf('<option value="%s">%s</option>',get_the_ID(), get_the_title());
                        }
                    echo '</select>';
                } else { 
                    echo 'No page found to be selected.';
                }
                wp_reset_query();
                ?>
            </td>
        </tr>
        <tr>
            <th>
                <input type="submit" value="Save Settings" name="save_settings" class="button button-primary">
            </th>
        </tr>
    </table>
</form>