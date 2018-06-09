(function ($) {

AjaxSolr.IndexWidget = AjaxSolr.AbstractWidget.extend({
  afterRequest: function () {
    new Vue({
      el: '#content-list',
      data: this.manager.response.response
    });
  }
});

})(jQuery);