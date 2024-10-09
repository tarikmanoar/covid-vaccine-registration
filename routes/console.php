<?php

use App\Models\VaccineRegistration;
use App\Notifications\VaccinationComplete;
use App\Notifications\VaccinationReminder;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->everySecond();

// Vaccination schedule
Artisan::command('vaccination:schedule', function () {
    VaccineRegistration::where('status', 'Not scheduled')
        ->orderBy('created_at')
        ->each(function ($registration) {
            $registration->update(['status' => 'Scheduled']);
            $registration->histories()->create([
                'status' => 'Scheduled',
                'note' => 'Vaccination scheduled',
            ]);
        });
})->purpose('Schedule vaccination for users')->daily();

// Vaccination reminder.
Artisan::command('vaccination:reminder', function () {
    VaccineRegistration::with('user')
        ->whereDate('date', Carbon::tomorrow())
        ->where('status', 'Scheduled')
        ->orderBy('created_at')
        ->each(function ($registration) {
            $registration->user->notify(new VaccinationReminder);
        });
})->purpose('Vaccination reminder for scheduled users')->dailyAt('21:00');

// Vaccination Completed.
Artisan::command('vaccination:complete', function () {
    VaccineRegistration::with('user')
        ->whereDate('date', Carbon::today())
        ->where('status', 'Scheduled')
        ->orderBy('created_at')
        ->each(function ($registration) {
            $registration->user->notify(new VaccinationComplete);
            $registration->update(['status' => 'Vaccinated']);
            $registration->histories()->create([
                'status' => 'Vaccinated',
                'note' => 'Vaccination completed',
            ]);
        });
})->purpose('Mark vaccination completed for scheduled users')->daily();
