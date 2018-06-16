<?php

// http://solr-app-solr.193b.starter-ca-central-1.openshiftapps.com/solr/nice2_index/select?q=*:*
header('Content-Type:application/json');
header('Accept-Encoding:gzip');

function get($key, $default='')
{
    if (isset($_GET[$key])) {
        return $_GET[$key];
    }
    return $default;
}

function debug($string, $mod=false)
{
    $enable = false;
    if ($enable) {
        if ($mod) {
            var_dump($string);
        } else {
            print_r($string);
        }
        echo '<br/>';
    }
}

$solrUrl = 'http://openshift-solr-solr.193b.starter-ca-central-1.openshiftapps.com/solr/nice2_index/select?';
$pageSize = 30;
$homePage = get('home');
$chapter = get('chapter');
$view = get('view');
$page = get('page', 0);
$condition = '';

if ($homePage) {
    $condition = sprintf('q=*:*&rows=%d&start=%d&fq=type:article&fl=id&fl=title&fl=images&fl=number', $pageSize, $page);
}

if ($chapter) {
    $number = get('num');
    $list = get('list');

    if ($list) {
        $condition = sprintf('q=*:*&fl=id&fl=title&fl=number&fl=chapter&fq=type:chapter&fq=number:%d', $number);
    } else {
        $condition = sprintf('q=*:*&rows=1&start=1&fl=id&fl=title&fl=images&fl=number&fl=author&fl=description&fq=type:article&fq=number:%d', $number);
    }
}

if ($view) {
    $number = get('num');
    $chapter = get('chapter_num');
    $condition = sprintf('q=*:*&fl=id&fl=title&fl=number&fl=chapter&fl=images&fq=type:chapter&fq=number:%d&fq=chapter:%d', $number, $chapter);
}

//debug($condition);

$requestUrl = $solrUrl . $condition;
$response = '';

debug($requestUrl);


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $requestUrl);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
$status = curl_getinfo($ch);
curl_close($ch);

$data = [
    'code' => 200,
    'docs' => [],
];
$httpCode = $status['http_code'];
if ($httpCode!=200) {
    header("HTTP/1.1 403 Error!");
    $data['code'] = 403;
    echo json_encode($data);
    exit;
}

$json = json_decode($response, true);
debug($json);
if ($json['responseHeader']['status']==0) {
    if ($json['response']['numFound']) {
        $data['docs'] = $json['response']['docs'];
    }
}

echo json_encode($data);

//print_r($status);
//print_r($json);
//echo json_encode($_REQUEST);

