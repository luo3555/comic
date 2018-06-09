// var Manager;

(function ($) {

  $(function () {
    // Manager = new AjaxSolr.Manager({
    //   solrUrl: 'http://solr.cloyi.com/solr/manga/'
    // });
    Manager.addWidget(new AjaxSolr.ChapterInfoWidget({
      id: 'result',
      target: '#docs'
    }));

    Manager.init();
    var offset = 0;
    var limit = 1;
    Manager.store.addByValue('q', '*:*');
    Manager.store.addByValue('start', offset);
    Manager.store.addByValue('rows', limit);
    Manager.store.addByValue('fq', 'number:' + comic.getQueryString('num') + '');
    Manager.store.addByValue('fq', 'type:article');
    Manager.store.addByValue('fl', 'id,title,author,description,images');
    Manager.doRequest();
    
  });

})(jQuery);
