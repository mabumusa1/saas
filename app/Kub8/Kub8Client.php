<?php

namespace App\Kub8;

interface Kub8Client
{
    public function create();

    public function resize();

    public function destroy();

    public function copy();

    public function Stop();

    public function backup();

    public function setDomain();
}
