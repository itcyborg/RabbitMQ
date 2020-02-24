<?php


    namespace Finaplus\QueueManagement;


    use PhpAmqpLib\Connection\AMQPStreamConnection;

    class RabbitMQ
    {
        /**
         * @var string
         */
        private $vhost;
        /**
         * @var string
         */
        public $exchange;
        public $rabbitConnection;
        public $message;
        /**
         * @var string
         */
        private $rabbitHost;
        /**
         * @var int
         */
        private $rabbitPort;
        /**
         * @var string
         */
        private $rabbitUser;
        /**
         * @var string
         */
        public $rabbitQueue;
        /**
         * @var \PhpAmqpLib\Channel\AMQPChannel
         */
        public $rabbitChannel;

        /**
         * Create a new job instance.
         *
         * @return void
         */
        public function __construct($message)
        {
            $this->message = json_encode($message);
            $this->rabbitHost = env('RABBITMQ_HOST');
            $this->rabbitPort = env('RABBITMQ_PORT');
            $this->rabbitUser = env('RABBITMQ_USER');
            $this->rabbitPass = env('RABBITMQ_PASS');
            $this->vhost = env('RABBITMQ_VHOST');
            $this->exchange = env('RABBITMQ_EXCHANGE');

            $this->rabbitQueue = env('RABBITMQ_QUEUE');

            $this->rabbitConnection = new AMQPStreamConnection($this->rabbitHost, $this->rabbitPort, $this->rabbitUser, $this->rabbitPass, $this->vhost);

            $this->rabbitChannel = $this->rabbitConnection->channel();

        }
    }