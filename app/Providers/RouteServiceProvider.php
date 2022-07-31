<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapAdminRoutes();

        $this->mapSupportTicketRoutes();

        $this->mapWebRoutes();

        $this->mapOfflinePaymentRoutes();

        //$this->mapInstallRoutes();

        //$this->mapUpdateRoutes();
    }

    /**
   * Define the "updating" routes for the application.
   *
   * These routes all receive session state, CSRF protection, etc.
   *
   * @return void
   */
   protected function mapUpdateRoutes()
   {
      Route::middleware('web')
        ->namespace($this->namespace)
        ->group(base_path('routes/update.php'));
   }

  /**
   * Define the "installation" routes for the application.
   *
   * These routes all receive session state, CSRF protection, etc.
   *
   * @return void
   */
   protected function mapInstallRoutes()
   {
      Route::middleware('web')
        ->namespace($this->namespace)
        ->group(base_path('routes/install.php'));
   }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    protected function mapAdminRoutes()
    {
        Route::middleware('web')
           ->namespace($this->namespace)
           ->group(base_path('routes/admin.php'));
    }

    protected function mapSupportTicketRoutes()
    {
        Route::middleware('web')
           ->namespace($this->namespace)
           ->group(base_path('routes/support_tickets.php'));
    }

    protected function mapOfflinePaymentRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/offline_payment.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
