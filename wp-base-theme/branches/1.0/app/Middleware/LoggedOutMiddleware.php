<?php

declare(strict_types=1);

namespace App\Middleware;

use App\AppAwareTrait;
use Psr\Http\Message\ResponseInterface as HttpResponse;
use Psr\Http\Message\ServerRequestInterface as HttpRequest;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use tiFy\Routing\BaseMiddleware;
use tiFy\Support\Proxy\Redirect;

class LoggedOutMiddleware extends BaseMiddleware
{
    use AppAwareTrait;

    /**
     * @inheritDoc
     */
    public function process(HttpRequest $request, RequestHandler $handler): HttpResponse
    {
        return is_admin() || !is_user_logged_in() ? $handler->handle($request) : Redirect::to('/')->psr();
    }
}