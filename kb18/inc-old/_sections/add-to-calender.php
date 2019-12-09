<?php

function obj_add_to_calender_section( $content_section = null, $section_classes = null, $bg_shapes = null) { 
    
    $sec_meta = decide_section_meta( 'atc', $section_classes, $content_section, $bg_shapes );

    if ( ! empty( $content_section ) ) {
        do_section_top( $sec_meta );
        obj_do_atc( $content_section );
        do_section_bottom( $sec_meta );
    }
}
function obj_do_atc($content_section = null){ ?>
    <script>
        jQuery( document ).ready(function (){
            jQuery(".ace_btn").addcalevent({
                'apps': [1,2,3],
                'ics': "http://url to ics generator"
            });
        });
    </script>
    <?php
    $atc_events = $content_section['atc_events'];
    
    if(!empty($atc_events)){
        echo "<div class='wrap'>";
        echo "<div class='cta-block-grid section-intro-blurb'>";
        foreach($atc_events as $atc_events_val){
            
            echo "<div class='cta-block green-block'>";
            echo "<div class='cta-block__content card-detail-main'>";
            echo "<div class='card-detail-wrap'>";
            if ( array_key_exists( 'cxpa_atc_event_title', $atc_events_val ) ) {
               echo "<h3 class='cta-block__title'>";
               echo $atc_events_val['cxpa_atc_event_title'];
               echo "</h3>";
            }           
            if ( array_key_exists( 'cxpa_atc_event_des', $atc_events_val ) ) {
               echo "<div class='cta-block__blurb'>";
               echo "<p>".$atc_events_val['cxpa_atc_event_des']."</p>";
               echo "</div>";
            }
            echo "</div>";
            if ( array_key_exists( 'cxpa_atc_event_start_date', $atc_events_val ) ) {
                $event_title        = $atc_events_val['cxpa_atc_event_title'];
                $event_description  = $atc_events_val['cxpa_atc_event_des'];
                $event_start_date   = $atc_events_val['cxpa_atc_event_start_date'];
                $event_end_date     = $atc_events_val['cxpa_atc_event_end_date'];
                $event_detail       = $atc_events_val['show_atc_event_details'];
                $event_timezone     = $atc_events_val['show_atc_event_time_zone'];
                $event_btn          = $atc_events_val['cxpa_atc_event_button'];
                $sow_event_btn      = $atc_events_val['show_add_to_calendar_button'];                
//                $cal_des            = $event_description.$event_detail;
                $cal_des            = preg_replace('/(\r\n|\r|\n)+/',"<br>",$event_description."\n \n".$event_detail);
                if($sow_event_btn == true) {
                    $date_s_formate     = strtotime($event_start_date);
                    $event_start_date   = date("M d, Y H:i:s", $date_s_formate);
                    $date_d_formate     = strtotime($event_end_date);
                    $event_end_date     = date("M d, Y H:i:s", $date_d_formate);
                    $updat_event_s_date = convertDateFromTimezone($event_start_date,$event_timezone,'UTC','M d, Y H:i:s');
                    $updat_event_e_date = convertDateFromTimezone($event_end_date,$event_timezone,'UTC','M d, Y H:i:s');
                    echo "<span class='green-button'>"; ?>
                     <a class="ace_btn dis" data-ace='{"title":"<?php echo $event_title;?>","desc":"<?php echo $cal_des;?>","time":{"start":"<?php echo $updat_event_s_date;?>","end":"<?php echo $updat_event_e_date;?>"}}'>
                        <?php echo $event_btn;?>
                    </a>
                    <?php
                    echo "</span>";
                }
            }         
            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";
    }
          
} 
function convertDateFromTimezone($date,$timezone,$timezone_to,$format){
    $date = new DateTime($date,new DateTimeZone($timezone));
    $date->setTimezone( new DateTimeZone($timezone_to) );
    return $date->format($format);
}
?>