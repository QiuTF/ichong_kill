<?php

declare(strict_types=1);

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

