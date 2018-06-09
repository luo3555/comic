(function ($) {

AjaxSolr.ViewWidget = AjaxSolr.AbstractWidget.extend({
  afterRequest: function () {
    docs = this.manager.response.response.docs;
    chapter = docs[0];
    // currentImg = images[0];
    // console.log(images);
    // console.log(currentImg);
    new Vue({
      el: '#main-image',
      data: {
        number: chapter.number,
        title: chapter.title,
        total: chapter.images.length,
        images: chapter.images,
        image: chapter.images[0],
        idx: 0,
        display: false
      },
      mounted: function()
      {
        var self  = this;
        var timer = setInterval(function() {
            if (self.$refs.loadImage.complete) {
                self.display = true;
            } else {
              self.display = false;
            }
          }, 100);
      },
      methods: {
        prev: function()
        {
            this.display = false;
            this.idx = this.idx - 1;
            if (this.idx<0) {
                this.idx = 0;   
            }
            this.image = this.images[this.idx];
        },
        next: function()
        {
            this.display = false;
            this.idx = this.idx + 1;
            if (this.idx>(this.total-1)) {
                // this.idx = (this.total-1);
                window.location.href='/chapter.html?num=' + this.number;
            }
            this.image = this.images[this.idx];

        }
      }
    });
  }
});

})(jQuery);