<?php

namespace Frc\WP\View;

class Options {

    public static function get($key, $default = '') {

        $feature = get_theme_support('frc-view');

        if ( isset($feature[0][$key]) ) {
            return $feature[0][$key];
        }

        return $default;

    }

}
