<?php


    namespace Finaplus\QueueManagement;


    use PhpAmqpLib\Exchange\AMQPExchangeType;
    use PhpAmqpLib\Message\AMQPMessage;

    class Publisher extends RabbitMQ
    {
        public function handle()
        {
            $this->rabbitChannel->queue_declare($this->rabbitQueue, false, true, false, false);

            $this->rabbitChannel->exchange_declare($this->exchange, AMQPExchangeType::DIRECT, false, true, false);

            $this->rabbitChannel->queue_bind($this->rabbitQueue, $this->exchange);

            $message = new AMQPMessage($this->message);

            $this->rabbitChannel->basic_publish($message, $this->exchange);

            echo 'Publishing Complete on queue: ' . $this->rabbitQueue . PHP_EOL;

            echo 'We are in Business!! All Publishes are Complete on queue: ' . $this->rabbitQueue . PHP_EOL;

            $this->rabbitChannel->close();

            $this->rabbitConnection->close();
        }
    }