import jQuery from 'jquery'

export default new function(){
  var rtime;
  var timeout = false;
  var delta = 200;
  var events = []

  this.addEvent = function(event){
    events.push(event)
  }

  jQuery(window).resize(function(){
    rtime = new Date();
    if (timeout === false) {
        timeout = true;
        setTimeout(resizeend, delta);
    }
  })

  function resizeend() {
    if (new Date() - rtime < delta) {
      setTimeout(resizeend, delta);
    } else {
      timeout = false;
      events.forEach(function(event) {
        try{
          event()
        }catch(e){}
      });
    }
  }
}