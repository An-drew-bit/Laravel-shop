<?php

namespace App\Providers;

use App\Contracts\RouteRegistrar;
use App\Routing\AppRegistrar;
use Domain\Cart\Routing\CartRegistrar;
use Domain\Catalog\Routing\CatalogRegistrar;
use Domain\Order\Routing\OrderRegistrar;
use Domain\Product\Routing\ProductRegistrar;
use Domain\User\Routing\AuthRegistrar;
use Domain\User\Routing\ProfileRegistrar;
use Domain\User\Routing\VerifyEmailRegistrar;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\RateLimiter;
use RuntimeException;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';

    protected array $registrars = [
        CartRegistrar::class,
        AppRegistrar::class,
        AuthRegistrar::class,
        ProfileRegistrar::class,
        VerifyEmailRegistrar::class,
        CatalogRegistrar::class,
        ProductRegistrar::class,
        OrderRegistrar::class,
    ];

    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(fn(Registrar $router) => $this->mapRoutes($router, $this->registrars));
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('global', fn(Request $request) => Limit::perMinute(500)
                ->by($request->user()?->id ?: $request->ip())
                ->response(fn(Request $request, array $headers) =>
                response('Take it easy', Response::HTTP_TOO_MANY_REQUESTS, $headers)));

        RateLimiter::for('auth', fn(Request $request) => Limit::perMinute(20)
            ->by($request->ip()));

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    protected function mapRoutes(Registrar $router, array $registrars)
    {
        foreach ($registrars as $registrar) {
            if (!class_exists($registrar) || !is_subclass_of($registrar, RouteRegistrar::class)) {
                throw new RuntimeException(sprintf(
                    'Cannot map routes \'%s\', it is not valid route class',
                    $registrar
                ));
            }

            (new $registrar)->map($router);
        }
    }
}
