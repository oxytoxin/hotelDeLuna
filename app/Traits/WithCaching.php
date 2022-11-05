<?php

namespace App\Traits;

trait WithCaching
{
    protected $useCache = false;

    public function useCacheRows()
    {
        $this->useCache = true;
    }

    public function cache($callback,$extra_key=null)
    {
        $cacheKey = $extra_key ? $this->id . $extra_key : $this->id;
        if ($this->useCache && cache()->has($cacheKey)) {
            return cache()->get($cacheKey);
        }

        $result = $callback();

        cache()->put($cacheKey, $result);

        return $result;
    }
}
