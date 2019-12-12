<template>
  <div class="form-group">
      <span>{{ this.distance }} miles</span>
      <input type="range" id="within" name="within" min="0" max="100" step="5" v-on:change="updateDistance" :value=this.distance class="form-control-range">
  </div>
</template>

<script>
    export default {
        props: ['within'],
    data: function () {
    return {
      distance: null
    }
  },
  methods: {
    updateDistance: function(){
      var vm = this
      vm.distance = $('#within').val()
    }
  },
  created: function(){
    this.distance = this.within
  }
    }
</script>
