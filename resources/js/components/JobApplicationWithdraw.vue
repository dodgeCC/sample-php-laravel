<template>
  <div>
  <div class="modal fade" :id="'withdrawApplication'+this.application" tabindex="-1" role="dialog" :aria-labelledby="'withdrawApplication'+this.application+'Label'" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form v-on:submit.prevent="withdrawApplication">
                <div class="modal-body">
                    <div class="text-center">
                        <p class="lead">Withdraw this job application?</p>
                        <div class="spinner-border d-none" role="status">
                          <span class="sr-only">Withdrawing...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary close d-none" data-dismiss="modal">Close</button>
                    <button class="btn btn-secondary action" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger action" type="submit">Withdraw</button>
                </div>
            </form>
        </div>
    </div>
  </div>
  <p :id="'withdrawn_'+this.application" class="lead text-center d-none">WITHDRAWN</p>
  <button :id="'withdraw_button_'+this.application" class="btn btn-primary btn-danger btn-block" data-toggle="modal" :data-target="'#withdrawApplication'+this.application">WITHDRAW</button>
  </div>
</template>

<script>
    export default {
        props: ['action', 'application'],
  methods: {
    withdrawApplication: function(){
      var vm = this
      var modal = $('#withdrawApplication'+this.application);
      modal.find('p.lead').addClass('d-none')
      modal.find('.modal-footer').addClass('d-none')
      modal.find('.spinner-border').removeClass('d-none')
      $.ajax({
          url: this.action,
          type: 'PUT',
          success: function(response) {
              modal.find('.spinner-border').addClass('d-none')
              modal.find('p.lead').text(response.message)
              modal.find('p.lead').removeClass('d-none')
              modal.find('.modal-footer button.action').addClass('d-none')
              modal.find('.modal-footer button.close').removeClass('d-none')
              modal.find('.modal-footer').removeClass('d-none')
              $('#withdrawn_'+vm.application).removeClass('d-none')
              $('#withdraw_button_'+vm.application).hide()
          }
      })
    }
  }
    }
</script>
