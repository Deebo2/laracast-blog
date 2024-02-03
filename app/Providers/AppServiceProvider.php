<?php

namespace App\Providers;

use App\Models\User;
use App\Services\MailchimpNewsletter;
use App\Services\Newsletter;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use MailchimpMarketing\ApiClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        app()->bind(Newsletter::class,function(){
            $client = new ApiClient();
            $key = config('services.mailchimp.key');
            $client->setConfig([
                'apiKey' => $key,
                'server' => 'us21'
            ]);
            return new MailchimpNewsletter($client);
            });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Gate::define('admin',function(User $user){
            return $user->username === 'Deeb';
        });
        // Blade::if('admin', function(User $user){
        //     return request()->user()?->can('admin');
        // });
    }
}
