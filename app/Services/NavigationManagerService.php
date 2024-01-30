<?php

namespace App\Services;

use App\Repository\NavigationManagerRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class NavigationManagerService implements NavigationManagerRepository
{
    public function loadView(
        string $view,
        array $data = []
    ): View {
        return view(
            $this->getViewName($view),
            $data
        );
    }

    public function redirectBack(
        int $status = 302,
        array $headers = [],
        $fallback = false,
        array $with = []
    ): RedirectResponse {
        return redirect()->back(
            $status,
            $headers,
            $fallback
        )->with($with);
    }

    public function redirectRoute(
        string $route,
        array $parameters = [],
        int $status = 302,
        array $headers = [],
        bool $secure = null,
        array $with = []
    ): RedirectResponse {
        return redirect()->route(
            $this->getRouteName($route),
            $parameters,
            $status,
            $headers,
            $secure
        )->with($with);
    }

    public function getRouteName(string $route)
    {
        return Route::has($route) ? Route::getRoutes()->getByName($route)->getName() : 'routeDoesNotExist';
    }

    public function getViewName(string $view)
    {
        return view()->exists($view) ? $view : 'viewDoesNotExist';
    }
}
