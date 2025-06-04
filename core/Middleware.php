<?php

namespace App\Core;
abstract class Middleware {
    abstract public function handle(Request $request, Closure $next);

    public static function pipe(array $middlewares): Closure {
        return array_reduce(
                array_reverse($middlewares),
                fn($next, $middleware) => fn($request) => (new $middleware)->handle($request, $next),
                fn($request) => $request
        );
    }
}