<?php

namespace Shokhaa\BotLib;

class Generator
{

    public static function inlineButton(string $text, ?string $url = null, ?string $callbackData = null, ?array $webApp = null): array
    {
        return array_filter([
            'text'          => $text,
            'url'           => $url,
            'callback_data' => $callbackData,
            'web_app'       => $webApp,
        ]);
    }

    public static function keyboardButton(string $text, bool $requestContact = null, bool $requestLocation = null, array $webApp = null): array
    {
        return array_filter([
            'text'             => $text,
            'request_contact'  => $requestContact,
            'request_location' => $requestLocation,
            'web_app'          => $webApp,
        ]);

    }
}