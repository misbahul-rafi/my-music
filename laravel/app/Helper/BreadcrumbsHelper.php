<?php

namespace App\Helpers;

class BreadcrumbsHelper
{
    protected $breadcrumbs = [];

    public function add($title, $url = null)
    {
        $this->breadcrumbs[] = [
            'title' => $title,
            'url' => $url
        ];
        return $this;
    }

    public function get()
    {
        return $this->breadcrumbs;
    }
}
