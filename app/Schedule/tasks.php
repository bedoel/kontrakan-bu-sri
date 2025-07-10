<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('reminder:jatuh-tempo')->dailyAt('08:00');
