<?php

namespace App\Jobs;

use App\Repositories\ScraperJobRepository;
use App\Services\KubernetesService\Contracts\KubernetesService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\Queue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FinishScrapeJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    private string $scrapeId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $scrapeId)
    {
        $this->scrapeId = $scrapeId;
    }
    /**
     * The unique ID of the job.
     *
     * @return string
     */
    public function uniqueId()
    {
        return $this->scrapeId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ScraperJobRepository $scraperJobRepository, KubernetesService $kubernetesService, Queue $queueService)
    {
        if($kubernetesService->jobHasCompleted($this->scrapeId)) {
            $duration = $kubernetesService->deleteJob($this->scrapeId);
            $scraperJobRepository->update($this->scrapeId, ['duration' => $duration, 'status'=>'finished']);
            $queueService->deleteQueue($this->scrapeId);
        }
    }
}
