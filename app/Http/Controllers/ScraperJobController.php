<?php

namespace App\Http\Controllers;

use App\Http\Requests\StartScraperRequest;
use App\Http\Requests\StoreQueueItemRequest;
use App\Http\Requests\StoreScraperJobRequest;
use App\Jobs\FinishScrapeJob;
use App\Repositories\QueueItemRepository;
use App\Repositories\ScraperJobRepository;
use App\Services\KubernetesService\Contracts\KubernetesService;
use App\Services\QueueService\Contracts\QueueService;
use Illuminate\Http\Request;

class ScraperJobController extends Controller
{
    private ScraperJobRepository $scraperJobRepository;
    private QueueItemRepository $queueItemRepository;
    private QueueService $queueService;
    private KubernetesService $kubernetesService;
    /**
     * Create a new class instance.
     *
     * @param  App\Repositories\ScraperJobRepository  $scraperJobRepository
     * @param  App\Repositories\QueueItemRepository $queueItemRepository
     * @param  App\Services\QueueService\Contracts\QueueService $queueService
     * @param  App\Services\KubernetesService\Contracts\KubernetesService $kubernetesService
     * @return void
     */
    public function __construct(
        ScraperJobRepository $scraperJobRepository,
        QueueItemRepository $queueItemRepository,
        QueueService $queueService,
        KubernetesService $kubernetesService
    ) {
        $this->scraperJobRepository = $scraperJobRepository;
        $this->queueItemRepository = $queueItemRepository;
        $this->queueService = $queueService;
        $this->kubernetesService = $kubernetesService;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->scraperJobRepository->getAll();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreScraperJobRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StartScraperRequest $request)
    {
        $scrapeId = $this->scraperJobRepository->create(new StoreScraperJobRequest($request->except(['url'])));
        $queue_item_id = $this->queueItemRepository->create(new StoreQueueItemRequest(array_merge($request->only('url'), ['scrape_id'=>$scrapeId])));
        $this->queueService->createQueue($scrapeId);
        $this->queueService->sendMessage($queue_item_id);
        $this->kubernetesService->createJob($scrapeId, $request->pod_count);
        return $scrapeId;
    }
    public function end(Request $request)
    {
        FinishScrapeJob::dispatch($request->scrape_id)->delay(now()->addMinutes(1));
    }

    public function stop(Request $request)
    {
        $duration = $this->kubernetesService->stopJobAndDelete($request->scrapeId);
        $this->scraperJobRepository->update($request->scrapeId, ['duration' => $duration, 'status'=>'stopped']);
        $this->queueService->deleteQueue($request->scrapeId);
        $this->queueItemRepository->stopAllTasks($request->scrapeId);
        return 'Stopped';
    }

    public function resume(Request $request)
    {
        $resumedTasks = $this->queueItemRepository->resumeTasksAndGet($request->scrapeId);
        $this->queueService->createQueue($request->scrapeId);
        $this->scraperJobRepository->update($request->scrapeId, ['status'=>'resumed']);
        foreach ($resumedTasks as $task) {
            $this->queueService->sendMessage($task->id);
        }
        $this->kubernetesService->createJob($request->scrapeId, $request->pod_count);
        return 'Resumed';
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $_id
     * @return \Illuminate\Http\Response
     */
    public function show(string $_id)
    {
        return [$this->scraperJobRepository->getOne($_id), $this->queueItemRepository->getOne($_id)];
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $_id
     * @return \Illuminate\Http\Response
     */
    public function items(string $_id)
    {
        return $this->scraperJobRepository->getItems($_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $_id
     * @return \Illuminate\Http\Response
     */
    public function stats(string $_id)
    {
        return $this->queueItemRepository->getOne($_id);
    }
}
