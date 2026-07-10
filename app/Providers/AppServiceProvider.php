<?php

namespace App\Providers;

use App\Models\Contact;
use App\Models\FraseInicio;
use App\Models\Submission;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super-Admin') ? true : null;
        });

        View::composer('layouts.admin', function ($view) {
            $messageStats = Contact::query()
                ->where('read', false)
                ->selectRaw('COUNT(*) as unread_count, MAX(created_at) as last_created_at')
                ->first();

            $submissionStats = Submission::query()
                ->where('read', false)
                ->selectRaw('COUNT(*) as unread_count, MAX(created_at) as last_created_at')
                ->first();

            $unreadMessagesCount = (int) ($messageStats->unread_count ?? 0);
            $unreadSubmissionsCount = (int) ($submissionStats->unread_count ?? 0);

            $lastMessageTime = $messageStats?->last_created_at
                ? Carbon::parse($messageStats->last_created_at)->diffForHumans()
                : 'Nenhuma mensagem';

            $lastSubmissionTime = $submissionStats?->last_created_at
                ? Carbon::parse($submissionStats->last_created_at)->diffForHumans()
                : 'Nenhuma submissão';

            $view->with([
                'adminBrandName' => FraseInicio::getParametro(PARAM_NOME_ORGANIZACAO) ?: config('app.name', 'CodeLab'),
                'unreadMessagesCount' => $unreadMessagesCount,
                'unreadSubmissionsCount' => $unreadSubmissionsCount,
                'lastMessageTime' => $lastMessageTime,
                'lastSubmissionTime' => $lastSubmissionTime,
            ]);
        });
    }
}
