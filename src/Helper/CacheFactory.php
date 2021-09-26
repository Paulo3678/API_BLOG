<?php

namespace App\Helper;

use App\Entity\Publicacao;
use Psr\Cache\CacheItemPoolInterface;

abstract class CacheFactory
{

    public static function saveCacheObject(CacheItemPoolInterface $cache, Publicacao $publicacao)
    {
        $cacheObject = $cache->getItem('publicacao_' . $publicacao->getId());
        $cacheObject->set($publicacao);
        $cache->save($cacheObject);
    }
}
