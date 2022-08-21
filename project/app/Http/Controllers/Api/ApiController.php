<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Service;

class ApiController extends Controller
{
    public $service;

    public function __construct(Service $service) {
        $this->service = $service;
    }
} 
