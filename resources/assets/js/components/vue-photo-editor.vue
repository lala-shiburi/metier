<template>
  <div>
    <div class="modal-body" style="padding:0px;">
      <div class="editor-container" ref="editor-container">
        <img class="backdrop-image" ref="backdrop-image" :src="image_source"/>
        <div class="back-drop" ref="backdrop"></div>
        <div class="front-image-container" ref="result-image-container">
          <img class="image" draggable="false" ref="result-image" :src="image_source"/>
          <div class="frame">
            <div class="lines">
              <div class="v-line" style="left:33.3333%"></div>
              <div class="v-line" style="left:66.6666%"></div>
              <div class="h-line" style="top: 33.3333%"></div>
              <div class="h-line" style="top: 66.6666%"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="photo-options">
        <div class="form-group">
          <label for="customRange3">Zoom Picture</label>
          <input type="range" step="5" ref="zoom-range" v-model="zoom" class="custom-range" value="0" min="0" max="300" id="customRange3">
        </div>
        <div class="form-group text-center">
          <input type="file" id="inputGroupFile01" class="file-input" ref="file-input" accept="image/x-png,image/jpeg">
          <button type="button" class="btn btn-default" v-on:click="triggerFileInput">Change Photo</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'vue-photo-editor',

  props: {
    resultImageDimension:{
      type: Object,
      default: () => ({
        height: 250,
        width: 250
      })
    },
  },
  data : () =>({
    editorDimension:{
      height: 250,
      width: 250
    },
    public_path: location.origin,
    images: [],
    zoom:0,
    position: {top:0, left:0},
    resolution: 0.80,
    image_source: location.origin+'/images/photo.png',
    busy: false,
    image_source_dimensions: {},
    preffered_diameter: 250,
    padding: 15
  }),
  methods: {
    show(image_source){
      this.preffered_diameter = 250
      this.position = {top: 0, left: 0},
      this.zoom = 0;
      this.image_source = image_source;
      this.calculateImageSourceDimensions()
    },
    triggerFileInput(){
      this.$refs['file-input'].click();
    },
    loading(bol){
      this.busy = bol;
    },
    setInitDimension(){
      var resultImage = jQuery(this.$refs['result-image']);
      
      console.log(this.image_source_dimensions.width +'--'+ this.editorDimension.width);

      if(this.image_source_dimensions.width > this.image_source_dimensions.height){
        if(this.image_source_dimensions.width <= this.editorDimension.width){
          this.setImageDimention('100%', 'initial');
        }
        else
        {
          this.setImageDimention('initial', '100%');
        }
      }
      else{
        if(this.image_source_dimensions.height <= this.editorDimension.height)
        {
          this.setImageDimention('initial', '100%');
        }
        else
        {
          this.setImageDimention('100%', 'initial');
        }
      }
    },
    setInitialPosition(){
      var resultImageContainer = this.$refs['result-image-container'];
      var left = ((jQuery(resultImageContainer).width()) / 2) - (this.image_source_dimensions.width / 2);
      var top = ((jQuery(resultImageContainer).height()) / 2) - (this.image_source_dimensions.height / 2);
      this.setImageResultPosition(left, top, true);

    },
    calculateImageSourceDimensions(){
      var img = new Image();
      var $this = this;
      var domninateWidth = false;
      img.onload = function(){
        // img dimension in proportion to resultImageDimension
        var height, width = null;

        if(img.width > img.height){
          var _w = ($this.editorDimension.height / img.height) * img.width;
          if(_w < $this.editorDimension.width){
            $this.image_source_dimensions.width = $this.editorDimension.width;
            $this.image_source_dimensions.height = ($this.image_source_dimensions.width / img.width) * img.height;
          }
          else{
            $this.image_source_dimensions.height = $this.editorDimension.height;
            $this.image_source_dimensions.width = ($this.image_source_dimensions.height / img.height) * img.width;
          }
        }
        else{
          var _h = ($this.editorDimension.width / img.width) * img.height;
          if(_h < $this.editorDimension.height){
            $this.image_source_dimensions.height = $this.editorDimension.height;
            $this.image_source_dimensions.width = ($this.image_source_dimensions.height / img.height) * img.width;
          }
          else{
            $this.image_source_dimensions.width = $this.editorDimension.width;
            $this.image_source_dimensions.height = ($this.image_source_dimensions.width / img.width) * img.height;
          }
        }
        $this.zoom = 0;
        $this.position = {top: 0, left: 0},
        $this.setInitDimension();
        $this.setInitialPosition();
      }
      img.src = this.image_source;
    },
    setImageDimention(width, height){
      var resultImage = jQuery(this.$refs['result-image']);
      var backdropImage = jQuery(this.$refs['backdrop-image']);
      resultImage.css({width: width, height: height});
      backdropImage.css({width: resultImage.width(), height: resultImage.height()});
      
    },
    setImageResultPosition(x, y, force){
      var resultImage = jQuery(this.$refs['result-image']);
      var resultImageContainer = jQuery(this.$refs['result-image-container']);
      var _x = resultImage.position().left;
      var _y = resultImage.position().top;
      var percent = this.zoom / 100;
      var width_result = this.image_source_dimensions.width + ( this.image_source_dimensions.width * percent);
      var height_result = this.image_source_dimensions.height + ( this.image_source_dimensions.height * percent);
      
      if((x <= 0 && (x + width_result) >= jQuery(resultImageContainer).width()) || force){
        _x = x;
      }
      else if((x + width_result) < jQuery(resultImageContainer).width()){
        _x = -(width_result - resultImageContainer.width());
      }
      if((y <= 0 && (y + height_result) >= jQuery(resultImageContainer).height()) || force){
        _y = y;
      }
      else if((y + height_result) < jQuery(resultImageContainer).height()){
        _y = -(height_result - resultImageContainer.height());
      }

      this.position = {top: _y, left: _x};
      
      jQuery(resultImage).css({ left: _x, top: _y });
      this.setImageBackdropPosition();
    },
    setImageBackdropPosition(){
      var backdropImage = this.$refs['backdrop-image'];
      var backdrop = this.$refs['backdrop'];
      var resultImage = this.$refs['result-image'];
      var resultImageContainer = this.$refs['result-image-container'];
      
      var leftCenter = (jQuery(resultImage).width() / 2) + jQuery(resultImage).position().left;
      var topCenter = (jQuery(resultImage).height() / 2) + jQuery(resultImage).position().top;
      var xChange = leftCenter - ((jQuery(resultImageContainer).width()) / 2 );
      var yChange = topCenter - ((jQuery(resultImageContainer).height()) / 2 );
      var posX = ((jQuery(backdrop).width() / 2) - (jQuery(backdropImage).width() / 2)) + xChange;
      var posY = ((jQuery(backdrop).height() / 2) - (jQuery(backdropImage).height() / 2)) + yChange;
      jQuery(backdropImage).css({ left : posX, top: posY });
    },
    zoomImage(value){
      var resultImage = jQuery(this.$refs['result-image']);
      this.zoom = value;
      var percent = value / 100;
      var width_result = this.image_source_dimensions.width + ( this.image_source_dimensions.width * percent);
      var height_result = this.image_source_dimensions.height + ( this.image_source_dimensions.height * percent);
      var centerPos = this.returnCenter();

      if(this.image_source_dimensions.width > this.image_source_dimensions.height){
        var _w = (this.editorDimension.height / this.image_source_dimensions.height) * this.image_source_dimensions.width;
        if(_w < this.editorDimension.width){
          this.setImageDimention(width_result, 'initial');
        }
        else{
          this.setImageDimention('initial', height_result);
        }
      }
      else{
        var _h = (this.editorDimension.width / this.image_source_dimensions.width) * this.image_source_dimensions.height;
        if(_h < this.editorDimension.height){
          this.setImageDimention('initial', height_result);
        }
        else{
          this.setImageDimention(width_result, 'initial');
        }
      }
      var left = centerPos.left - (width_result / 2);
      var top = centerPos.top - (height_result / 2);
      if(parseInt(left + width_result) <= parseInt(this.editorDimension.width)){
        left = -(width_result - this.editorDimension.width);
      }
      else{
        left = parseInt( width_result + left ) >= parseInt(this.editorDimension.width) ? left : 0;
      }
      if(parseInt(top + height_result) <= parseInt(this.editorDimension.height)){
        top = parseInt(-(height_result - this.editorDimension.height));
      }
      else{
        top = parseInt( height_result + top ) >= parseInt(this.editorDimension.height) ? top : 0;
      }
      this.setImageResultPosition(left, top);
    },
    returnCenter(){
      var resultImage = jQuery(this.$refs['result-image']);
      var leftCenter = (jQuery(resultImage).width() / 2) + jQuery(resultImage).position().left;
      var topCenter = (jQuery(resultImage).height() / 2) + jQuery(resultImage).position().top;
      return {left: leftCenter, top: topCenter};
    },
    saveImage(callback){
      var resultImage = jQuery(this.$refs['result-image']);
      var canvas = document.createElement('canvas');
      var ctx = canvas.getContext("2d");
      var img = new Image();
      var $this = this;

      img.onload = function(){
        canvas.height = $this.resultImageDimension.height;
        canvas.width = $this.resultImageDimension.width;

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
          var temp_oc = document.createElement('canvas'),
          _octx = temp_oc.getContext('2d');
          temp_oc.width = oc_width;
          temp_oc.height = oc_height;
          _octx.drawImage(oc, 0, 0, oc_width, oc_height);
          oc = temp_oc;
        }

        // step 2
        
        prefered_dimension = (oc_width > oc_height ? oc_height : oc_width);
        var h_w_r_t_c_w = ($this.editorDimension.height / $this.editorDimension.width) * oc_width;
        var xcal_per = oc_width / ((zoom * oc_width) + oc_width);
        var ycal_per = h_w_r_t_c_w / ((zoom * h_w_r_t_c_w) + h_w_r_t_c_w);
        var xzoom = xcal_per == Infinity ? oc_width : (oc_width * xcal_per);
        var yzoom = ycal_per == Infinity ? h_w_r_t_c_w : (h_w_r_t_c_w * ycal_per);
        if(oc_width > oc_height){
          var _w = ($this.editorDimension.height / oc_height) * oc_width;
          if(_w > $this.editorDimension.width){
            h_w_r_t_c_w = ($this.editorDimension.width / $this.editorDimension.height) * oc_height;
            ycal_per = oc_height / ((zoom * oc_height) + oc_height);
            xcal_per = h_w_r_t_c_w / ((zoom * h_w_r_t_c_w) + h_w_r_t_c_w);
            yzoom = ycal_per == Infinity ? oc_height : (oc_height * ycal_per);
            xzoom = xcal_per == Infinity ? h_w_r_t_c_w : (h_w_r_t_c_w * xcal_per);
          }
        }

        var leftPos = oc_width * (($this.position.left) / ($this.image_source_dimensions.width + (zoom * $this.image_source_dimensions.width))) * -1;
        var topPos = oc_height * (($this.position.top) / ($this.image_source_dimensions.height + (zoom * $this.image_source_dimensions.height))) * -1;

        // step 3, resize to final size
        ctx.drawImage(oc, leftPos, topPos, xzoom, yzoom,
        0, 0, canvas.width, canvas.height);

        callback(canvas.toDataURL())
      }

      img.src = $this.image_source;
    },
    setEditorDimensions(){
      if(this.resultImageDimension.width > this.resultImageDimension.height){
        this.editorDimension.height = this.preffered_diameter;
        this.editorDimension.width = (this.preffered_diameter / this.resultImageDimension.height) * this.resultImageDimension.width;
      }
      else{
        this.editorDimension.width = this.preffered_diameter;
        this.editorDimension.height = (this.preffered_diameter / this.resultImageDimension.width) * this.resultImageDimension.height;
      }
      jQuery(this.$refs['result-image-container']).css({'height': this.editorDimension.height, 'width': this.editorDimension.width})
      this.autoSizeResultImageContainer()
    },
    autoSizeResultImageContainer(){
      var width_min = jQuery(this.$refs['editor-container']).width() - this.padding;
      if(this.editorDimension.width > width_min){
        this.editorDimension.width = width_min;
        this.editorDimension.height = (width_min / this.resultImageDimension.width) * this.resultImageDimension.height
        jQuery(this.$refs['result-image-container']).css({'height': this.editorDimension.height, 'width': this.editorDimension.width})
      }
    },
  },
  mounted(){
    var $this = this;
    var resultImage = jQuery($this.$refs['result-image']);

    this.setEditorDimensions();
    setRenderEvent(this.autoSizeResultImageContainer)

    
    jQuery(this.$refs['file-input']).change(function(){
      if(this.files && this.files[0]){
        var reader = new FileReader();
        reader.onload = function(e){
          $this.image_source = e.target.result;
          $this.calculateImageSourceDimensions();
        }
        reader.readAsDataURL(this.files[0]);
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
      var pos = e.clientY ? e : e.changedTouches[0]
      originalMousePos.top = pos.clientY;
      originalMousePos.left = pos.clientX;
    }
    function dragMove(e){
      if(dragging){
        var pos = e.clientY ? e : e.changedTouches[0]
        var x = pos.clientX - originalMousePos.left;
        var y = pos.clientY - originalMousePos.top;
        var resultImage = $this.$refs['result-image'];
        $this.setImageResultPosition(jQuery(resultImage).position().left + x, jQuery(resultImage).position().top + y);
        originalMousePos.top = pos.clientY;
        originalMousePos.left = pos.clientX;
        // return false so that touch event cancels
        return e.preventDefault();
      }
    }
    function dragEnd(e){
      dragging = false;
    }
  }
}

function setRenderEvent(event){
  var rtime;
  var timeout = false;
  var delta = 200;
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
      event()
    }
  }
}
</script>

<style lang="scss" scoped>
.editor-container{
  -webkit-touch-callout: none;
  user-select: none;
  position: relative;
  height: 300px;
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
    margin: auto;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translateX(-50%) translateY(-50%);
    overflow: hidden;
    height: 250px;
    width: 250px;
    z-index: 11;
    .frame{
      border: 3px solid white;
      position: absolute;
      width:100%;
      height:100%;
      top: 0px;
      left: 0px;
      .lines{
        .h-line{
          height: 2px;
          width: 100%;
          background: white;
          position: absolute;
        }
        .v-line{
          height: 100%;
          width: 2px;
          background: white;
          position: absolute;
        }
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
  z-index: 1000;
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