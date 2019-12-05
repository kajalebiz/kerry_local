<?php
function obj_prepared_section( $content_section = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'prepare', $section_classes, $content_section, $bg_shapes );

	if ( ! empty( $content_section ) ) {

		do_section_top( $sec_meta );
		obj_do_prepare( $content_section );
		do_section_bottom( $sec_meta );
	}
}

function obj_do_prepare( $content_section = null ) {
    global $post;
    
    $prepared_content           = $content_section['prepared_content'];
    if ( array_key_exists( 'sec_title', $content_section ) && ! empty( $content_section['sec_title'] ) ) {
        echo "<h2 class='section-title page-color'>";
        echo $content_section['sec_title'];
        echo '</h2>';
    }

    if( array_key_exists( 'prepared_content', $content_section ) && !empty( $prepared_content )){
        echo "<div class='be_prepared_listing'>";
        echo "<ul>";
        foreach($prepared_content as  $prepared_content_key => $prepared_content_val){
            $event_prepare_title        = $prepared_content_val['event_prepare_title'];
            $event_prepare_description  = $prepared_content_val['event_prepare_description'];
            if(!empty($event_prepare_title) || !empty($event_prepare_description)){
                echo "<li><label class='check_box'><input type='checkbox' class='prepared_co prepared_session-".$prepared_content_key.$post->ID."' data-session='prepared_session-".$prepared_content_key.$post->ID."'><span class='checkbox_check'></span>";
                    if(!empty($event_prepare_title)){
                        echo "<strong>$event_prepare_title</strong>";
                    }
                     if(!empty($event_prepare_title)){
                        echo $event_prepare_description;
                    }
                echo "</label></li>";
            }
        }
        echo "</ul>";
        echo "</div>";
    }
    
}

function obj_count_prepared_section( $content_section = null, $section_classes = null, $bg_shapes = null ) {

	$sec_meta = decide_section_meta( 'prepare', $section_classes, $content_section, $bg_shapes );

	if ( ! empty( $content_section ) ) {

		do_section_top( $sec_meta );
		obj_do_count_prepare( $content_section );
		do_section_bottom( $sec_meta );
	}
}

function obj_do_count_prepare( $content_section = null ) {
    global $post;
    
    $prepared_content           = $content_section['prepared_content'];
    if ( array_key_exists( 'sec_title', $content_section ) && ! empty( $content_section['sec_title'] ) ) {
        echo "<h2 class='section-title page-color'>";
        echo $content_section['sec_title'];
        echo '</h2>';
    }

    if( array_key_exists( 'prepared_content', $content_section ) && !empty( $prepared_content )){
        echo "<div class='be_prepared_listing'>";
        echo "<ul>";
        foreach($prepared_content as  $prepared_content_key => $prepared_content_val){
            $event_prepare_title        = $prepared_content_val['countdown_prepare_title'];
            $event_prepare_description  = $prepared_content_val['countdown_prepare_description'];
            if(!empty($event_prepare_title) || !empty($event_prepare_description)){
                echo "<li><label class='check_box'><input type='checkbox' class='prepared_co prepared_session-".$prepared_content_key.$post->ID."' data-session='prepared_session-".$prepared_content_key.$post->ID."'><span class='checkbox_check'></span>";
                    if(!empty($event_prepare_title)){
                        echo "<strong>$event_prepare_title</strong>";
                    }
                     if(!empty($event_prepare_title)){
                        echo $event_prepare_description;
                    }
                echo "</label></li>";
            }
        }
        echo "</ul>";
        echo "</div>";
    }
    
}