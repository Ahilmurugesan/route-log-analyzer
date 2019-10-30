<?php

namespace Ahilan\LogViewer;

use Ahilan\LogViewer\Middleware\RouteUsageMiddleware;
use Carbon\Carbon;
use Illuminate\Foundation\Console\PresetCommand;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

/**
 * Class LogViewerServiceProvider
 *
 * @package Ahilan\LogViewer
 *
 * @author Ahilan
 */
class LogViewerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        //To load routes for the package
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');


        //To load the view files for the package
        $this->loadViewsFrom(__DIR__.'/resource/views', 'logViewer');

        //To load the migrations files for the package
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $router->aliasMiddleware('routeusage', RouteUsageMiddleware::class);

        //Preset command for the seeding operations
        PresetCommand::macro('routeseed', static function ($command) {
            $routes = [];
            foreach (Route::getRoutes()->getIterator() as $route){
                $routes['uri'][] =  $route->uri();
                $routes['action'][] = $route->getAction();
            }
            if(Schema::hasTable('route_usages')) {
            foreach($routes['action'] as $key => $value)
            {
                DB::table('route_usages')
                    ->Insert([
                        'route_name' => isset($value['as']) ?
                                        $value['as'] : null,
                        'uri' => isset($routes['uri'][$key]) ?
                                 $routes['uri'][$key] : null,
                        'controller' => isset($value['controller']) ?
                                        $value['controller'] : null,
                        'prefix' => isset($value['prefix']) ?
                                    $value['prefix'] : null,
                        'count' => 0,
                        'last_accessed' => null,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
            }
                $command->info('Seeding installed successfully.');
            }
            else
            {
                $command->info('Please run the migration command.');
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
        //To Register the needed providers

    }
}
