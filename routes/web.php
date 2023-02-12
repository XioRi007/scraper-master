<?php

// use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
// use RenokiCo\LaravelK8s\LaravelK8sFacade as K8s;
// use RenokiCo\PhpK8s\KubernetesCluster;
// use RenokiCo\PhpK8s\K8s;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
//     $redis = new \Redis();
//     $redis->connect('redis-leader', 6379);
//     $rsmq = new \Islambey\RSMQ\RSMQ($redis);
//     $rsmq->createQueue('279d82cc-08a1-47c3-ad1f-965876388bba');


// $cluster = KubernetesCluster::inClusterConfiguration();
// $container = K8s::container()
//     ->setName('scraper-job')
//     ->setImage('xiori007/scraper-worker');
// $container->setEnv([
//         'SCRAPE_ID' => '279d82cc-08a1-47c3-ad1f-965876388bba',
//     ]);

// $pod = K8s::pod()
//     ->setName('scraper-job')
//     ->setLabels(['job-name' => 'scraper-job-279d82cc-08a1-47c3-ad1f-965876388bba']) // needs job-name: pi so that ->getPods() can work
//     ->setContainers([$container])
//     ->restartOnFailure();

// $job = $cluster
//     ->job()
//     ->setName('scraper-job-279d82cc-08a1-47c3-ad1f-965876388bba')
//     ->setSpec("parallelism", 2)
//     ->setSpec("ttlSecondsAfterFinished: ", 20)
//     ->setSpec("backoffLimit: ", 3)
//     ->setTemplate($pod);

//     try{
//         $res = $job->create();
//         dd($res);
//     }catch(Exception $e){
//         dd($e);
//     }

    return view('welcome');
});
