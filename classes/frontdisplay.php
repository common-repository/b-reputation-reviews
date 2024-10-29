<?php

namespace b_reputation;

class frontdisplay extends singleton {

    function b_reputation_display() {

        ob_start();
        $setting = get_option(B_Reputation_Settings);
        ?>
        <div id="BR-widget-reviews<?php echo $setting[B_Reputation_Siren_Field] ?>">
            <a target="_blank" href="https://b-reputation.com/fr/public/<?php echo $setting[B_Reputation_Siren_Field] ?>">Les avis de <?php echo $setting[B_Reputation_Company_Name_Field] ?></a>
        </div>

        <?php
        $output_string = ob_get_contents();
        wp_enqueue_script('b_reputation_script');

        ob_end_clean();
        return $output_string;
    }

    function b_reputation_register_script() {
        wp_register_script('b_reputation_script', '//statics.b-reputation.com/widget/reviews/BR-embed.js', array(), NULL, true);
    }

    function add_attributes_to_script($tag, $handle) {
        $setting = get_option(B_Reputation_Settings);
        if ('b_reputation_script' !== $handle)
            return $tag;
        return str_replace(' src', ' data-siren="' . $setting[B_Reputation_Siren_Field] . '" src', $tag);
    }

}
