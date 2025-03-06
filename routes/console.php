<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('plans:expire')->daily()->onOneServer();

Schedule::command('auth:clear-resets')->everyFifteenMinutes();