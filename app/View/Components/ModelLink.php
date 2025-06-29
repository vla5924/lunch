<?php

namespace App\View\Components;

use App\Helpers\RouteHelper;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class ModelLink extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public Model $model) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.model-link', [
            'href' => RouteHelper::show($this->model),
        ]);
    }
}
