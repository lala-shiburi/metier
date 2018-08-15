<template>
  <div>
    <div class="modal fade" ref="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Photo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" style="padding:0px;">
            <div class="editor-container" ref="editor-container">
              <img class="backdrop-image" ref="backdrop-image" :src="image_source"/>
              <div class="back-drop" ref="backdrop"></div>
              <div class="front-image-container" ref="result-image-container">
                <img class="image" draggable="false" ref="result-image" :src="image_source"/>
                <div class="lines">
                  <div class="v-line" style="left:33.3333%"></div>
                  <div class="v-line" style="left:66.6666%"></div>
                  <div class="h-line" style="top: 33.3333%"></div>
                  <div class="h-line" style="top: 66.6666%"></div>
                </div>
              </div>
            </div>
            <div class="photo-options">
              <div class="form-group">
                <label for="customRange3">Zoom Picture</label>
                <input type="range" ref="zoom-range" v-model="zoom" class="custom-range" value="0" min="0" max="300" id="customRange3">
              </div>
              <div class="form-group text-center">
                <input type="file" id="inputGroupFile01" class="file-input" ref="file-input" accept="image/x-png,image/jpeg">
                <button type="button" class="btn btn-default" v-on:click="triggerFileInput">Change Photo</button>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" v-on:click="saveImage" data-dismiss="modal">Save</button>
          </div>
        </div>
      </div>
    </div>
    <div class="loading" v-show="busy">
      <div class="background"></div>
      <img :src="public_path+'/images/loading.gif'" class="loading-icon" alt="">
    </div>
  </div>
</template>

<script>
import Vue from 'vue'
export default {
  name: 'PhotoEditor',

  props: {
  },
  data : () =>({
    public_path: location.origin,
    images: [],
    editorDimension: {
      height: 250,
      width: 250
    },
    zoom:0,
    position: {top:0, left:0},
    resolution: 0.80,
    image_source: location.origin+'/images/photo.png',
    busy: false
  }),
  methods: {
    show(image_source){
      this.position = {top: 0, left: 0},
      this.zoom = 0;
      this.image_source = image_source;
      jQuery(this.$refs.modal).modal('show');
    },
    triggerFileInput(){
      this.$refs['file-input'].click();
    },
    loading(bol){
      this.busy = bol;
    },
    setInitDimension(){
      var resultImage = jQuery(this.$refs['result-image']);
      var $this = this;
      var img = new Image();

      img.onload = function(){
        if(img.width > img.height){
          $this.setImageDimention('initial', '100%');
        }
        else{
          $this.setImageDimention('100%', 'initial');
        }
      }
      img.src = this.image_source;
    },
    setInitialPosition(){
      var resultImage = this.$refs['result-image'];
      var resultImageContainer = this.$refs['result-image-container'];
      var img = new Image();
      var $this = this;
      img.onload = function(){
        var left = ((jQuery(resultImageContainer).width() + 4) / 2) - (jQuery(resultImage).width() / 2);
        var top = ((jQuery(resultImageContainer).height() + 4) / 2) - (jQuery(resultImage).height() / 2);
        $this.setImageResultPosition(left, top);
      }
      img.src = this.image_source;

    },
    setImageDimention(width, height){
      var resultImage = jQuery(this.$refs['result-image']);
      var backdropImage = jQuery(this.$refs['backdrop-image']);
      resultImage.css({width: width, height: height});
      backdropImage.css({width: resultImage.width(), height: resultImage.height()});
      
    },
    setImageResultPosition(x, y){
      var resultImage = jQuery(this.$refs['result-image']);
      var resultImageContainer = jQuery(this.$refs['result-image-container']);
      var _x = resultImage.position().left;
      var _y = resultImage.position().top;

      if(x <= 0 && (x + jQuery(resultImage).width()) >= jQuery(resultImageContainer).width()){
        _x = x;
      }
      else if((x + jQuery(resultImage).width()) < jQuery(resultImageContainer).width()){
        _x = -(resultImage.width() - resultImageContainer.width());
      }
      if(y < 0 && (y + jQuery(resultImage).height()) >= jQuery(resultImageContainer).height()){
        _y = y;
      }
      else if((y + jQuery(resultImage).height()) < jQuery(resultImageContainer).height()){
        _y = -(resultImage.height() - resultImageContainer.height());
      }

      this.position = {top: _y, left: _x};
      
      jQuery(resultImage).css({ left: _x, top: _y });
      this.setImageBackdropPosition();
    },
    setImageBackdropPosition(){
      var border = 4;
      var backdropImage = this.$refs['backdrop-image'];
      var backdrop = this.$refs['backdrop'];
      var resultImage = this.$refs['result-image'];
      var resultImageContainer = this.$refs['result-image-container'];
      
      var leftCenter = (jQuery(resultImage).width() / 2) + jQuery(resultImage).position().left;
      var topCenter = (jQuery(resultImage).height() / 2) + jQuery(resultImage).position().top;
      var xChange = leftCenter - ((jQuery(resultImageContainer).width() + border) / 2 );
      var yChange = topCenter - ((jQuery(resultImageContainer).height() + border) / 2 );
      var posX = ((jQuery(backdrop).width() / 2) - (jQuery(backdropImage).width() / 2)) + xChange + 2;
      var posY = ((jQuery(backdrop).height() / 2) - (jQuery(backdropImage).height() / 2)) + yChange - 2;
      jQuery(backdropImage).css({ left : posX, top: posY });
    },
    zoomImage(value){
      var resultImage = jQuery(this.$refs['result-image']);
      this.zoom = value;
      var percent = value / 100;
      var dimension_result = 250 + ( 250 * percent);
      var centerPos = this.returnCenter();
      if(resultImage.width() < resultImage.height())
      {
        this.setImageDimention(dimension_result, 'initial');
      }
      else{
        this.setImageDimention('initial', dimension_result);
      }
      this.setImageResultPosition(centerPos.left - (resultImage.width() / 2), centerPos.top - (resultImage.height() / 2) );
    },
    returnCenter(){
      var resultImage = jQuery(this.$refs['result-image']);
      var leftCenter = (jQuery(resultImage).width() / 2) + jQuery(resultImage).position().left;
      var topCenter = (jQuery(resultImage).height() / 2) + jQuery(resultImage).position().top;
      return {left: leftCenter, top: topCenter};
    },
    saveImage(){
      var resultImage = jQuery(this.$refs['result-image']);
      var canvas = document.createElement('canvas');
      var ctx = canvas.getContext("2d");
      var img = new Image();
      var $this = this;

      img.onload = function(){
        // set size proportional to specified image size
        canvas.height = $this.editorDimension.height;
        canvas.width = $this.editorDimension.width;

        var img_width = img.width;
        var img_height = img.height;
        var prefered_dimension = img_width > img_height ? img_height : img_width;
        var zoom = $this.zoom / 100;
        var cal_zoom_dimension = prefered_dimension * (prefered_dimension / ((zoom * prefered_dimension) + prefered_dimension))
        var resolution = $this.resolution;

        // step 1
        var oc = document.createElement('canvas'),
            octx = oc.getContext('2d');
        
        if((cal_zoom_dimension * resolution) > canvas.width){
          console.log(cal_zoom_dimension+'asd'+canvas.width)
          oc.width = img.width * resolution;
          oc.height = img.height * resolution;
        }
        else{
          oc.width = img.width;
          oc.height = img.height;
        }

        octx.drawImage(img, 0, 0, oc.width, oc.height);
        
        prefered_dimension = oc.width > oc.height ? oc.height : oc.width;
        var oc_width = oc.width;
        var oc_height = oc.height;
        if((prefered_dimension / 2) > canvas.width){
          oc_width = (oc.width * resolution)
          oc_height = (oc.height * resolution)
        }

        // step 2
        octx.drawImage(oc, 0, 0, oc_width, oc_height);
        prefered_dimension = oc_width > oc_height ? oc_height : oc_width;
        var cal_per = prefered_dimension / ((zoom * prefered_dimension) + prefered_dimension);
        zoom = cal_per == Infinity ? prefered_dimension : (prefered_dimension * cal_per);
        var leftPos = oc_width * ($this.position.left / resultImage.width()) * -1;
        var topPos = oc_height * ($this.position.top / resultImage.height()) * -1;

        // step 3, resize to final size
        ctx.drawImage(oc, leftPos, topPos, zoom, zoom,
        0, 0, canvas.width, canvas.height);

        console.log(canvas.toDataURL());
        
        $this.$emit('update', canvas.toDataURL())
      }

      img.src = $this.image_source;
    }
  },
  mounted(){
    var $this = this;
    var resultImage = jQuery($this.$refs['result-image']);

    jQuery(this.$refs['file-input']).change(function(){
      if(this.files && this.files[0]){
        var reader = new FileReader();
        reader.onload = function(e){
          $this.image_source = e.target.result;
          $this.zoom = 0;
          $this.position = null,
          $this.setInitDimension();
          $this.setInitialPosition();
        }
        reader.readAsDataURL(this.files[0]);
      }
    });

    jQuery(this.$refs.modal).on('shown.bs.modal', function (e) {
      resultImage.css({top:0,left:0});
      if($this.zoom){
        $this.zoomImage($this.zoom);
      }
      else{
        $this.setInitDimension();
      }
      if($this.position.top){
        $this.setImageResultPosition($this.position.left, $this.position.top);
      }
      else{
        $this.setInitialPosition();
      }
    });
    jQuery(this.$refs['editor-container'])
    .bind('mousedown', dragStart)
    .bind('touchstart', dragStart)
    jQuery(document).bind('mousemove', dragMove)
    .bind('touchmove', dragMove);

    jQuery(document).bind('mouseup', dragEnd)
    .bind('touchend', dragEnd);

    jQuery(this.$refs['zoom-range'])[0].addEventListener('input', function(){
      $this.zoomImage(this.value);
    });

    function removeNega(value){
      return Math.sqrt(Math.pow(value,2));
    }

    var dragging = false;
    var originalMousePos = {};
    function dragStart(e){
      dragging = true;
      originalMousePos.top = e.clientY;
      originalMousePos.left = e.clientX;
    }
    function dragMove(e){
      if(dragging){
        var x = e.clientX - originalMousePos.left;
        var y = e.clientY - originalMousePos.top;
        var resultImage = $this.$refs['result-image'];
        $this.setImageResultPosition(jQuery(resultImage).position().left + x, jQuery(resultImage).position().top + y);
        originalMousePos.top = e.clientY;
        originalMousePos.left = e.clientX;
      }
    }
    function dragEnd(e){
      dragging = false;
    }
  }
}
</script>

<style lang="scss" scoped>
.editor-container{
  -webkit-touch-callout: none;
  user-select: none;
  position: relative;
  min-height: 300px;
  overflow: hidden;
  background: black;
  .back-drop{
    height: 100%;
    width: 100%;
    opacity: 0.5;
    z-index: 10;
    position: absolute;
    background: black;
  }
  .backdrop-image{
    position: absolute;
    z-index: 9;
    -webkit-touch-callout: none;
    user-select: none;
  }
  .front-image-container{
    border: 2px solid white;
    margin: auto;
    position: relative;
    overflow: hidden;
    height: 250px;
    width: 250px;
    z-index: 11;
    margin-top: 20px;
    .lines{
      .h-line{
        height: 1px;
        width: 100%;
        background: white;
        position: absolute;
      }
      .v-line{
        height: 100%;
        width: 1px;
        background: white;
        position: absolute;
      }
    }
    .image{
      position: absolute;
    }
  }
}
.photo-options{
  padding: 0px 15px;
}
.file-input{
  display: none;
}
.loading{
  position: fixed;
  top: 0px;
  left: 0px;
  width: 100%;
  height: 100%;
  .background{
    background: black;
    opacity: 0.75;
    position: absolute;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
  }
  .loading-icon{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translateX(-50%) translateY(-50%);
    width: 60px;
  }
}
</style>

