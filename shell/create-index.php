<?php
require '../vendor/autoload.php';
require '../config.php';

use Lib\Template;
use Lib\Search;

/**
 * 创建首页静态文件
 */
$layout = [];
$tpl = new Lib\Template();

// 1. set head
$tpl->setFile('index/head.html');
$tpl->setVar(['title' => 'Cloyi Comic', 'baseUrl' => BASE_URL]);
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
$tpl->setFile('index/content.html');
$layout['content'] = $tpl->render();
$tpl->reset();

// 5. addition
$tpl->setFile('common/addition.html');
$layout['addition'] = $tpl->render();
$tpl->reset();

// 6. init script
// get init data
$search = new Lib\Search();
//$search->setFields(['id', 'title', 'number', 'images']);
$search->setFilter('type', 'article');
$search->execute();

$tpl->setFile('index/page-init-script.html');
$tpl->setVar(['initData' => json_encode($search->getResponse())]);
$layout['page-init-script'] = $tpl->render();
$tpl->reset();

$tpl->setFile('layout.html');
$tpl->setVar($layout);
$tpl->renderTo('../index.html');
