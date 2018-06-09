// var Chapter;

(function ($) {

  $(function () {
    Chapter = Manager;
    // Chapter = new AjaxSolr.Manager({
    //   solrUrl: 'http://solr.cloyi.com/solr/manga/'
    // });
    Chapter.addWidget(new AjaxSolr.ChapterListWidget({
      id: 'result',
      target: '#docs'
    }));

    Chapter.init();
    Chapter.store.addByValue('q', '*:*');
    Chapter.store.addByValue('fq', 'number:' + comic.getQueryString('num'));
    Chapter.store.addByValue('fq', 'type:chapter');
    Chapter.store.addByValue('fl', 'id,title,number,chapter');
    Chapter.doRequest();
  });

})(jQuery);
