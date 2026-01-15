<?php

namespace App\Service;
use Symfony\UX\Map\Map;

interface MapServiceInterface
{
    public function generateMap(): Map;
}
