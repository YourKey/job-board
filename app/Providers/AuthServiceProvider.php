<?php declare(strict_types=1);

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('edit-job', function (User $user, JobVacancy $job) {
            return $user->id === $job->user_id;
        });
        Gate::define('update-job', function (User $user, JobVacancy $job) {
            return $user->id === $job->user_id;
        });
        Gate::define('delete-job', function (User $user, JobVacancy $job) {
            return $user->id === $job->user_id;
        });
    }
}
