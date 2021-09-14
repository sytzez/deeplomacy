<?php

namespace App\Contracts;

use Illuminate\Contracts\View\View;

interface ViewComposerContract
{
    public function compose(View $view): void;
}
