<?php 

namespace Sirdoro\UrlVerify;

use Illuminate\Support\ServiceProvider;
use App\Http\Kernel;

class UrlVerifyServiceProvider extends ServiceProvider
{
    public function boot(Kernel $kernel)
    {
        $kernel->appendMiddlewareToGroup('web','Sirdoro\UrlVerify\Http\Middleware\UrlVerify::class');

        $this->publishes([
            __DIR__.'/config/url-verify.php' => config_path('url-verify.php'),
        ]);

    }

    public function register()
    {
        $this->mergeConfigFrom(
        __DIR__.'/config/url-verify.php', 'url-verify'
    );
    }
}