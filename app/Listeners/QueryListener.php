<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;


class QueryListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
        $sql = str_replace("?", "'%s'", $event->sql);

        $log = vsprintf($sql, $event->bindings). ' | 耗费时间(ms):' .  $event->time;

        // Log::useDailyFiles(storage_path().'/logs/sql/sql.log');
        // Log::info($log);
        Log::channel('sql')->info($log);
        Log::info($log);
        // \Illuminate\Support\Facades\Log::channel('sql')->info($log);
    }
}
