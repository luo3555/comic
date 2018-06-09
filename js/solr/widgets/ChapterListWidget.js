(function ($) {

AjaxSolr.ChapterListWidget = AjaxSolr.AbstractWidget.extend({
  afterRequest: function () {
    new Vue({
      el: '#chapter-list',
      data: this.manager.response.response
    });
  }
});

})(jQuery);