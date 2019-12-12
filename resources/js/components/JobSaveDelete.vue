<template>
  <div>
  <div class="modal fade" :id="'deleteSaveJob'+this.job" tabindex="-1" role="dialog" :aria-labelledby="'deleteSaveJob'+this.job+'Label'" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form v-on:submit.prevent="deleteSaveJob">
                <div class="modal-body">
                    <div class="text-center">
                        <p class="lead">Delete this saved job?</p>
                        <div class="spinner-border d-none" role="status">
                          <span class="sr-only">Deleting...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary close d-none" data-dismiss="modal">Close</button>
                    <button class="btn btn-secondary action" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger action" type="submit">Delete</button>
                </div>
            </form>
        </div>
    </div>
  </div>
  <p :id="'deleted_'+this.job" class="lead text-center d-none">DELETED</p>
  <button :id="'delete_button_'+this.job" class="btn btn-primary btn-danger btn-block" data-toggle="modal" :data-target="'#deleteSaveJob'+this.job">DELETE</button>
  </div>
</template>

<script>
    export default {
        props: ['action', 'job'],
        data: function () {
    return {
      deleted: false
    }
  },
  methods: {
    deleteSaveJob: function(){
      this.deleted = true
      var vm = this
      var modal = $('#deleteSaveJob'+this.job);
      modal.find('p.lead').addClass('d-none')
      modal.find('.modal-footer').addClass('d-none')
      modal.find('.spinner-border').removeClass('d-none')
      $.ajax({
          url: vm.action,
          type: 'DELETE',
          success: function(response) {
              modal.find('p.lead').text(response.message)
              modal.find('p.lead').removeClass('d-none')
              modal.find('.modal-footer button.action').addClass('d-none')
              modal.find('.modal-footer button.close').removeClass('d-none')
              modal.find('.modal-footer').removeClass('d-none')
              modal.find('.spinner-border').addClass('d-none')
          }
      });
    }
  },
  mounted: function(){
    var vm = this
    $('#deleteSaveJob'+this.job).on('hidden.bs.modal', function (e) {
      var modal = $(this)
      if(vm.deleted) $('#saved-job-'+vm.job).remove()
    })
  }
    }
</script>
