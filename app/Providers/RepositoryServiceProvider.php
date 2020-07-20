<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\{
    IQuestion,
    IUser,
    IReply
};
use App\Repositories\Eloquent\{
    QuestionRepository,
    UserRepository,
    ReplyRepository
};

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(IQuestion::class, QuestionRepository::class);
        $this->app->bind(IUser::class, UserRepository::class);
        $this->app->bind(IReply::class, ReplyRepository::class);
    }
}
