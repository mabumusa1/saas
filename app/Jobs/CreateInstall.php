<?php

namespace App\Jobs;

use App\Models\Install;
use Http;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class CreateInstall implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Install $install;

    public function __construct(Install $install)
    {
        $this->install = $install;
    }

    /**
     * Execute the job.
     * TODO: Add custom parameters for the future.
     *
     *
     *       'custom' => [
     *          'cpu' => '1',
     *          'memory' => '4',
     *      ],
     *
     * @return void
     */
    public function handle()
    {
        $requestBody =
            [
                'id' => $this->install->name,
                'env_type' => $this->install->type,
                'size' => $this->install->size,
                'domain' => $this->install->cname,
                'region' => $this->install->region,
            ];
        try {
            $response = Http::kub8()->post('install/create', $requestBody);

            $response->onError(function ($response) use ($requestBody) {
                /* @var Response $response */
                Log::emergency(
                    'Kub8 Request Failed '.$response->getStatusCode().' : '.
                 \json_encode($response->body().' Orgianl Request: '.\json_encode($requestBody))
                );
            });
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());
        }
    }
}
