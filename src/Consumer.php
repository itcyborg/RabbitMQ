<?php


    namespace Finaplus\QueueManagement;


    use PhpAmqpLib\Exchange\AMQPExchangeType;

    class Consumer extends RabbitMQ
    {
        public function handle()
        {
            $this->rabbitChannel->queue_declare($this->rabbitQueue, false, true, false, false);

            $this->rabbitChannel->exchange_declare($this->exchange, AMQPExchangeType::DIRECT, false, true, false);

            $this->rabbitChannel->queue_bind($this->rabbitQueue, $this->exchange);

            echo " [*] Waiting for messages. To exit press CTRL+C\n";

            $callback = function ($message) {
                echo '[x] Received ', $message->body, "\n";
            };

            $this->rabbitChannel->basic_consume($this->rabbitQueue, $consumerTag, false, false, false, false, $callback);

            while ($this->rabbitChannel->is_consuming()) {
                $this->rabbitChannel->wait();
            }
        }


        function shutdown($channel, $connection)
        {
            $channel->close();
            $connection->close();
        }
    }