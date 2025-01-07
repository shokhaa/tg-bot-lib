<?php


namespace Shokhaa\BotLib\Query;

use PDO;
use PDOException;

class Connection
{
    private PDO $pdo;

    public function __construct(?array $config = [])
    {
        try {
            $this->pdo = new PDO($config['dsn'], $config['user'], $config['password']);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function insert(int $chat_id, array $incomingRequest, ?string $requestUrl = null, ?string $telegramResponse = null): int
    {
        $chat_id = (int)filter_var($chat_id, FILTER_SANITIZE_NUMBER_INT);
        if ($chat_id > 1) {
            $sql = "INSERT INTO bot_histories (chat_id, incoming_request, request_url, telegram_response) VALUES (:chat_id, :incoming_request, :request_url, :telegram_response)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':chat_id', $chat_id);
            $stmt->bindValue(':incoming_request', json_encode($incomingRequest));
            $stmt->bindValue(':request_url', $requestUrl);
            $stmt->bindValue(':telegram_response', $telegramResponse);

            $stmt->execute();
            return $this->pdo->lastInsertId();
        }
        return 0;
    }

    public function getLastHistory(int $chat_id): mixed
    {
        $sql = "SELECT * FROM bot_histories WHERE chat_id = :chat_id ORDER BY id DESC LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':chat_id', $chat_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}