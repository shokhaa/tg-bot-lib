<p align="center"><a href="https://php.net" target="_blank">
    <img src="https://www.php.net/images/logos/php-logo-white.svg" alt="PHP Logo">
</a></p>


A small library for working with [Telegram Bot Api][1] 


Installation
------------

Easiest and recommended way is with [Composer](https://getcomposer.org/download/)

    composer require shokhaa/tg-bot-lib


## Usage with database

```php
<?php

use Shokhaa\BotLib\Bot;
use Shokhaa\BotLib\Example\ChatStartHandler;

include './vendor/autoload.php';

$requestBody = json_decode(file_get_contents('php://input'), true);
try {
    $bot = new Bot($requestBody, [
        'historyEnabled' => true,
        'token'          => 'telegram bot token',
        'db'             => [
            'dsn'      => 'pgsql:host=localhost;dbname=dbName',
            'user'     => 'databaseUser',
            'password' => 'databasePassword',
        ]
    ]);
    $bot->handler()->on(ChatStartHandler::class);
} catch (Throwable $exception) {
    throw new Exception($exception->getMessage());
}

```

## Database table structure PGSQL and MySQL

```sql
create table if not exists bot_histories
(
    id                serial
        constraint bot_histories_id_pk primary key,
    chat_id           bigint                              not null,
    incoming_request  jsonb                               not null,
    request_url       text,
    telegram_response jsonb,
    created_at        timestamp default CURRENT_TIMESTAMP not null
);

comment on table bot_histories is 'all requests and responses are saved there';

comment on column bot_histories.chat_id is 'ID of Telegram User';

comment on column bot_histories.incoming_request is 'Request received from TG bot';

comment on column bot_histories.request_url is 'The method and body that we will send to TG';

comment on column bot_histories.telegram_response is 'the body of the response on the post request_url';

----------------------------------------------MYSQL---------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS bot_histories
(
    id                BIGINT AUTO_INCREMENT PRIMARY KEY,
    chat_id           BIGINT                              NOT NULL COMMENT 'ID of Telegram User',
    incoming_request  JSON                                NOT NULL COMMENT 'Request received from TG bot',
    request_url       TEXT COMMENT 'The method and body that we will send to TG',
    telegram_response JSON COMMENT 'The body of the response on the POST request_url',
    created_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
) COMMENT = 'All requests and responses are saved there';

```


## Usage without database

```php
<?php

use Shokhaa\BotLib\Bot;
use Shokhaa\BotLib\Example\ChatStartHandler;

include './vendor/autoload.php';

$requestBody = json_decode(file_get_contents('php://input'), true);
try {
    $bot = new Bot($requestBody, [
        'historyEnabled' => false,
        'token'          => 'telegram bot token',
    ]);
    $bot->handler()->on(ChatStartHandler::class);
} catch (Throwable $exception) {
    throw new Exception($exception->getMessage());
}

```


[1]: https://core.telegram.org/bots/