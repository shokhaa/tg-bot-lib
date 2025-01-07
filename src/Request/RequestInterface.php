<?php
/**
 * Created by PhpStorm.
 * User: Shokhaa
 * Date: 06/01/25
 * Time: 14:34
 */

namespace Shokhaa\BotLib\Request;

use Shokhaa\BotLib\Bot;

interface RequestInterface
{

    public function canHandle(): bool;

    public function handle(): void;
}