<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection;
$channel;
$callback_queue;
$response;
$corr_id;

class SignupRpcClient
{
    private $connection;
    private $channel;
    private $callback_queue;
    private $response;
    private $corr_id;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection('172.17.0.2', 5672, 'guest', 'guest');
        $this->channel = $this->connection->channel();
        $this->channel->exchange_declare('signup', 'fanout', false, false, false);
        list($this->callback_queue, ,) = $this->channel->queue_declare("", false, false, false, false);
        $this->channel->queue_bind("", 'signup');
        $this->channel->basic_consume(
            $this->callback_queue, '', false, true, false, false,
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
            (string) $n,
            array(
                'correlation_id' => $this->corr_id,
                'reply_to' => $this->callback_queue
            )
        );
        $this->channel->basic_publish($msg, 'signup', '');
        while (!$this->response) {
            $this->channel->wait();
        }
	return intval($this->response);
    }
    public function redirect($response){
        if($response==0){
	    header('Location: login.html');
	}else{
	    header('Location: error.html');
	}
    }
}

$signup_rpc = new SignupRpcClient();
$usernamepasswd = $_POST["signupUN"] . "~" . $_POST["signupPW"];
$response = $signup_rpc->call($usernamepasswd);
?>
