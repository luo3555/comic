<?php
require '../vendor/autoload.php';
require '../config.php';

use Lib\Template;
use Lib\Search;

/**
 * 获取要创建的额章节
 */
$search = new Lib\Search();
// 1. 获取要创建的 article
// 2. 获取 article 下的章节
$search->setFields(['id', 'title', 'author', 'description', 'number', 'images']);
$search->setFilter('type', 'article');
$search->execute();
$articles = $search->getResponse();
$search->unsetData();
$articles  = $search->getResponse('docs');

foreach ($articles as $article) {
    // create dir
//    echo sprintf('%s/content/%s', ROOT_DIR, $article['number']);
    $dir = sprintf('%s/content/%s', ROOT_DIR, $article['number']);
    if (!file_exists($dir)&&!is_dir($dir)) {
        mkdir(sprintf('%s/content/%s', ROOT_DIR, $article['number']));
    }

    /**
     * 创建章节文件
     */
    $layout = [];
    $tpl = new Lib\Template();

// 1. set head
    $tpl->setFile('common/head.html');
    $tpl->setVar(['title' => $article['title'], 'baseUrl' => BASE_URL]);
    $layout['head'] = $tpl->render();
    $tpl->reset();

// 2. header, logo and so on....
    $tpl->setFile('common/header.html');
    $tpl->setVar(['web_title' => WEB_TITLE]);
    $layout['header'] = $tpl->render();
    $tpl->reset();

// 3. menu
    $tpl->setFile('common/menu.html');
// @TODO
    $tpl->setVar(['nav' => 'jsonData']);
    $layout['menu'] = $tpl->render();
    $tpl->reset();

// 4. content
    $tpl->setFile('chapter/content.html');
    $layout['content'] = $tpl->render();
    $tpl->reset();

// 5. addition
    $tpl->setFile('common/addition.html');
    $layout['addition'] = $tpl->render();
    $tpl->reset();

// 6. init script
// get init data
    $search->setFields(['id', 'title', 'number', 'chapter', 'images']);
    $search->setFilter('type', 'article');
    $search->setFilter('number', $article['number']);
    $search->execute();

    $tpl->setFile('chapter/page-init-script.html');
    $tpl->setVar(['info' => json_encode($article), 'list' => json_encode($search->getResponse())]);
    $layout['page-init-script'] = $tpl->render();
    $tpl->reset();

    $tpl->setFile('layout.html');
    $tpl->setVar($layout);
    $tpl->renderTo(sprintf('%s/content/%s/index.html', ROOT_DIR, $article['number']));
}