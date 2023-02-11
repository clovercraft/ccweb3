<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected string $viewNamespace = '';

    protected function render($view, $data = [])
    {
        return view(
            $this->namespacedView($view),
            $this->prepareGlobalData($data)
        );
    }

    private function namespacedView(string $view): string
    {
        if ($this->viewNamespace !== '') {
            $view = $this->viewNamespace . "." . $view;
        }
        return $view;
    }

    private function prepareGlobalData(array $data): array
    {
        if (Auth::check()) {
            $data['authuser'] = Auth::user();
        }
        return $data;
    }

    protected function isWhitelistEnabled(): bool
    {
        $toggle = Setting::where('key', 'whitelist-relay-enabled')->first();
        return $toggle->value === 'true';
    }
}
