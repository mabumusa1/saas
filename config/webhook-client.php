<?php

return [
    'configs' => [
        [
            'name' => 'kub8',
            'signing_secret' => env('KUB8_WEBHOOK_CLIENT_SECRET'),
            'signature_header_name' => 'x-signature',
            'signature_validator' => \Spatie\WebhookClient\SignatureValidator\DefaultSignatureValidator::class,
            'webhook_profile' => App\Classes\Webhooks\Kub8Internal\WebhookProfile::class,
            'webhook_response' => App\Classes\Webhooks\Kub8Internal\WebhookResponse::class,
            'webhook_model' => App\Models\Webhook::class,
            'store_headers' => [
                '*',
            ],
            'process_webhook_job' => App\Jobs\Kub8WebhookJob::class,
        ],
    ],
];
