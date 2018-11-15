import axios from 'axios'

export default {
  uploadPhoto : (file) => {
    return new Promise((resolve, reject)=>{
          var reader = new FileReader()
          reader.onload = function(event){
            console.log(event)
            // axios({
            //   url: '/api/photo/upload',
            //   method: 'post',
            //   params: {}
            // }).then()
          }
          reader.readAsDataURL(file);
      })
    }
}