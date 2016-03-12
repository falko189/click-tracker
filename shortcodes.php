<?php

function tracked_a($atts, $content = null) {
    $a = shortcode_atts(array(
        'class' => '',
        'id' => '',
        'href' => '#',
        'targer' => '_self',
            ), $atts);
    return '<a id="'.$a['id'].'" class="click-tracker '.$a['class'].'" href="'.$a['href'].'" target="'.$a['target'].'">' . $content . '</a>';
}

add_shortcode('tracked-a', 'tracked_a');
