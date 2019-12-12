<template>
  <div class="d-inline-block">
  <div class="modal fade" :id="'refreshJob'+this.job" tabindex="-1" role="dialog" :aria-labelledby="'refreshJob'+this.job+'Label'" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form v-on:submit.prevent="refreshJob">
                <div class="modal-body">
                    <div class="text-center">
                        <p class="lead">Refresh this job?</p>
                        <div class="spinner-border d-none" role="status">
                          <span class="sr-only">Refreshing...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary close d-none" data-dismiss="modal">Close</button>
                    <button class="btn btn-secondary action" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger action" type="submit">Refresh</button>
                </div>
            </form>
        </div>
    </div>
  </div>
  <a class="text-success" href="" data-toggle="modal" :data-target="'#refreshJob'+this.job">Refresh</a>
  </div>
</template>

<script>
    export default {
        props: ['job', 'action'],
        data: function () {
    return {
      refreshed: false
    }
  },
  methods: {
    refreshJob: function(){
      var vm = this
      var modal = $('#refreshJob'+this.job);
      modal.find('p.lead').addClass('d-none')
      modal.find('.modal-footer').addClass('d-none')
      modal.find('.spinner-border').removeClass('d-none')
      $.ajax({
          url: vm.action,
          type: 'PUT',
          success: function(response) {
              modal.find('.spinner-border').addClass('d-none')
              if(response.status=='success') vm.refreshed = true
              modal.find('p.lead').html(response.message)
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
    $('#refreshJob'+this.job).on('hidden.bs.modal', function (e) {
      var modal = $(this)
      modal.find('p.lead').removeClass('d-none')
      modal.find('.modal-footer button.action').removeClass('d-none')
      modal.find('.modal-footer button.close').addClass('d-none')
      modal.find('.modal-footer').removeClass('d-none')
      modal.find('.spinner-border').addClass('d-none')
      modal.find('p.lead').text('Refresh this job?')
      if(vm.refreshed){
        $('#refresh_'+vm.job).replaceWith('')
        $('#edit_'+vm.job).removeClass('d-none')
      }
    })
  }
}
</script>
