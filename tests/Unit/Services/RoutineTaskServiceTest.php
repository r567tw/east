<?php

namespace Tests\Unit\Services;

use App\Services\RoutineTaskService;
use PHPUnit\Framework\TestCase;

class RoutineTaskServiceTest extends TestCase
{
    public function test_service_instantiable()
    {
        $service = new RoutineTaskService;
        $this->assertInstanceOf(RoutineTaskService::class, $service);
    }
}
