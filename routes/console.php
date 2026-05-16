<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('seed {--class=DatabaseSeeder} {--database=} {--force}', function () {
    Artisan::call('db:seed', array_filter([
        '--class' => $this->option('class'),
        '--database' => $this->option('database'),
        '--force' => $this->option('force'),
    ], static fn ($value) => $value !== null && $value !== false && $value !== ''));

    $this->output->write(Artisan::output());
})->purpose('Run database seeders');
