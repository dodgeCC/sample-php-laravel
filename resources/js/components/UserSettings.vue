<template>
<div>
<div class="card">
        <div class="card-header">
        <div v-if='saving' class="spinner-border spinner-border-sm float-right" role="status">
          <span class="sr-only">Saving...</span>
        </div>
        Notification Settings
        </div> 
        <div class="card-body">
  <div class="form-group">
      <div class="custom-control custom-switch mb-4">
          <input v-if='receive_platform_updates' type="checkbox" v-model='receive_platform_updates' v-on:click="updateSetting" class="custom-control-input" id="receive_platform_updates" checked>
          <input v-else type="checkbox" v-model='receive_platform_updates' v-on:click="updateSetting" class="custom-control-input" id="receive_platform_updates">
          <label class="custom-control-label" for="receive_platform_updates">Receive Platform Updates</label>
      </div>
  </div>
  <div class="form-group">
      <div class="custom-control custom-switch mb-4">
          <input v-if='receive_news_via_email' type="checkbox" v-model='receive_news_via_email' v-on:click="updateSetting" class="custom-control-input" id="receive_news_via_email" checked>
          <input v-else type="checkbox" v-model='receive_news_via_email' v-on:click="updateSetting" class="custom-control-input" id="receive_news_via_email">
          <label class="custom-control-label" for="receive_news_via_email">Receive News Via Email</label>
      </div>
  </div>
  </div>
  </div>
</div>
</template>

<script>
    export default {
        props: ['action', 'settings'],
    data: function () {
    return {
      receive_platform_updates: true,
      receive_news_via_email: true,
      saving: false
    }
  },
  methods: {
    updateSetting: function(){
      var vm = this
      vm.saving = true
        $.post(vm.action, { receive_platform_updates: $('#receive_platform_updates').is(':checked'), receive_news_via_email: $('#receive_news_via_email').is(':checked') }, function(response){
          vm.saving = false
          vm.receive_platform_updates = response.receive_platform_updates
          vm.receive_news_via_email = response.receive_news_via_email
        })
    }
  },
  created: function(){
    var user_settings = JSON.parse(this.settings)
    this.receive_platform_updates = user_settings.receive_platform_updates
    this.receive_news_via_email = user_settings.receive_news_via_email
  },
    }
</script>
