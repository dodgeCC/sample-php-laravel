<template>
  <div>
  <div class="modal fade" :id="'applyJob'+this.job" tabindex="-1" role="dialog" :aria-labelledby="'applyJob'+this.job+'Label'" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form v-on:submit.prevent="applyJob">
                <div class="modal-body">
                    <div class="text-center">
                        <p class="lead">Apply to this job?</p>
                        <div class="spinner-border d-none" role="status">
                          <span class="sr-only">Applying...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary d-none close" data-dismiss="modal">Close</button>
                    <button class="btn btn-secondary action" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger action" type="submit">Apply</button>
                </div>
            </form>
        </div>
    </div>
  </div>
  <p :id="'applied_'+this.job" class="lead text-center d-none">APPLIED</p>
  <button :id="'apply_button_'+this.job" class="btn btn-primary btn-block mb-4" data-toggle="modal" :data-target="'#applyJob'+this.job">APPLY</button>
  </div>
</template>

<script>
    export default {
        props: ['action', 'job'],
  methods: {
    applyJob: function(){
      var vm = this
      var modal = $('#applyJob'+this.job);
      modal.find('p.lead').addClass('d-none')
      modal.find('.modal-footer').addClass('d-none')
      modal.find('.spinner-border').removeClass('d-none')
      $.post(this.action, { job_id: vm.job }, function(response){
        modal.find('.spinner-border').addClass('d-none')
        modal.find('p.lead').text(response.message)
        modal.find('p.lead').removeClass('d-none')
        modal.find('.modal-footer button.action').addClass('d-none')
        modal.find('.modal-footer button.close').removeClass('d-none')
        modal.find('.modal-footer').removeClass('d-none')
        $('#applied_'+vm.job).removeClass('d-none')
        $('#apply_button_'+vm.job).hide()
      })
    }
  }
    }
</script>
