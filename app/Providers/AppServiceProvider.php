<?php

namespace App\Providers;

use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('ends_after_start', function ($attribute, $value, $parameters, $validator) {
            $startDateTime = new DateTime($validator->getData()[$parameters[0]]);
            $endDateTime = new DateTime($value);
            return $endDateTime > $startDateTime && $endDateTime->format('Y-m-d') === $startDateTime->format('Y-m-d');
        });

        Validator::replacer('ends_after_start', function ($message, $attribute, $rule, $parameters) {
            return str_replace([':other', ':attribute'], [$parameters[0], $attribute], $message);
        });
    }
}
