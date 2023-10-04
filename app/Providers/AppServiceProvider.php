<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades;
use Illuminate\View\View;

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
        Paginator::useBootstrapFive();

        Facades\View::composer('auth.register', function (View $view) {
            $view->with('gender_choice', User::GENDER_CHOICE);
            $view->with('religion_choice', User::RELIGION_CHOICE);
        });
        Facades\View::composer('livewire.admin.account-admin.detail', function (View $view) {
            $view->with('gender_choice', User::GENDER_CHOICE);
            $view->with('religion_choice', User::RELIGION_CHOICE);
        });
        Facades\View::composer('livewire.admin.account-member.detail', function (View $view) {
            $view->with('gender_choice', User::GENDER_CHOICE);
            $view->with('religion_choice', User::RELIGION_CHOICE);
        });


        Facades\View::composer('member.pages.profile.edit', function (View $view) {
            $view->with('gender_choice', User::GENDER_CHOICE);
            $view->with('religion_choice', User::RELIGION_CHOICE);
        });
    }
}
