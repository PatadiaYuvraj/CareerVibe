<?php

namespace App\Services;

use App\Repository\NavigationManagerRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NavigationManagerService implements NavigationManagerRepository
{
    public function loadView(
        string $view,
        array $data = []
    ): View {
        return view($view, $data);
    }

    public function redirectBack(
        int $status = 302,
        array $headers = [],
        $fallback = false,
        array $with = []
    ): RedirectResponse {
        return redirect()->back($status, $headers, $fallback)->with($with);
    }

    public function redirectRoute(
        string $route,
        array $parameters = [],
        int $status = 302,
        array $headers = [],
        bool $secure = null,
        array $with = []
    ): RedirectResponse {
        return redirect()->route($route, $parameters, $status, $headers, $secure)->with($with);
    }

    // return $this->navigationManagerService->loadView('view-name');
    // return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "message"]);
    // return $this->navigationManagerService->redirectRoute('view-name', [], 302, [], false, ["success" => "message"]);
}
