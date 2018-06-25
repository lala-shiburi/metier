<template>
  <div v-if="type=='dropdown'" class="line-input dp">
    <select ref="selectELm" v-model="form[field]" :name="field">
      <slot name="input-content"/>
    </select>
    <div class="value" v-on:click="focusSelectDom" :class="{ 'is-invalid': form.errors.has(field) }">
      <span v-if="typeof form[field]=='undefined' || form[field].length==0">
        <slot/>
      </span>
      <span style="color:black;" v-else>{{selectOptions[currentSelectIndex].label}}</span>
      <i class="fa fa-angle-down" aria-hidden="true"></i>
    </div>
    <ul>
      <li v-for="(option,index) in selectOptions" v-bind:key="index" v-on:mousedown="selectChange(option.value); currentSelectIndex=index;">
        {{option.label}}
      </li>
    </ul>
    <div class="has-error" v-if="form.errors.has(field)" v-html="form.errors.get(field)"/>
  </div>
  <div v-else class="line-input" :class="{focused:inputFocused || type=='date'}">
    <input autofocus @focus="inputFocused=true" :type="type" :class="{ 'is-invalid': form.errors.has(field) }" @blur="inputFocused=form[field];" v-model="form[field]" :name="field">
    <label><slot/></label>
    <div class="has-error" v-if="form.errors.has(field)" v-html="form.errors.get(field)"/>
  </div>
</template>

<script>
export default {
  name: 'VLineInput',

  data: () => ({
    inputFocused: false,
    selectOptions:[],
    currentSelectIndex:0
  }),
  props: {
    form: {
      type: Object,
      required: true
    },
    field: {
      type: String,
      required: true
    },
    type: {
      type: String,
      required:false
    }
  },
  methods: {
    focusSelectDom() {
      this.$refs.selectELm.focus();
    },
    selectChange(val){
      this.$refs.selectELm.value = val;
      this.$refs.selectELm.dispatchEvent(new Event('change'))
      console.log(val);
    }
  },
  mounted(){
    if(this.type=="dropdown")
    {
      for(var i = 0; i < this.$refs.selectELm.children.length; i++){
        this.selectOptions.push({
          label: this.$refs.selectELm.children[i].innerHTML,
          value: this.$refs.selectELm.children[i].value,
        });
      }
    }
  }
}
</script>
