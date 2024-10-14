<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Tour;

class TourSelect extends Component
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
        $tours = Tour::all()->toArray();
        return view('components.tour-select', ['tours' => $tours]);
    }
}
