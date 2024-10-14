<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SidebarItem extends Component
{
    public $icon;
    public $label;
    public $route;
    public $dropdownItems;

    public function __construct($icon, $label, $route, $dropdownItems = [])
    {
        $this->icon = $icon;
        $this->label = $label;
        $this->route = $route;
        $this->dropdownItems = $dropdownItems;
    }

    public function render()
    {
        return view('components.sidebar-item');
    }
}
