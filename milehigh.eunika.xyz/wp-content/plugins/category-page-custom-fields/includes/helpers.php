<?php
function ccf_is_product_cat() {
    return is_tax('product_cat');
}

function ccf_get_current_term_id() {
    $term = get_queried_object();
    return ($term && !empty($term->term_id)) ? $term->term_id : false;
}