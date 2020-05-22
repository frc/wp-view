<?php

use Frc\WP\View\Factory;
use Frc\WP\View\FileFinder;
use Frc\WP\View\Component\Factory as ComponentFactory;
use Frc\WP\View\Options;

function frc_view($view = null, $data = [], $mergeData = [])
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

    return $factory->make($view, $data, $mergeData);
}

function frc_component($component, $data = [], $mergeData = [])
{
    $namespace = Options::get('namespace', '\\Theme\\App\\View');

    $view = (new ComponentFactory($namespace))->make($component, $data, $mergeData);

    if (! is_array($view)) {
        return $view;
    }

    return frc_view($view['view'], $view['data']);
}
