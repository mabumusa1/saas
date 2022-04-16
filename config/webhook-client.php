<?php

return [
    'configs' => [
        [
            'name' => 'kub8',
            'signing_secret' => env('KUB8_WEBHOOK_CLIENT_SECRET'),
            'signature_header_name' => 'x-signature',
            'signature_validator' => \Spatie\WebhookClient\SignatureValidator\DefaultSignatureValidator::class,
            'webhook_profile' =>  \Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile::class,
            'webhook_response' => \Spatie\WebhookClient\WebhookResponse\DefaultRespondsTo::class,
            'webhook_model' => \Spatie\WebhookClient\Models\WebhookCall::class,
            'store_headers' => [
                '*',
            ],
            'process_webhook_job' => App\Jobs\Kub8WebhookJob::class,
        ],
    ],
];
