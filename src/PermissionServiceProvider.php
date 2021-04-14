<?php


namespace Iwindy\LaravelPermission;


use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Routing\PendingResourceRegistration;
use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    public function register()
    {
        Route::macro('auth', function () {

            $note = implode('|', $this->methods()) . ':' . $this->uri;
            $path = implode('.', func_get_args());
            Permission::$auth_nodes[$path] = ['path' => $path, 'permission' => $note];
            return $this;
        });

        PendingResourceRegistration::macro('auth', function () {
            $params = func_get_args();
            $routes = $this->register()->getRoutesByName();
            $route_names = [];
            $resource_name = $this->name;
            if (isset($params[1]) && is_array($params[1])) {
                foreach ($params[1] as $key => $value) {
                    $route_names[$resource_name . '.' . $key] = $params[0] . '.' . $value;
                }
            }

            foreach ($routes as $route_name => $route) {
                $note = implode('|', $route->methods()) . ':' . $route->uri;
                if (isset($params[0])) {
                    if (isset($route_names[$route_name])) {
                        $path = $route_names[$route_name];
                    } else {
                        $path = sprintf('%s.%s', $params[0], mb_substr($route_name, strpos($route_name, '.') + 1));
                    }
                } else {
                    $path = $route_name;
                }

                Permission::$auth_nodes[$path] = ['path' => $path, 'permission' => $note];
            }
        });
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../database');
            $this->publishes([
                __DIR__ . '/../resources/lang' => base_path('resources/lang')
            ], 'lang');
            $this->publishes([
                __DIR__ . '/../config' => base_path('config')
            ], 'config');
        }

        $this->registerPermissions();
    }

    public function registerPermissions(): bool
    {
        app(Gate::class)->before(function (Authorizable $user, string $ability) {
            if (method_exists($user, 'checkPermission')) {
                return $user->checkPermission($ability) ?: null;
            }
            return null;
        });

        return true;
    }
}
