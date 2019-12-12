<template>
  <div class="d-inline-block">
  <div class="modal fade" :id="'deleteJob'+this.job" tabindex="-1" role="dialog" :aria-labelledby="'deleteJob'+this.job+'Label'" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form v-on:submit.prevent="deleteJob">
                <div class="modal-body">
                    <div class="text-center">
                        <p class="lead">Delete this job?</p>
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
  <a class="text-danger" href="" data-toggle="modal" :data-target="'#deleteJob'+this.job">Delete</a>
  </div>
</template>

<script>
    export default {
        props: ['job', 'action'],
        data: function () {
    return {
      deleted: false
    }
  },
  methods: {
    deleteJob: function(){
      this.deleted = true
      var vm = this
      var modal = $('#deleteJob'+this.job);
      modal.find('p.lead').addClass('d-none')
      modal.find('.modal-footer').addClass('d-none')
      modal.find('.spinner-border').removeClass('d-none')
      $.ajax({
          url: vm.action,
          type: 'DELETE',
          success: function(response) {
              modal.find('.spinner-border').addClass('d-none')
              modal.find('p.lead').text(response.message)
              modal.find('p.lead').removeClass('d-none')
              modal.find('.modal-footer button.action').addClass('d-none')
              modal.find('.modal-footer button.close').removeClass('d-none')
              modal.find('.modal-footer').removeClass('d-none')
          }
      });
    }
  },
  mounted: function(){
    var vm = this
    $('#deleteJob'+this.job).on('hidden.bs.modal', function (e) {
      var modal = $(this)
      if(vm.deleted) $('#job-'+vm.job).remove()
    })
  }
}
</script>
