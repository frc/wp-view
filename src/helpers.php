<?php

use Frc\WP\View\Factory;
use Frc\WP\View\FileFinder;

function frc_view($view = null, $data = [])
{
    static $factory;

    if (! $factory) {
        $factory = new Factory(
            new FileFinder([
                get_theme_file_path('/views'),
                get_parent_theme_file_path('/views'),
            ])
        );
    }

    if (! $view) {
        return $factory;
    }

    return $factory->make($view, $data);
}

function isAssoc($array) {
	return array_keys($array) !== range(0, count($array) - 1);
}
