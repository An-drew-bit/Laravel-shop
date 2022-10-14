<?php

namespace App\Logging\Telegram;

use App\Jobs\TelegramLoggerJob;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class TelegramLoggerHandler extends AbstractProcessingHandler
{
    protected int $chatId;
    protected string $token;

    public function __construct(array $config)
    {
        $level = Logger::toMonologLevel($config['level']);

        parent::__construct($level);

        $this->chatId = $config['chat_id'];
        $this->token = $config['token'];
    }

    protected function write(array $record): void
    {
        dispatch(new TelegramLoggerJob($this->token, $this->chatId, $record['formatted']));
    }
}
