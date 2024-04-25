<?php

namespace Tests;

use App\Traits\MakesJsonApiRequests;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use MakesJsonApiRequests;
}
