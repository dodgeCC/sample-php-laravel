<template>
<div class="card">
  <div class="card-header">
    <div class="float-right">
      <button v-if="update_mode" @click="update_mode = false" class="btn btn-secondary btn-sm">cancel</button>
      <button v-else-if="delete_mode" @click="delete_mode = false" class="btn btn-secondary btn-sm">cancel</button>
      <template v-else>
      <button @click="update_mode = true" class="btn btn-primary btn-sm">edit</button>
      <button @click="delete_mode = true" class="btn btn-danger btn-sm">delete</button>
      </template>
    </div>
    <div v-if='saving' class="spinner-border spinner-border-sm" role="status">
      <span class="sr-only">Saving...</span>
    </div>
  </div> 
  <div class="card-body">
    <template v-if="update_mode">
      <form @submit.prevent="updateExperience" role="form">
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
              Update
            </button>
          </div>
        </div>
      </form>
      <p v-if='error' class="">{{ error_message }}</p>
    </template>
    <template v-else-if="delete_mode">
      <form @submit.prevent="deleteExperience" role="form">
        <p class="text-center">Delete this experience?</p>
        <div class="form-group">
          <div class="col-md-6 offset-md-5">
            <button type="submit" class="btn btn-danger">
              Delete
            </button>
          </div>
        </div>
      </form>
    </template>
    <template v-else>
      <h5 class="card-title text-muted font-weight-bolder mb-0"><small>{{ role }}</small> -  {{ company }}</h5>
      <h3 class="mb-0"><small>{{ start_date }}</small><small v-if='end_date'> - {{ end_date }}</small></h3>
      <p v-if='description'>{{ description }}</p>
    </template>
  </div>
</div>
</template>

<script>
  export default {
    props: ['experience'],
    data: function () {
      return {
        the_experience: this.experience,
        role: this.experience.role,
        company: this.experience.company,
        start: this.experience.start,
        start_date: this.experience.start_date,
        end: this.experience.end,
        end_date: this.experience.end_date,
        description: this.experience.description,
        update_mode: false,
        updated: false,
        saving: false,
        delete_mode: false,
        error: false,
        error_message: ''
      }
    },
    watch: {
      update_mode: function (val) {
        if(!val && !this.updated){
          this.role = this.the_experience.role
          this.company = this.the_experience.company
          this.description = this.the_experience.description
          this.start = this.the_experience.start
          this.end = this.the_experience.end
          this.error_message = ''
          this.error = false
        }
        this.updated = false
      }
    },
    methods: {
      updateExperience: function(){
        var vm = this
        vm.saving = true
        vm.error = false
        $.ajax({
            url: vm.the_experience.update,
            type: 'PUT',
            data: { role: vm.role, company: vm.company, description: vm.description, start: vm.start, end: vm.end },
            success: function(response) {
                vm.saving = false
                if(response.status=='success'){
                  vm.updated = true
                  vm.the_experience = JSON.parse(response.experience)
                  vm.role = vm.the_experience.role
                  vm.company = vm.the_experience.company
                  vm.description = vm.the_experience.description
                  vm.start = vm.the_experience.start
                  vm.end = vm.the_experience.end
                  vm.start_date = vm.the_experience.start_date
                  vm.end_date = vm.the_experience.end_date
                  vm.update_mode = false
                }else{
                  vm.error_message = response.message
                  vm.error = true
                }
            }
        })
      },
      deleteExperience: function(){
        var vm = this
        vm.saving = true
        vm.error = false
        $.ajax({
            url: vm.the_experience.delete,
            type: 'DELETE',
            success: function(response) {
              if(response.status=='success'){
                vm.$emit('experience-removed', vm.the_experience.id)
              }else{
                vm.saving = false
                vm.error = true
              }
            }
        })
      }
    }
  }
</script>
