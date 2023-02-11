<?php

namespace App\View\Components\Extras;

use Illuminate\Support\Facades\View;
use Illuminate\View\Component;

class ViewExtra extends Component
{

    protected $viewNamespace = 'components.extras.';
    protected $view = '';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view($this->getViewPath());
    }

    public function getViewPath(): string
    {
        $pattern = '%s.%s';

        $path = sprintf($pattern, $this->viewNamespace, $this->getViewName());
        if (!View::exists($path)) {
            $path = sprintf($pattern, $this->viewNamespace, 'blank');
        }

        return $path;
    }

    public function getViewName()
    {
        if (empty($this->view)) {
            $class = get_called_class();
            $className = substr($class, strrpos($class, "\\") + 1);
            $this->view = strtolower($className);
        }
        return $this->view;
    }
}
