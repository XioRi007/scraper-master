<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\StoreScraperJobRequest;
use App\Models\ScraperJob;
use App\Repositories\Contracts\BaseRepositoryContract;

class ScraperJobRepository implements BaseRepositoryContract
{
    /**
     * Creates a scraper job.
     *
     * @param  \App\Http\Requests\StoreScraperJobRequest  $request
     * @return string $_id
     */
    public function create(StoreScraperJobRequest $request)
    {
        $r = $request->except(['pod_count']);
        $job = [
            'start_time' => date('m/d/Y, H:i:s'),
            'params' => $r,
            'pod_count' => $request->pod_count,
            'status' => 'created'
        ];
        $created_job = ScraperJob::create($job);
        return $created_job->_id;
    }

    /**
     * All jobs.
     *
     * @return array
     */
    public function getAll()
    {
        return ScraperJob::all();
    }

    /**
     * Specific job.
     *
     * @param  string  $_id
     * @return ScraperJob
     */
    public function getOne(string $_id)
    {
        return ScraperJob::with('items')->find($_id);
    }

    /**
     * Specific job items.
     *
     * @param  string  $_id
     * @return array
     */
    public function getItems(string $_id)
    {
        return ScraperJob::find($_id)->items;//->get();
    }



    /**
     * Updates a scraper job.
     *
     * @param  string  $_id
     * @param  array  $payload
     * @return void
     */
    public function update(string $_id, array $payload)
    {
        ScraperJob::where('_id', $_id)->update($payload);
    }

    /**
     * Returns true if all pods are with 'finish' status.
     *
     * @param  string  $_id
     * @return bool
     */
    public function ifAllPodsAreFinished(string $_id)
    {
        $res = ScraperJob::where('_id', $_id)->where('pods.status', '!=', 'finished')->get();// [] - all pods are finished
        if(count($res) == 0) {
            return true;
        }
        return false;
    }
}
