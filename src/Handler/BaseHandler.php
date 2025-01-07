<?php
/**
 * Created by PhpStorm.
 * User: Shokhaa
 * Date: 07/01/25
 * Time: 11:40
 */

namespace Shokhaa\BotLib\Handler;

use Shokhaa\BotLib\Bot;

abstract class BaseHandler
{
    public function __construct(protected Bot $bot, protected array $request)
    {
    }
}