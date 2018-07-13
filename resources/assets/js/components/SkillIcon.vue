<template>
  <div data-toggle="tooltip" data-html="true" :data-placement="pos?pos:'top'" :title="'<b>'+upperCaseFirst(icon)+'</b>'" class="skill-icon" :class="size? size: 'small-icon'">
    <div class="bg-color" :style="icons[icon].background ? 'background:'+icons[icon].background : ''"></div>
    <img :src="icons[icon].img">
  </div>
</template>

<script>
export default {
  name: 'SkillIcon',

  props: {
    icon: { type: String, required: true },
    size: { type: String, default: null },
    pos: { type: String, default: null },
  },

  data: () => ({
    icons: {
      php: { img: window.config.public_location + "images/php.png", background: "#4766cc"},
      ruby: { img: window.config.public_location + "images/ruby.png", background: "#f9dd64"},
      javascript: { img: window.config.public_location + "images/javascript.png", background: "white"},
      cPlusPlus: { img: window.config.public_location + "images/cPlusPlus.png", background: "white"},
      csharp: { img: window.config.public_location + "images/csharp.png", background: "white"},
      swift: { img: window.config.public_location + "images/swift.png", background: "white"},
      go: { img: window.config.public_location + "images/go.png", background: "#eacfaf"},
      typeScript: { img: window.config.public_location + "images/typescript.png", background: "white"},
      python: { img: window.config.public_location + "images/python.png", background: "white"},
      perl: { img: window.config.public_location + "images/perl.png", background: "white"},
      sql: { img: window.config.public_location + "images/sql.png", background: "white"},
      vb: { img: window.config.public_location + "images/vb.png", background: "white"},
      c: { img: window.config.public_location + "images/c.png", background: "white"},
      typescript: { img: window.config.public_location + "images/typescript.png", background: "white"},

      // frameworks
      angular: { img: window.config.public_location + "images/angular.png", background: "#4766cc"},
      node: { img: window.config.public_location + "images/node.png", background: "white"},
      vue: { img: window.config.public_location + "images/vue.png", background: "white"},
      asp: { img: window.config.public_location + "images/asp.png", background: "white"},
      react: { img: window.config.public_location + "images/react.png", background: "white"},
      laravel: { img: window.config.public_location + "images/laravel.png", background: "white"},
      codeigniter: { img: window.config.public_location + "images/codeigniter.png", background: "white"},
      jquery: { img: window.config.public_location + "images/jquery.png", background: "white"},
    }
  }),
  methods: {
    upperCaseFirst: function(string){
      return string.charAt(0).toUpperCase() + string.slice(1);
    }
  },
  mounted(){
    jQuery(function () {
      jQuery('[data-toggle="tooltip"]').tooltip()
    })
  }
}
</script>
