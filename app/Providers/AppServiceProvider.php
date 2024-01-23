<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // binds interface to repository
        foreach ([
                    "User" => ["User"],
                    "Interest"=>["Interest"],
                    "PasswordReset"=>["PasswordReset"],
                    "FriendRelation"=>["FriendRelation"],
                    "Group"=>["Group"],
                    "GroupChat"=>["GroupChat"],
                    "GroupUser"=>["GroupUser"],
                    "Event"=>["Event"],
                    "EventInvite"=>["EventInvite"],
                    "Spot"=>["Spot"],
                    "SpotImage"=>["SpotImage"],
                    "SpotVideo"=>["SpotVideo"],
                    "SpotDetail"=>["SpotDetail"],
                    "SpotDetailPhoto"=>["SpotDetailPhoto"],
                    "SpotDetailVideo"=>["SpotDetailVideo"],
                    "Post"=>["Post"],
                    "PostLike"=>["PostLike"],
                    "PostComment"=>["PostComment"],
                    "PostImage"=>["PostImage"],
                    "PostVideo"=>["PostVideo"],
                    "PostAudio"=>["PostAudio"],
                    "SpotInvite"=>["SpotInvite"],
                    "GoToList"=>["GoToList"],
                    "Planning"=>["Planning"],
                    "PlanningInvitation"=>["PlanningInvitation"],
                    "Filter"=>["Filter"],
                    "Chat"=>["Chat"],
                    "Notification"=>["Notification"],
                    "Page"=>["Page"],
                    "FourSquare"=>["FourSquare"],
                    "Agreegate"=>["Agreegate"],
                    "Subscription"=>["Subscription"],
                    "SocialLogin"=>["SocialLogin"],
                    "City"=>["City"],
                    "PostStatus"=>["PostStatus"],
                    "Expertise"=>["Expertise"],
                    "UserExpertise"=>["UserExpertise"],
                    "CMS"=>["CMS"],
                    "UserFollow"=>["UserFollow"],
                 ] as $_dir => $_names) {
            foreach ($_names as $_eachName) {
                $this->app->bind(
                    "App\Repositories\\" . $_dir . "\\" . $_eachName . "Interface",
                    "App\Repositories\\" . $_dir . "\\" . $_eachName . "Repository"
                );
                $this->app->alias("App\Repositories\\" . $_dir . "\\" . $_eachName . "Interface", $_eachName);
            }

        }


        // Without Interface
        // $array = [
        //     'DoAuth' => ['DoAuth',]
        // ];
        // foreach ($array as $_dir => $_names) {
        //     foreach ($_names as $_eachName) {
        //         $this->app->alias('App\Repositories\\' . $_dir . '\\' . $_eachName . 'Repository', $_eachName);
        //     }
        // }

        $this->app->singleton('Illuminate\Contracts\Routing\ResponseFactory', function ($app) {
            return new \Illuminate\Routing\ResponseFactory(
                $app['Illuminate\Contracts\View\Factory'],
                $app['Illuminate\Routing\Redirector']
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->registerPolicies();

        if (! $this->app->routesAreCached()) {
            Passport::routes();
        }
        Paginator::useBootstrap();
    }
}
