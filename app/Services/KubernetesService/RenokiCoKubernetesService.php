<?php

namespace App\Services\KubernetesService;

use App\Repositories\ScraperJobRepository;
use App\Services\KubernetesService\Contracts\KubernetesService;
// use RenokiCo\LaravelK8s\LaravelK8sFacade as K8s;
use RenokiCo\PhpK8s\KubernetesCluster;
use RenokiCo\PhpK8s\K8s;

class RenokiCoKubernetesService implements KubernetesService
{
    private KubernetesCluster $cluster;
    /**
     * Create a new class instance.
     *
     * @return void
     */
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////заменить на типа скраперджобсервис єто все
    public function __construct()
    {
        $this->cluster = KubernetesCluster::inClusterConfiguration();
    }
    public function generateName(string $scrapeId){
        return "scraper-job-{$scrapeId}";
    }

    public function createJob($scrapeId, $podCount){
        $jobName = $this->generateName($scrapeId);
        $container = K8s::container()
            ->setName('scraper-job')
            ->setImage('xiori007/scraper-worker')
            ->setEnv([
                'SCRAPE_ID' => $scrapeId,
            ]);

        $pod = K8s::pod()
            ->setName('scraper-job')
            ->setLabels(['job-name' => $jobName]) // needs job-name: pi so that ->getPods() can work
            ->setContainers([$container])
            ->restartOnFailure();

        $job = $this->cluster
            ->job()
            ->setName($jobName)
            ->setSpec("parallelism", $podCount)
            ->setSpec("ttlSecondsAfterFinished: ", 20)
            ->setSpec("backoffLimit: ", 3)
            ->setSpec("activeDeadlineSeconds: ", 20)
            ->setTemplate($pod);
        $job->create();
    }
    public function jobHasCompleted($scrapeId)
    {
        $job = $this->cluster->getJobByName($this->generateName($scrapeId));
        return $job->hasCompleted();
    }
    public function deleteJob($scrapeId)
    {
        $job = $this->cluster->getJobByName($this->generateName($scrapeId));
        $duration = $job->getDurationInSeconds();
        foreach ($job->getPods() as $pod) {
            // $pod->logs()
            $pod->delete();
        }
        $job->delete();
        return $duration;
    }

}
