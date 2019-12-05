<?php

function objectiv_click_to_tweet_inline( $atts, $content = null ) {

	$url = rawurlencode( $content . ' ' . get_the_permalink( get_the_ID() ) . ' via @kerrybodine' );

	$string = '<a class="obj-ictt" target="_blank" href="https://twitter.com/intent/tweet?text=' . $url . '">
            <span class="obj-ictt-content">' . $content . '</span>
            <span class="obj-ictt-icon">
            <span class="obj-ictt-icon-inner">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             viewBox="0 0 6500 6500" style="enable-background:new 0 0 6500 6500;" xml:space="preserve">
            <style type="text/css">
            .st0{fill:#EEEDEE;}
            .st1{fill:none;}
            </style>
            <g id="Page-1">
            <g id="twitter-badge">
                <path id="bg_box" class="st0" d="M2548.1,4.9H400.2C178.8,4.9,0,184,0,405.1v5694.8C0,6321.2,179.2,6500,400.2,6500h5694.8
                    c221.4,0,400.2-179.2,400.2-400.2V405.1c0-221.4-179.2-400.2-400.2-400.2H3947L3247.6,0L2548.1,4.9z"/>
                <path id="twitter_bird" class="st1" d="M5345.2,1979.6c-147.4,65.7-271.7,67.9-403.3,2.9c169.9-101.8,177.7-173.3,239.1-365.7
                    c-159,94.4-335.2,163-522.7,199.9c-150-159.7-363.9-259.9-600.6-259.9c-454.6,0-823,368.7-823,823c0,64.5,7.2,127.3,21.2,187.6
                    c-683.9-34.2-1290.4-361.9-1696.3-859.9c-70.8,121.5-111.4,263-111.4,413.8c0,285.6,145.4,537.4,366,685
                    c-134.9-4.3-261.7-41.3-372.6-102.9c-0.2,3.4-0.2,6.7-0.2,10.3c0,398.8,283.6,731.3,660.3,807c-120.6,32.8-247.8,37.9-371.8,14.3
                    c104.9,326.7,408.8,564.7,768.8,571.4c-352.3,276-788.9,391-1218.5,340.7c364.4,233.5,796.7,369.7,1261.6,369.7
                    c1513.8,0,2341.4-1254,2341.4-2341.6c0-35.9-0.5-71.2-2.2-106.5C5041.8,2252.9,5234.9,2144.7,5345.2,1979.6z"/>
            </g>
            </g>
            </svg>
            </span>
            </span>
        </a>';

	return $string;
}

add_shortcode( 'inline-ctt', 'objectiv_click_to_tweet_inline' );
