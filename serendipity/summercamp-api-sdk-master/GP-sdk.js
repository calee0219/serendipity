(function(w, $){
  var GP = function($) {
    this.hello = "Welcome to SITCON Summer Camp!"
    var food = "http://lab.dennyhuang.me/GPfood.php?latlng="
    this.getFoods = function(latlng, callback) {
      $.ajax({
        url: food + latlng,
        success: function (res){
          callback && callback(res)
        }
      })
    }

    var info = "http://lab.dennyhuang.me/GPinfo.php?id="
    this.getInfo = function(id, callback) {
      $.ajax({
        url: info + id,
        success: function (res){
          callback && callback(res)
        }
      })
    }
  }
  w.GP = new GP($)
})(window, window.jQuery);
