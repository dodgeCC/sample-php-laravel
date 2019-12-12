<template>
<div>
  <div class="card">
        <div class="card-header">
        <div v-if='saving' class="spinner-border spinner-border-sm float-right" role="status">
          <span class="sr-only">Saving...</span>
        </div>
        Add Experience
        </div> 
        <div class="card-body">
          <form @submit.prevent="addExperience" role="form">
            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right">Role</label> 
              <div class="col-md-6">
                <input type="text" v-model='role' class="form-control"> 
              </div>
            </div> 
            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right">Company</label> 
              <div class="col-md-6">
                <input type="text" v-model='company' class="form-control"> 
              </div>
            </div> 
            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right">Description</label> 
              <div class="col-md-6">
                <textarea v-model='description' class="form-control"></textarea>
              </div>
            </div> 
            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right">Start date</label> 
              <div class="col-md-6">
                <input type="date" v-model='start' class="form-control"> 
              </div>
            </div> 
            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right">End date</label> 
              <div class="col-md-6">
                <input type="date" v-model='end' class="form-control"> 
              </div>
            </div> 
            <div class="form-group">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                  Add
                </button>
              </div>
            </div>
          </form>
          <p v-if='error' class="">{{ error_message }}</p>
        </div>
      </div>
      <div class="">
        <experience v-for="experience in the_experiences" :key="experience.id" :experience="experience" v-on:experience-removed=updateExperiences></experience>
      </div>
  </div>
</template>

<script>
  export default {
    props: ['action', 'experiences'],
    data: function () {
      return {
        the_experiences: JSON.parse(this.experiences),
        role: '',
        company: '',
        description: '',
        start: null,
        end: null,
        saving: false,
        error: false,
        error_message: ''
      }
    },
    methods: {
      addExperience: function(){
        var vm = this
        vm.saving = true
        vm.error = false
        $.post(vm.action, { role: vm.role, company: vm.company, description: vm.description, start: vm.start, end: vm.end }, function(response){
          vm.saving = false
          if(response.status=='success'){
            vm.the_experiences = JSON.parse(response.experiences)
            vm.role = ''
            vm.company = ''
            vm.description = ''
            vm.start = null
            vm.end = null
          }else{
            vm.error_message = response.message
            vm.error = true
          }
        })
      },
      updateExperiences: function(experience_id){
        this.the_experiences = this.the_experiences.filter(experience => experience.id != experience_id)
      }
    }
  }
</script>
