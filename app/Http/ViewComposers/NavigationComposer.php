<?php

namespace App\Http\ViewComposers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NavigationComposer {

    /**
     * @param View $view
     */
    public function compose(View $view) {
        // If a user isn't signed into the site
        if (!Auth::check())
            return;

        $view->with('channel', Auth::user()->channel->first());
    }
}