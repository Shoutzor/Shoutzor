<?php

namespace Shoutz0r\AcoustId\tests\Unit;

use Shoutz0r\AcoustId\Lib\AcoustId;
use Orchestra\Testbench\TestCase;

class TestAcoustIdCase extends TestCase
{
    private AcoustId $acoustId;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->acoustId = new AcoustId(config('shoutzor.acoustid.apikey'));
    }
}
