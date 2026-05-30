<?php

use App\Http\Controllers\Dashboard\ProjectController;
use App\Http\Controllers\Dashboard\PricingPackageController;
use App\Models\Project;
use App\Models\PricingPackage;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'projects' => Project::where('is_visible', true)
            ->orderBy('order_index')
            ->orderBy('id', 'desc')
            ->get(),
        'pricing_packages' => PricingPackage::orderBy('order_index')->get(),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');

    // Portfolio Projects Management CRUD routes
    Route::get('dashboard/projects', [ProjectController::class, 'index'])->name('dashboard.projects');
    Route::get('dashboard/projects/github-repos', [ProjectController::class, 'githubRepos'])->name('dashboard.projects.github-repos');
    Route::post('dashboard/projects', [ProjectController::class, 'store'])->name('dashboard.projects.store');
    Route::post('dashboard/projects/{project}', [ProjectController::class, 'update'])->name('dashboard.projects.update'); // POST for update with file upload
    Route::delete('dashboard/projects/{project}', [ProjectController::class, 'destroy'])->name('dashboard.projects.destroy');

    // Pricing Packages Management CRUD routes
    Route::resource('dashboard/pricing-packages', PricingPackageController::class)->except(['create', 'show', 'edit']);
});

require __DIR__.'/settings.php';
