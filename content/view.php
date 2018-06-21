<?php
require '../vendor/autoload.php';
require '../config.php';

use Phpfastcache\CacheManager;
use Phpfastcache\Config\ConfigurationOption;
use Lib\Template;
use Lib\Search;


/**
 * 1. 抓取数据缓存
 * 2.
 */
$chapterData = null;
$expireTime = '';
$get = new Lib\Object($_GET);

/********************************************************************************
 * Cache System
 ********************************************************************************/
// Setup File Path on your config files
// Please note that as of the V6.1 the "path" config
// can also be used for Unix sockets (Redis, Memcache, etc)
CacheManager::setDefaultConfig(new ConfigurationOption([
    'path' => CACHE_DIR,
]));

// In your class, function, you can call the Cache
$InstanceCache = CacheManager::getInstance(CACHE_TYPE);

/**
 * Try to get $products from Caching First
 * product_page is "identity keyword";
 */
$key = sprintf('%s-%s', $get->getN(), $get->getC());
$CachedString = $InstanceCache->getItem($key);

if (!$CachedString->isHit()) {
    // get chapter data
    $search = new Lib\Search();
    $search->setFields(['id', 'title', 'number', 'chapter', 'images']);
    $search->setFilter('type', 'chapter');
    $search->setFilter('number', $get->getN());
    $search->setFilter('chapter', $get->getC());
    $search->execute();
    $chapterData = $search->getResponse('docs');
    $chapterData = array_shift($chapterData);
    $chapterData['total'] = count($chapterData['images']);

    $CachedString->set($chapterData);//->expiresAfter($expireTime);//in seconds, also accepts Datetime
    $InstanceCache->save($CachedString); // Save the cache item just like you do with doctrine and entities
} else {
    $chapterData = $CachedString->get();// Will print 'First product'
}
/********************************************************************************
 * render page
 ********************************************************************************/
$page = $get->getDataSetDefault('p', 1);
$n = $get->getN();
$c = $get->getC();

$prev = ($page - 1) > 0 ? $page - 1 : 1 ;
$next = $page + 1 ;

$buttonHref = '/content/view.php?n=%d&c=%d&p=%d';

$image = $chapterData['images'][$page-1];

$tpl = new Template();
$tpl->setFile('view/view.html');
$data = [
    'baseUrl' => BASE_URL,
    'title' => $chapterData['title'],
    'chapter' => $c,
    'number' => $chapterData['number'],
    'prev' => sprintf($buttonHref, $n, $c, $prev),
    'page' => $page,
    'next' => $next > $chapterData['total'] ? '/content/' . $n : sprintf($buttonHref, $n, $c, $next),
    'total' => $chapterData['total'],
    'image' => $image
];
$tpl->setVar($data);
echo $tpl->render();