import Form from 'vform'

export default {
  uploadPhoto : (file, url, params) => {
    return new Promise((resolve, reject)=>{
          var reader = new FileReader()
          reader.onload = function(event){
            var form = new Form({
              photo_data : event.target.result
            })

            jQuery.extend(form, params)

            form.post(url || '/api/photo/upload/temp').then(({data})=>{
              resolve(data)
            })
          }
          reader.readAsDataURL(file);
      })
    }
}