<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        config([
            'app.IMGS_URL' => getSetting('imgs_url') ?? 'http://localhost/salon-mirror/',
            'app.DEFAULT_IMAGE' => getSetting('default_image_path') ?? base_path('public/backend/assets/img/default.png'),
            'app.UPLOAD_PATH' => base_path(getSetting('upload_path') ?? 'storage/app/public/uploads/'),
            'app.DELETE_PATH' => base_path(getSetting('delete_path') ?? 'storage/app/public/uploads/'),
        ]);

        // Share notice/update with all views
        View::composer('*', function ($view) {
            // ============================================
            // OPTION 1: Static Notice (Currently Active)
            // ============================================
            // Simply change the message, type, or set 'show' to false to hide
            $view->with('globalNotice', [
                'show' => true, // Set to false to hide notice
                'message' => 'Important Update: School will be closed on December 25th for Christmas holiday.',
                'type' => 'info', // Options: 'info', 'success', 'warning', 'danger'
                'dismissible' => true, // Allow users to dismiss the notice
            ]);

            // ============================================
            // OPTION 2: Database-Driven Notice
            // ============================================
            // Uncomment the code below and comment out Option 1 to use database-driven notices
            // Make sure you've run the migration: php artisan migrate
            /*
            try {
                $school = \App\Models\User::where(['active' => '1', 'id' => '2'])->first();
                if ($school) {
                    $now = now();
                    $notice = \App\Models\Notice::where('school_id', $school->id)
                        ->where('active', true)
                        ->where(function($query) use ($now) {
                            $query->whereNull('start_date')
                                  ->orWhere('start_date', '<=', $now);
                        })
                        ->where(function($query) use ($now) {
                            $query->whereNull('end_date')
                                  ->orWhere('end_date', '>=', $now);
                        })
                        ->orderBy('seq', 'asc')
                        ->orderBy('created_at', 'desc')
                        ->first();
                    
                    if ($notice) {
                        $view->with('globalNotice', [
                            'show' => true,
                            'message' => $notice->message,
                            'type' => $notice->type ?? 'info',
                            'dismissible' => $notice->dismissible ?? true,
                        ]);
                    } else {
                        $view->with('globalNotice', ['show' => false]);
                    }
                } else {
                    $view->with('globalNotice', ['show' => false]);
                }
            } catch (\Exception $e) {
                // If Notice model doesn't exist, fallback to no notice
                $view->with('globalNotice', ['show' => false]);
            }
            */
        });
    }
}
