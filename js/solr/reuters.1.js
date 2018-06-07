var Manager;

(function ($) {

  $(function () {
    Manager = new AjaxSolr.Manager({
      solrUrl: 'http://solr.cloyi.com/solr/manga/'
    });
    Manager.init();
    // Manager.store.addByValue('q', '*:*');
    // Manager.doRequest();
  });

})(jQuery);
