<template>
<div>
<ul class="list-group overflow-auto messages mb-2" style="max-height:300px">
  <li class="list-group-item" v-for="message in the_messages">
    <div class="float-left">
    <img :src=message.photo_url :alt=message.user class="spark-nav-profile-photo"/>
    <span>{{ message.user }}</span>
    </div>
    <p class="float-right">{{ message.content }}</p>
  </li>
</ul>
<form v-if='!admin' v-on:submit.prevent="sendMessage">
<textarea class="form-control mb-2" v-model='message' placeholder="Message" v-on:keyup="typingMessage" v-on:blur="doneTyping"></textarea>
<button class="btn btn-primary float-left" type="submit">Send</button>
<p v-if='!admin && typing' class="float-right">{{ this.user }} is typing a message...</p>
<div v-if='typing' class="spinner-grow spinner-grow-sm float-right mr-2" role="status">
  <span class="sr-only">Typing...</span>
</div>
</form>
<div v-if='sending' class="spinner-border" role="status">
  <span class="sr-only">Sending...</span>
</div>
</div>
</template>

<script>
export default {
  props: ['action', 'messages', 'channel', 'user', 'admin'],
  data: function () {
    return {
      message: '',
      sending: false,
      typing: false,
      the_messages: []
    }
  },
  methods: {
    scrollMessages: function(){
      $("ul.messages").animate({ scrollTop: $('ul.messages').prop("scrollHeight")}, 1000)
    },
    sendMessage: function(){
      var vm = this
      if(vm.message){
        vm.sending = true
        $.post(vm.action, { message: vm.message }, function(response){
          vm.sending = false
          vm.the_messages = JSON.parse(response.messages)
          vm.message = ''
          vm.scrollMessages()
        })
      }
    },
    typingMessage: function (e) {
      var textarea = $(e.target)
      if(textarea.val()){
        Echo.private(this.channel)
    .whisper('typing', {
        name: this.user
    });
      }else{
      Echo.private(this.channel)
            .whisper('not_typing', {
            name: ''
        });
      }
    },
    doneTyping: function (e) {
        Echo.private(this.channel)
            .whisper('not_typing', {
            name: ''
        });
    },
    updateMessages: function () {
      var vm = this
      vm.sending = true
      $.post(vm.action, { message: null }, function(response){
          vm.sending = false
          vm.typing = false
          vm.the_messages = JSON.parse(response.messages)
          vm.scrollMessages()
      })
    }
  },
  created: function(){
    this.the_messages = JSON.parse(this.messages)
  },
  mounted: function(){
    this.scrollMessages()

    Echo.private(this.channel)
    .listen('MessageSent', (e) => {
        this.updateMessages()
    });

    Echo.private(this.channel)
    .listenForWhisper('typing', (e) => {
        this.typing = true
    });

    Echo.private(this.channel)
    .listenForWhisper('not_typing', (e) => {
        this.typing = false
    });
  }
}
</script>
