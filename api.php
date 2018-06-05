<?php
$items = [];
////timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1527923876404&di=e6b8842d28a0d0041188c6b798c00871&imgtype=0&src=http%3A%2F%2Fimg5.duitang.com%2Fuploads%2Fitem%2F201411%2F27%2F20141127070355_tsWvH.jpeg
$g = $_GET;
$homePage = !isset($g['num']) && !isset($g['n']) && !isset($g['c']) ? true : false;
$chapterPage = isset($g['num']) == true ? true : false;
$viewPage = isset($g['n']) == false && isset($g['c']) == false ? true : false ;

$chapter = [];
if (!$homePage) {
    for ($i=0; $i<50; $i++) {
        $chapter[$i] = [
                    'title' => '为了女儿击倒魔王 Vol_1',
                    'size' => 2,
                    'chapter' => $i,
                    'number' => $i
                ];
        if (!$chapterPage) {
            $chapter[$i]['images'] = [
                        '//n5.1whour.com/newkuku/2018/03/09/为了女儿击倒魔王_第01卷/0001EPV.jpg',
                        '//n5.1whour.com/newkuku/2018/03/09/%E4%B8%BA%E4%BA%86%E5%A5%B3%E5%84%BF%E5%87%BB%E5%80%92%E9%AD%94%E7%8E%8B_%E7%AC%AC01%E5%8D%B7/0004EIW.jpg',
                        '//n5.1whour.com/newkuku/2018/03/09/为了女儿击倒魔王_第01卷/0005EFF.jpg',
                        // '//lao.qdskdz.com/uploads/allimg/170711/jpbzdxd2z0i.jpg'    
                    ];
        }
    }
}

for ($i=0; $i<100; $i++) {
    if ($homePage) {
        $items[$i] = [
            'number' => $i,
            'title' => '为了女儿击倒魔王' . uniqid(),
            'author' => 'chirolu,はた',
            'status' => '连载',
            'update' => '2018-06-03',
            'image' => '//img.1whour.com/xpic/为了女儿击倒魔王.jpg',
        ];
    } else {
        $items[$i] = [
            'number' => $i,
            'title' => '为了女儿击倒魔王' . uniqid(),
            'author' => 'chirolu,はた',
            'status' => '连载',
            'update' => '2018-06-03',
            'image' => '//img.1whour.com/xpic/为了女儿击倒魔王.jpg',
            'desc' => '以高超的战斗技巧和冷静的判断力为武器，年纪轻轻便崭露头角成为远近闻名的青年冒险者戴尔。由于委托步入了幽深的森林中，在那里，与顽强生存的年幼的魔族少女相遇了。那位背负罪人烙印的少女戴尔无法置之不理。由于种种缘分戴尔下定决心成为她的监护人—— “拉汀娜太可爱了，不想去工作。”“又犯傻啊！？” 不知不觉就变为笨蛋父亲模式全开的精明青年冒险者和魔族少女的温馨幻想物语',
            'chapter' => $chapter
        ];
    }
}

if (isset($g['num'])) {
    $items = $items[$g['num']];
    $data['item'] = $items;
} elseif(isset($g['n']) && isset($g['c'])) {
    $item = $items[$g['n']];
    // get chapter
    $data = $item['chapter'][$g['c']];
} else {
    $data = [
        'items' => $items
    ];
}



print_r(json_encode($data));