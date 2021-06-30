<?php

namespace App\HealthCheck;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Cache;
use JetBrains\PhpStorm\Pure;

class CacheHealthCheck extends BaseHealthCheck
{

    private string $store;

    #[Pure]
    public function __construct()
    {
        $this->store = config('cache.default');

        parent::__construct(
            'Cache Store',
            'Checks if the cache store functions correctly',
            "Cache store '$this->store' functions correctly"
        );
    }

    public function checkHealth(): void
    {
        try {
            $cache = Cache::store($this->store);
            $cache->put('shoutzor-cache-health-check', 'healthy', Carbon::now()->addSeconds(10));

            $value = $cache->pull('shoutzor-cache-health-check', 'broken');

            if ($value != 'healthy') {
                $this->isHealthy = false;
                $this->status = "Store '$this->store' is not healthy";
                return;
            }

            $cache->delete('shoutzor-cache-health-check');
            $this->isHealthy = true;
        } catch (Exception $e) {
            $this->isHealthy = false;
            $this->status = "Error with Store '$this->store': ".$e->getMessage();
        }
    }

    public function fix(): HealthCheckFixResult
    {
        $result = new HealthCheckFixResult();

        $result->setFixed(false);
        $result->setMessage("Unable to automatically fix the cache store. Manual fix required.");

        return $result;
    }
}