<?php

namespace YOOtheme\Theme\Wordpress;

class SystemCheck extends \YOOtheme\Theme\SystemCheck
{
    public function getRequirements()
    {
        $res = [];
        return array_merge($res, parent::getRequirements());
    }

    public function getRecommendations()
    {
        $res = [];

        if (!$this->theme->get('yootheme_apikey')) {
            $res[] = 'wp_apikey';
        }

        $path = basename($this->theme->path);
        if ($path !== 'yootheme') {
            $res[] = 'wp_theme_path';
        }

        return array_merge($res, parent::getRecommendations());
    }
}
