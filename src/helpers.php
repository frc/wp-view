<?php

use Frc\WP\View\Factory;
use Frc\WP\View\FileFinder;
use Frc\WP\View\Component\Factory as ComponentFactory;
use Frc\WP\View\Options;

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

function frc_component($component, $data = [])
{
    $namespace = Options::get('namespace', '\\Theme\\App\\View');

    $view = (new ComponentFactory($namespace))->make($component, $data);

    if (! is_array($view)) {
        return $view;
    }

    return frc_view($view['view'], $view['data']);
}
