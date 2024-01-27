<?php

namespace App\Repository;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

interface NavigationManagerRepository
{
  // loadView() method will be used to load the view
  public function loadView(
    string $view,
    array $data = []
  ): View;

  // redirectBack() method will be used to redirect the user back
  public function redirectBack(
    int $status = 302,
    array $headers = [],
    $fallback = false,
    array $with = []
  ): RedirectResponse;

  // redirectRoute() method will be used to redirect the user to a named route
  public function redirectRoute(
    string $route,
    array $parameters = [],
    int $status = 302,
    array $headers = [],
    bool $secure = null,
    array $with = []
  ): RedirectResponse;
}
