<?php

namespace App\Http\Controllers;

use App\Http\Requests\StartScraperRequest;
use App\Http\Requests\StoreQueueItemRequest;
use App\Http\Requests\StoreScraperJobRequest;
use App\Models\ScraperJob;
use App\Http\Requests\UpdateScraperJobRequest;
use App\Jobs\FinishScrapeJob;
use App\Models\Item;
use App\Repositories\QueueItemRepository;
use App\Repositories\ScraperJobRepository;
use App\Services\KubernetesService\Contracts\KubernetesService;
use App\Services\QueueService\Contracts\QueueService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
    public function __construct(ScraperJobRepository $scraperJobRepository, 
                                QueueItemRepository $queueItemRepository, 
                                QueueService $queueService,
                                KubernetesService $kubernetesService)
    {
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
        Log::info("Job ".$scrapeId." was started.");
        return $scrapeId;
    } 
    ////////middleware is pod
    public function end(Request $request)//scrape_id, pod_name
    {
        $ifAllPodsAreFinished = $this->scraperJobRepository->ifAllPodsAreFinished($request->scrape_id);
        if($ifAllPodsAreFinished){
            FinishScrapeJob::dispatch($request->scrape_id)->delay(now()->addMinutes(1)); 
            return 'Job was dispatched'.$ifAllPodsAreFinished;
        }       
        return 'ok: '.$ifAllPodsAreFinished;
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateScraperJobRequest  $request
     * @param  \App\Models\ScraperJob  $scraperJob
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateScraperJobRequest $request, ScraperJob $scraperJob)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ScraperJob  $scraperJob
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScraperJob $scraperJob)
    {
        //
    }
}
