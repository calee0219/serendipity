(function(w, $, f){
  var facebook = function($, f) {
    this.hello = "Welcome to SITCON Summer Camp!"
    var accessToken = "CAACWMFh6DXgBAHguwIHB3EAmVO1QgYaA3q0llZBqfe0t0DEAcwWTTbTUdF4DzaWPlRHhIXQaY8zpmVXjWDIKVortTbjYwsFSOXOHI72rfs9YyzvdPnT5xmhFBK3waqix1gtO3jxmR6UbNiX6rqFRUVIForGvWdbwOntAOO0Gp90wvZCvUi5rPPGyrPkFeynsZAb0F7Nki5LoUHakEEJ"
    var fansPage = f
    var basicInfo = {}
    this.getAccessToken = function() {
      return accessToken
    }
    this.getImgUrlById = function(id) {
      return "https://graph.facebook.com/"+id+"/picture"
    }
    this.api = function(path, callback) {
      $.get("https://graph.facebook.com/"+path+"?access_token="+accessToken, function (data){
        callback && callback(data)
      })
    }
    this.getPosts = function(id, callback) {
      this.api(id+"/posts", callback)
    }
    this.getFeed = function(id, callback) {
      this.api(id+"/feed", callback)
    }
    this.getAlbums = function(id, callback) {
      this.api(id+"/albums", callback)
    }
    this.getPhotos = function(albumId, callback) {
      this.api(albumId+"/photos", callback)
    }
    this.getInfo = function(id, callback) {
      this.api(id, callback)
    }
    this.getSitconPosts = function(callback) {
      this.getPosts(fansPage, callback)
    }
    this.getSitconFeed = function(callback) {
      this.getFeed(fansPage, callback)
    }
    this.getSitconAlbums = function(callback) {
      this.getAlbums(fansPage, callback)
    }
    this.getSitconInfo = function(callback) {
      this.getInfo(fansPage, callback)
    }
    this.whoAmI = function(callback) {
      this.api("/me", callback)
    }
  }
  w.FB = new facebook($, f)
})(window, window.jQuery, "SITCONtw")
