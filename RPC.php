<?php
namespace rabbit;

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RPC
{
	private $channel;
	private $callback_queue;
	private $response;
	private $corr_id;
	private $exchange;

	public function __construct($exchange)
	{
		require_once 'configs/rabbitServer.php';
		require_once 'configs/authCredentials.php';
		$this->exchange = $exchange;

		$connection = new AMQPStreamConnection(
			$rabbit_host,
			$rabbit_port,
			$rabbit_user,
			$rabbit_pass,
			$rabbit_vhost
		);

		$this->channel = $connection->channel();
		$this->channel->exchange_declare($exchange, 'direct', false, false, false);
		list($this->callback_queue,, ) = $this->channel->queue_declare('', false, false, true, false);
		$this->channel->queue_bind($queue_name, $exchange, $exchange . '_req');
		$this->channel->basic_consume(
			$this->callback_queue,
			'',
			false,
			true,
			false,
			false,
			array($this, 'onResponse')
		);
	}

	public function onResponse($rep)
	{
		if ($rep->get('correlation_id') == $this->corr_id) {
			$this->response = $rep->body;
		}
	}

	public function call($n)
	{
		$this->response = null;
		$this->corr_id = uniqid();

		$msg = new AMQPMessage(
			$n,
			array(
				'correlation_id' => $this->corr_id,
				'reply_to' => $this->callback_queue
			)
		);

		$this->channel->basic_publish($msg, $this->exchange, '');
		while (!$this->response) {
			$this->channel->wait();
		}

		return $this->response;
	}
}
