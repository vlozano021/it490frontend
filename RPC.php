<?php
namespace rabbit;

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RPC
{
	private $channel;
	private $response_queue;
	private $response;
	private $corr_id;
	private $exchange;

	public function __construct($flow)
	{

		switch($flow) {
			case 'login':
				$this->exchange = 'LoginExchange';
				$vhost = 'authentication';
				$user = 'auth_user';
				break;
			case 'register':
				$this->exchange = 'RegisterExchange';
				$vhost = 'authentication';
				$user = 'auth_user';
				break;
			case 'getPosts':
				$this->exchange = 'GetPostsExchange';
				$vhost = 'messageBoard';
				$user = 'forums_user';
				break;
			case 'createPosts':
				$this->exchange = 'CreatePostsExchange';
				$vhost = 'messageBoard';
				$user = 'forums_user';
				break;
			case 'storeCharacter':
				$this->exchange = 'StoreExchange';
				$vhost = 'storage';
				$user = 'storage_user';
				break;
			case 'storeUserData':
				$this->exchange = 'RetrievalExchange';
				$vhost = 'storage';
				$user = 'storage_user';
				break;
		}

		$connection = new AMQPStreamConnection(
			'', //host
			5672, // port
			$user, // username
			'pass', // password
			$vhost, //vhost
		);

		$this->channel = $connection->channel();
		$this->channel->exchange_declare($this->exchange, 'direct', false, false, false);
		list($this->response_queue,, ) = $this->channel->queue_declare('', false, true, false, false);
		$this->channel->queue_bind($this->response_queue, $this->exchange, $this->exchange . '_req');
		$this->channel->basic_consume(
			$this->response_queue,
			'',
			false,
			true,
			false,
			false,
			array($this, 'onResponse')
		);
	}

	public function onResponse($resp)
	{
		if ($resp->get('correlation_id') == $this->corr_id) {
			$this->response = $resp->body;
		}
	}

	public function call($serialized_data)
	{
		$this->response = null;
		$this->corr_id = uniqid();

		$msg = new AMQPMessage(
			$serialized_data,
			array(
				'correlation_id' => $this->corr_id,
				'reply_to' => $this->response_queue
			)
		);

		$this->channel->basic_publish($msg, $this->exchange, $this->exchange . '_req');
		while (!$this->response) {
			$this->channel->wait();
		}

		return $this->response;
	}
}
?>
