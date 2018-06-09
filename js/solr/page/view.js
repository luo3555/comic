// var Manager;
(function ($) {

  $(function () {
    // Manager = new AjaxSolr.Manager({
    //   solrUrl: 'http://solr.cloyi.com/solr/manga/'
    // });
    Manager.addWidget(new AjaxSolr.ViewWidget({
      id: 'result',
      target: '#docs'
    }));

    Manager.init();

    Manager.store.addByValue('q', '*:*');
    Manager.store.addByValue('fq', 'number:'+ comic.getQueryString('num'));
    Manager.store.addByValue('start', 0);
    Manager.store.addByValue('rows', 1);
    Manager.store.addByValue('fq', 'chapter:' + comic.getQueryString('chapter'));
    Manager.store.addByValue('fq', 'type:chapter');
    Manager.store.addByValue('fl', 'title,images,number');
    Manager.doRequest();
  });

})(jQuery);
