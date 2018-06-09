(function ($) {

AjaxSolr.ChapterInfoWidget = AjaxSolr.AbstractWidget.extend({
  afterRequest: function () {
    new Vue({
      el: '#chapter-desc',
      data: this.manager.response.response
    });
  }
});

})(jQuery);