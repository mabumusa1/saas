<?php

namespace App\Kub8;

use Http;

class Kub8ClientImpl implements Kub8Client
{
    protected $baseURL = 'https://63d4-154-128-164-74.ngrok.io/v1';

    public function create()
    {
        $response = Http::post("{$this->baseURL}/install/1");
        dd(json_decode($response->body()));
    }

    public function resize()
    {
    }

    public function destroy()
    {
    }

    public function copy()
    {
    }

    public function stop()
    {
    }

    public function backup()
    {
    }

    public function setDomain()
    {
    }
}
