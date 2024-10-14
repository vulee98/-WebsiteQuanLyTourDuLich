<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\User;

class GuideSelectComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $guides = User::all()->where('role', 'guide')->toArray();
        return view('components.guide-select-component', ['guides' => $guides]);
    }
}
