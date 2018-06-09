var Manager;

(function ($) {
  $(function () {
    Manager = new AjaxSolr.Manager({
      solrUrl: 'http://solr.cloyi.com/solr/manga/'
    });
  });
})(jQuery);

var comic = {
    options: {},
    cache:{},
    setOption: function(key, value)
    {
        this.options.key = value;
    },
    index: function(data) {
        this.options = {
                          el: '#content-list',
                          data: data
                        };
        return this;
    },
    chapterPage: function(id, data)
    {
        console.log(data);
        this.options = {
            el: id,
            data: data
        };
        return this;
    },
    viewPage: function(data)
    {
        this.options = {
            el: '#content',
            data: data
        };
        return this;
    },
    run()
    {
        console.log('run');
        new Vue(this.options);
    },
    /*************************************************************************************************/
    viewPageRun: function()
    {
      this.cache.chapter = {};
      //this.cache.chapter = this.getCacheJson(location.search);
      self = this;
      
    var url = '/api.php';
    jQuery.getJSON('/api.php' + location.search, function(responseData) {
        console.log(location.search);
        console.log(responseData);
        json = responseData;
        self.cache.chapter = json;
        //comic.cacheSet(comic.cacheKey(location.search), json);
        comic.viewModifyPage(0);
        comic.imgLoadCheck(jQuery('.img-container img'));
    });
      

      
      this.viewNext();
      this.viewPrev();
      
      // while (!this.cache.chapter) {
      //   try {
      //       this.viewModifyPage(0);
      //       this.imgLoadCheck(jQuery('.img-container img'));
      //       return false;
      //   } catch (e) {
      //       console.log(0);
      //   }
      // }
      
    },
    /*************************************************************************************************/
    getQueryString(name)  
    {  
         var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");  
         var r = window.location.search.substr(1).match(reg);//search,查询？后面的参数，并匹配正则  
         if(r!=null)return  unescape(r[2]); return null;  
    },
    /*************************************************************************************************/
    getCacheJson: function(key)
    {
        
        var json = {};
        // 获取缓存列表
        var cacheList = null;
        cacheList = this.cacheGet(this.cacheKey('cache-list'));
        if (cacheList==null) {
            cacheList = new Array();
            cacheList.push(this.cacheKey(key));
            comic.cacheSet(this.cacheKey('cache-list'), cacheList);
        }
        json = this.cacheGet(key);
        // console.log(json);
        return json;
    },
    cacheKey(key)
    {
        return 'comic-' + key;
    },
    cacheGet: function(key)
    {
        return JSON.parse(localStorage.getItem(this.cacheKey(key)));
        // return localStorage.getItem(key);
    },
    cacheSet: function(key, value)
    {
        localStorage.setItem(this.cacheKey(key), JSON.stringify(value));
        //localStorage.setItem(key, value);
    },
    /*************************************************************************************************/
    imgLoadCheck: function($image)
    {
          var timer = setInterval(function() {
            console.log('check image load finish');
            if ($image[0].complete) {
              comic.hideLoading(true);
              $image.fadeIn();
              clearInterval(timer);
            } else {
              comic.hideLoading(false);
            }
          }, 100);
    },
    hideLoading: function(mode)
    {
        if (mode) {
            jQuery('.sk-circle').fadeOut();
        } else {
            jQuery('.sk-circle').fadeIn();
        }
    },
    /*************************************************************************************************/
    viewPrev: function()
    {
      var self = this;
      jQuery('#prev').click(function(){
        var idx = Math.abs(jQuery(this).data('page') - 1);
        idx = idx < 0 ? 0 : idx;
        console.log(idx);
        jQuery('.img-container img').attr('src', self.cache.chapter.images[idx]);
        if (idx>0) {
          jQuery('.img-container img').fadeOut();
        }
        jQuery(this).data('page', idx);
        console.log(self.cache.chapter.images[idx]);
        comic.imgLoadCheck(jQuery('.img-container img'));
      });
    },
    viewNext: function()
    {
        var self = this;
        jQuery('#next').on('click', function(){
            var idx = Math.abs(jQuery(this).data('page') + 1);
            // console.log(self);
            if (idx > self.cache.chapter.size) {
              window.location.href='/chapter.html?num=' + self.cache.chapter.number;
            }

            console.log(idx);
            // jQuery('.img-container img').attr('src', chapter.images[idx]).fadeOut();
            comic.viewModifyPage(idx, self.cache.chapter);
            jQuery(this).data('page', idx);
            comic.imgLoadCheck(jQuery('.img-container img'));
          });
    },
    viewModifyPage(page)
    {
        console.log(this.cache.chapter);
        jQuery('.img-container img').attr('src', this.cache.chapter.images[page]).fadeOut();
        console.log(this.cache.chapter.images[page]);
    }
};

