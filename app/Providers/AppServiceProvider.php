<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Menu;
use View;

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
        View::composer('*', function ($view) {
            $user = auth()->user();
            $role = $user ? strtolower($user->role_name) : null;
    
            // Define allowed top-level menus per role
            $allowedMenus = [];
            // Define allowed child menu titles per role
            $allowedChildMenus = [];
    
            switch ($role) {
                case 'admin':
                    $allowedMenus = ['Dashboard', 'User Management'];
                    $allowedChildMenus = ['Admin Dashboard', 'List Users'];
                    break;
                case 'student':
                    $allowedMenus = ['Dashboard', 'Registration', 'Logbook Activity', 'Consultations', 'Report Submission', 'Download Documents', 'Evaluation'];
                    $allowedChildMenus = ['Student Dashboard', 'Documents', 'Registration Form', 'Daily Activity', 'My Consultations', 'Upload Reports', 'My Evaluation'];
                    break;
                case 'advisor':
                    $allowedMenus = ['Dashboard', 'Students Internship', 'Consultations', 'Evaluation', 'Approval', 'Report Submission', 'Evaluation'];
                    $allowedChildMenus = ['Teacher Dashboard', 'Internship Registrations', 'See Consultations', 'See Reports', 'Students Evaluation'];
                    break;
                case 'coordinator':
                    $allowedMenus = ['Dashboard', 'Upload Documents', 'Internship Registration', 'Advisor Assigned Management', 'Students\' Internship Report'];
                    $allowedChildMenus = ['Coordinator Dashboard'];
                    break;
                default:
                    $allowedMenus = [];
                    $allowedChildMenus = [];
            }
    
            $menus = \App\Models\Menu::whereNull('parent_id')
                ->where('is_active', true)
                ->with('children')
                ->orderBy('order')
                ->get()
                ->filter(function ($menu) use ($allowedMenus, $allowedChildMenus) {
                    if (!in_array($menu->title, $allowedMenus)) {
                        return false;
                    }
                    // Filter children by allowedChildMenus
                    $menu->children = $menu->children->filter(function ($child) use ($allowedChildMenus) {
                        return in_array($child->title, $allowedChildMenus);
                    });
                    return true;
                });
    
            $view->with('menus', $menus);
        });
    }

}
