<template>
  <div>
  <div class="modal fade" :id="'processApplication'+this.application" tabindex="-1" role="dialog" :aria-labelledby="'processApplication'+this.application+'Label'" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form v-on:submit.prevent="processApplication">
                <div class="modal-body">
                    <div class="text-center">
                        <p class="lead message d-none"></p>
                        <p v-show='this.the_status==2 && this.to_status==3' class="lead">Shortlist this job application?</p>
                        <p v-show='this.the_status==3 && this.to_status==2' class="lead">Remove from shortlist?</p>
                        <p v-show='this.to_status==5' class="lead">Decline this job application?</p>
                        <p v-show='this.to_status==4' class="lead">Accept this job application?</p>
                        <p v-show='this.the_status==4 && this.to_status==2' class="lead">Undo Accept?</p>
                        <p v-show='this.the_status==5 && this.to_status==2' class="lead">Undo Decline?</p>
                        <p v-show='!this.job_filled && this.to_status==0' class="lead">Set job as filled?</p>
                        <p v-show='this.job_filled && this.to_status==0' class="lead">Undo job as filled?</p>
                        <div class="spinner-border d-none" role="status">
                          <span v-show='this.to_status==3' class="sr-only">Shortlisting...</span>
                          <span v-show='this.to_status==2' class="sr-only">Removing from shortlist...</span>
                          <span v-show='this.to_status==5' class="sr-only">Declining...</span>
                          <span v-show='this.to_status==4' class="sr-only">Accepting...</span>
                          <span v-show='this.the_status==4 && this.to_status==2' class="sr-only">Undoing accept...</span>
                          <span v-show='this.the_status==5 && this.to_status==2' class="sr-only">Undoing decline...</span>
                          <span v-show='!this.job_filled && this.to_status==0' class="sr-only">Setting job as filled...</span>
                          <span v-show='this.job_filled && this.to_status==0' class="sr-only">Undoing job as filled...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary d-none close" data-dismiss="modal">Close</button>
                    <button class="btn btn-secondary action" data-dismiss="modal">Cancel</button>
                    <button v-show='this.the_status==2 && this.to_status==3' class="btn btn-success action" type="submit">Shortlist</button>
                    <button v-show='this.the_status==3 && this.to_status==2' class="btn btn-danger action" type="submit">Remove from shortlist</button>
                    <button v-show='this.to_status==5' class="btn btn-danger action" type="submit">Decline</button>
                    <button v-show='this.to_status==4' class="btn btn-success action" type="submit">Accept</button>
                    <button v-show='(this.the_status==4 || this.the_status==5) && this.to_status==2' class="btn btn-danger action" type="submit">Undo</button>
                    <button v-show='(!this.job_filled && this.to_status==0)' class="btn btn-success action" type="submit">Set Filled</button>
                    <button v-show='(this.job_filled && this.to_status==0)' class="btn btn-danger action" type="submit">Undo</button>
                </div>
            </form>
        </div>
    </div>
  </div>
  <p v-if='this.the_status==3' class="lead">SHORTLISTED</p>
  <p v-else-if='this.the_status==4' class="lead">ACCEPTED</p>
  <p v-else-if='this.the_status==5' class="lead">DECLINED</p>
  <p v-else class="lead">IN PROCESS</p>
  <p v-if=this.job_filled class="lead">JOB IS FILLED</p>
  <button v-show='this.the_status==2' class="btn btn-success btn-sm mb-2" data-toggle="modal" :data-target="'#processApplication'+this.application" data-to="3">SHORTLIST</button>
  <button v-show='this.the_status==3' class="btn btn-danger btn-sm mb-2" data-toggle="modal" :data-target="'#processApplication'+this.application" data-to="2">REMOVE FROM SHORTLIST</button>
  <button v-show='this.the_status!=4 && this.the_status!=5' class="btn btn-danger btn-sm mb-2" data-toggle="modal" :data-target="'#processApplication'+this.application" data-to="5">DECLINE</button>
  <button v-show='this.the_status!=4 && this.the_status!=5' class="btn btn-success btn-sm mb-2" data-toggle="modal" :data-target="'#processApplication'+this.application" data-to="4">ACCEPT</button>
  <button v-show='this.the_status==5' class="btn btn-danger btn-sm mb-2" data-toggle="modal" :data-target="'#processApplication'+this.application" data-to="2">UNDO DECLINE</button>
  <button v-show='this.the_status==4' class="btn btn-danger btn-sm mb-2" data-toggle="modal" :data-target="'#processApplication'+this.application" data-to="2">UNDO ACCEPT</button>
  <button v-show=!this.job_filled class="btn btn-success btn-sm mb-2" data-toggle="modal" :data-target="'#processApplication'+this.application" data-to="0">SET JOB AS FILLED</button>
  <button v-show=this.job_filled class="btn btn-danger btn-sm mb-2" data-toggle="modal" :data-target="'#processApplication'+this.application" data-to="0">UNDO JOB AS FILLED</button>
  </div>
</template>

<script>
    export default {
        props: ['action', 'application', 'status', 'filled'],
        data: function () {
    return {
      the_status: this.status,
      to_status: null,
      job_filled: this.filled
    }
  },
  methods: {
    processApplication: function(){
      var vm = this
      var modal = $('#processApplication'+this.application);
      modal.find('p.lead').addClass('d-none')
      modal.find('.modal-footer').addClass('d-none')
      modal.find('.spinner-border').removeClass('d-none')
      $.ajax({
          url: this.action,
          data: { status: this.to_status },
          type: 'PUT',
          success: function(response) {
              modal.find('.spinner-border').addClass('d-none')
              if(response.status==0){
                vm.job_filled = !vm.job_filled
              }else{
                vm.the_status = response.status
              }
              modal.find('p.lead.message').text(response.message)
              modal.find('p.lead.message').removeClass('d-none')
              modal.find('.modal-footer button.action').addClass('d-none')
              modal.find('.modal-footer button.close').removeClass('d-none')
              modal.find('.modal-footer').removeClass('d-none')
          }
      })
    }
  },
  mounted: function(){
    var vm = this
    $('#processApplication'+this.application).on('shown.bs.modal', function (e) {
      var button = $(e.relatedTarget)
      var set_to_status = button.data('to')
      vm.to_status = set_to_status
    })
    $('#processApplication'+this.application).on('hidden.bs.modal', function (e) {
      var modal = $(this);
      modal.find('p.lead').removeClass('d-none')
      modal.find('p.lead.message').addClass('d-none')
      modal.find('.modal-footer button.action').removeClass('d-none')
      modal.find('.modal-footer button.close').addClass('d-none')
      modal.find('.modal-footer').removeClass('d-none')
      modal.find('.spinner-border').addClass('d-none')
      vm.to_status = null
    })
  }
    }
</script>
