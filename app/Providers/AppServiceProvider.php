<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('App\Repositories\CategoryNoteRepository');
        $this->app->bind('App\Repositories\UserRepository');
        $this->app->bind('App\Repositories\NoteRepository');

        \Validator::extend('note_unique', function($attribute, $value, $parameters, $validator) {

            $user = \Auth::user();
            $note = $user->notes()->where('title','=',$value)->first();

            if ($note == null){
                return true;
            }

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
