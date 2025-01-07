<?php
/**
 * Created by PhpStorm.
 * User: Shokhaa
 * Date: 06/01/25
 * Time: 16:11
 */

namespace Shokhaa\BotLib\Example;

use Shokhaa\BotLib\Generator;
use Shokhaa\BotLib\Handler\BaseHandler;
use Shokhaa\BotLib\Request\RequestInterface;

class ChatStartHandler extends BaseHandler implements RequestInterface
{

    public function canHandle(): bool
    {
        $text = $this->request['message']['text'] ?? false;
        return $text === 'start';
    }

    public function handle(): void
    {
        $this->bot->send('sendMessage', [
            'text'         => 'Hello !!!!',
            'reply_markup' => json_encode([
//                'keyboard'        => [
//                    [Generator::keyboardButton('Hola')]
//                ],

                'inline_keyboard' => [
                    [Generator::inlineButton('Hello', 'https://t.me/shokhaa')],
                ],

                'resize_keyboard' => true,
            ]),

        ]);
    }
}