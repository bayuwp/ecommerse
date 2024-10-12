<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $data = [];

    public function __construct()
    {
        $this->data['breadcrumbs'] = [];
        $this->data['pageLevels'] = [];
        $this->data['title'] = 'Dashboard';
        $this->data['notifications'] = (object) [
            'unread' => 0,
            'notifications' => [],
        ];
    }

    protected function addBreadcrumb($name, $url = null)
    {
        $breadcrumb = (object) [
            'name' => $name,
            'url' => $url
        ];

        $this->data['breadcrumbs'][] = $breadcrumb;
    }

    // protected function addPageLevel($key, $value, $url = "#")
    // {
    //     $this->data['pageLevels'][] = (object) [
    //         'key' => $key,
    //         'value' => $value,
    //         'url' => $url,
    //     ];
    // }

    protected function getBreadcrumbs()
    {
        return $this->data['breadcrumbs'];
    }

    protected function setTitle($title)
    {
        $this->data['title'] = $title;
    }

    protected function getTitle()
    {
        return $this->data['title'];
    }

    protected function setData($key, $value)
    {
        $this->data[$key] = $value;
    }

    protected function getData($key)
    {
        return $this->data[$key] ?? null;
    }

    protected function setDrillUp($url)
    {
        $this->data['drillUp'] = $url;
    }
}
