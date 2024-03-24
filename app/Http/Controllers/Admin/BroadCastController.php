<?php

namespace App\Http\Controllers\Admin;

use App\Events\Hello;
use App\Events\TestEvent;

class BroadCastController
{
    public function index()
    {
       // e//vent(new TestEvent());

        event(new Hello());

    }
}
