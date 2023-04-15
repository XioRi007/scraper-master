<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\StoreQueueItemRequest;
use App\Models\QueueItem;
use App\Repositories\Contracts\BaseRepositoryContract;

class QueueItemRepository implements BaseRepositoryContract
{
    /**
    * Creates a scraper job.
    *
    * @param  \App\Http\Requests\StoreQueueItemRequest  $request
    * @return string $_id
    */
    public function create(StoreQueueItemRequest $request)
    {
        $queue_item = [
            'scrape_id' => $request->scrape_id,
            'url' => $request->url,
            'status' => "created",
            'type' => "pagination",
            'worker' => env('HOSTNAME')
        ];
        $created_queue_item = QueueItem::create($queue_item);
        return $created_queue_item->_id;
    }

    /**
     * Specific job statistics.
     *
     * @param  string  $_id
     * @return array
     */
    public function getOne(string $_id)
    {
        return QueueItem::raw(function ($collection) use ($_id) {
            return $collection->aggregate([
                [
                    '$match' => [
                        'scrape_id' => $_id,
                    ],
                ],
                [
                    '$group' =>
                        [
                            '_id' => ['status' => '$status'],
                            'count' => ['$sum' => 1]
                        ],
                ],
                [
                    '$project' =>
                        [
                            'status' => '$_id.status',
                            'count' => 1,
                            '_id' => 0
                        ],
                ]
            ]);
        });

    }


     /**
     * Changes all tasks status to stopped.
     *
     * @param  string  $scrape_id
     * @return
     */
    public function stopAllTasks(string $scrape_id)
    {
        QueueItem::where('scrape_id', $scrape_id)
        ->whereIn('status', ['processing', 'created', 'error'])
        ->update(['status' => 'stopped']);
    }
    /**
    * Changes all tasks status to stopped.
    *
    * @param  string  $scrape_id
    * @return
    */
   public function resumeTasksAndGet(string $scrape_id)
   {
       QueueItem::where('scrape_id', $scrape_id)
       ->where('status', 'stopped')
       ->update(['status' => 'created']);

       $items = QueueItem::where('scrape_id', $scrape_id)
        ->where('status', 'created')
        ->get();
       return $items;
   }
}
