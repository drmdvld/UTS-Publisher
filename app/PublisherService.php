<?php

namespace App;

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class PublisherService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function publishCreate($message)
    {
        $connection = new AMQPStreamConnection(env('MQ_HOST'), env('MQ_PORT'), env('MQ_USER'), env('MQ_PASS'), env('MQ_VHOST'));
        $channel = $connection->channel();
        $channel->exchange_declare('user_create', 'direct', false, false, false);
        $channel->queue_declare('user_create_queue', false, false, false, false);
        $channel->queue_bind('user_create_queue', 'user_create', 'user_create');
        $msg = new AMQPMessage($message);
        $channel->basic_publish($msg, 'user_create', 'user_create');
        echo " [x] Sent $message to user_create / user_create_queue.\n";
        $channel->close();
        $connection->close();
    }

    public function publishUpdate($message)
    {
        $connection = new AMQPStreamConnection(env('MQ_HOST'), env('MQ_PORT'), env('MQ_USER'), env('MQ_PASS'), env('MQ_VHOST'));
        $channel = $connection->channel();
        $channel->exchange_declare('user_update', 'direct', false, false, false);
        $channel->queue_declare('user_update_queue', false, false, false, false);
        $channel->queue_bind('user_update_queue', 'user_update', 'user_update');
        $msg = new AMQPMessage($message);
        $channel->basic_publish($msg, 'user_update', 'user_update');
        echo " [x] Sent $message to user_update / user_update_queue.\n";
        $channel->close();
        $connection->close();
    }

    public function publishDelete($message)
    {
        $connection = new AMQPStreamConnection(env('MQ_HOST'), env('MQ_PORT'), env('MQ_USER'), env('MQ_PASS'), env('MQ_VHOST'));
        $channel = $connection->channel();
        $channel->exchange_declare('user_delete', 'direct', false, false, false);
        $channel->queue_declare('user_delete_queue', false, false, false, false);
        $channel->queue_bind('user_delete_queue', 'user_delete', 'user_delete');
        $msg = new AMQPMessage($message);
        $channel->basic_publish($msg, 'user_delete', 'user_delete');
        echo " [x] Sent $message to user_delete / user_delete_queue.\n";
        $channel->close();
        $connection->close();
    }
}
