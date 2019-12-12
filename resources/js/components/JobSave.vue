<template>
  <div>
  <div class="modal fade" :id="'saveJob'+this.job" tabindex="-1" role="dialog" :aria-labelledby="'saveJob'+this.job+'Label'" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form v-on:submit.prevent="saveJob">
                <div class="modal-body">
                    <div class="text-center">
                        <p class="lead">Save this job?</p>
                        <div class="spinner-border d-none" role="status">
                          <span class="sr-only">Saving...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary close d-none" data-dismiss="modal">Close</button>
                    <button class="btn btn-secondary action" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger action" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
  </div>
  <p :id="'saved_'+this.job" class="lead text-center d-none">SAVED</p>
  <button :id="'save_button_'+this.job" class="btn btn-light btn-block" data-toggle="modal" :data-target="'#saveJob'+this.job">SAVE</button>
  </div>
</template>

<script>
    export default {
        props: ['action', 'job'],
  methods: {
    saveJob: function(){
      var vm = this
      var modal = $('#saveJob'+this.job);
      modal.find('p.lead').addClass('d-none')
      modal.find('.modal-footer').addClass('d-none')
      modal.find('.spinner-border').removeClass('d-none')
      $.post(this.action, { job_id: vm.job }, function(response){
        modal.find('p.lead').text(response.message)
        modal.find('p.lead').removeClass('d-none')
        modal.find('.modal-footer button.action').addClass('d-none')
        modal.find('.modal-footer button.close').removeClass('d-none')
        modal.find('.modal-footer').removeClass('d-none')
        modal.find('.spinner-border').addClass('d-none')
        $('#saved_'+vm.job).removeClass('d-none')
        $('#save_button_'+vm.job).hide()
      })
    }
  }
    }
</script>
