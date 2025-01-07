<?php
/**
 * Created by PhpStorm.
 * User: Shokhaa
 * Date: 07/01/25
 * Time: 12:49
 */

namespace Shokhaa\BotLib\Example;

use Shokhaa\BotLib\Handler\BaseHandler;
use Shokhaa\BotLib\Request\MessageInterface;

class BackButtonHandler extends BaseHandler implements MessageInterface
{


    public function canHandle(): bool
    {
        if ($this->bot->getConnection() == null) {
            return false;
        }
        return  true;
    }

    public function handle(): void
    {
        $lastHistory = $this->bot->getConnection()->getLastHistory($this->bot->chatId);
    }
}