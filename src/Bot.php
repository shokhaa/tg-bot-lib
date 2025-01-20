<?php

namespace Shokhaa\BotLib;


use Shokhaa\BotLib\Handler\RequestHandler;
use Shokhaa\BotLib\Query\Connection;

class Bot
{
    protected string $apiUrl = 'https://api.telegram.org/bot';

    public ?int $chatId = null;

    public ?string $messageId = null;

    public array $dbUser = [];

    private ?Connection $connection = null;

    public function __construct(protected array $request, private array $config)
    {
        if ($this->config['historyEnabled'] === true) {
            $this->connection = new Connection($this->config['db']);
        }
    }

    public function handler(): RequestHandler
    {
        if (isset($this->request['message'])) {
            $this->messageId = $this->request['message']['message_id'];
            $this->chatId = $this->request['message']['chat']['id'];
        }

        if (isset($this->request['callback_query'])) {
            $this->messageId = $this->request['callback_query']['id'];
            $this->chatId = $this->request['callback_query']['from']['id'];
        }
        return new RequestHandler($this, $this->request);
    }

    public function send(string $method, array $data): string|false
    {
        if (!isset($data['chat_id'])) {
            $data['chat_id'] = $this->chatId;
        }

        $requestUrl = $this->apiUrl . $this->config['token'] . "/$method?" . http_build_query($data);
        $response = file_get_contents($requestUrl);

        if ($this->connection !== null) {
            $this->connection->insert($this->chatId, $this->request, $requestUrl, $response);
        }

        return $response;
    }

    public function setWebhook(): void
    {
        $this->send('setWebhook', [
            'url'                  => 'https://' . $_SERVER['HTTP_HOST'],
            'drop_pending_updates' => true,
        ]);
    }

    public function getConnection(): ?Connection
    {
        return $this->connection;
    }
}