<?php
/**
 * Created by PhpStorm.
 * User: Shokhaa
 * Date: 06/01/25
 * Time: 14:21
 */

namespace Shokhaa\BotLib\Handler;

use Shokhaa\BotLib\Bot;
use Shokhaa\BotLib\Request\RequestInterface;

class RequestHandler
{

    private bool $isHandled = false;

    public function __construct(private Bot $bot, private array $request)
    {
    }


    public function on(string $handlerClassName): self
    {
        if (!is_subclass_of($handlerClassName, RequestInterface::class)) {
            throw new \InvalidArgumentException('Handler class must be instance of ' . RequestInterface::class);
        }

        if ($this->isHandled === false) {
            $handler = new $handlerClassName($this->bot, $this->request);
            if ($handler->canHandle()) {
                $handler->handle();
                $this->isHandled = true;
            }
        }

        return $this;
    }


    public function forceHandle(string $handlerClassName): void
    {
        $handler = new $handlerClassName($this->bot, $this->request);
        $handler->handle();
    }
}