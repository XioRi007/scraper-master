<?php
namespace App\Services\QueueService;

use App\Services\QueueService\Contracts\QueueService;
use Exception;
use \Islambey\RSMQ\RSMQ;

class RedisQueueService implements QueueService
{
    private RSMQ $rsmq;
    private string $name;
    public function __construct()
    {
        $redis = new \Redis();
        $redis->connect('redis-leader', 6379);
        $this->rsmq = new \Islambey\RSMQ\RSMQ($redis);
    }
    public function setName(string $name){
        $this->name = $name;
    }
    public function createQueue(string $name){        
        $this->rsmq->createQueue($name);
        $this->name = $name;
    }
    public function sendMessage(string $msg){
        $this->rsmq->sendMessage($this->name, $msg);
    }
    public function deleteQueue(string $name){
        $this->rsmq->deleteQueue($name);
    }    
}
