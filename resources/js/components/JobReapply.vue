<template>
  <div>
  <div class="modal fade" :id="'reapplyJob'+this.application" tabindex="-1" role="dialog" :aria-labelledby="'reapplyJob'+this.application+'Label'" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form v-on:submit.prevent="reapplyJob">
                <div class="modal-body">
                    <div class="text-center">
                        <p class="lead">Reapply to this job?</p>
                        <div class="spinner-border d-none" role="status">
                          <span class="sr-only">Reapplying...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary close d-none" data-dismiss="modal">Close</button>
                    <button class="btn btn-secondary action" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger action" type="submit">Reapply</button>
                </div>
            </form>
        </div>
    </div>
  </div>
  <p :id="'applied_'+this.application" class="lead text-center d-none">APPLIED</p>
  <button :id="'apply_button_'+this.application" class="btn btn-primary btn-block" data-toggle="modal" :data-target="'#reapplyJob'+this.application">REAPPLY</button>
  </div>
</template>

<script>
    export default {
        props: ['action', 'application'],
  methods: {
    reapplyJob: function(){
      var vm = this
      var modal = $('#reapplyJob'+this.application);
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
              $('#applied_'+vm.application).removeClass('d-none')
              $('#apply_button_'+vm.application).hide()
              $('p.application-status-'+vm.application).remove()
          }
      })
    }
  }
    }
</script>
