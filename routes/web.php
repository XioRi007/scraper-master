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

Route::get('/{any}', function () {
    return view('welcome');
    })->where("any",".*");
