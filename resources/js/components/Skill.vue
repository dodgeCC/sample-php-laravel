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
      <form @submit.prevent="updateSkill" role="form">
        <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right">Name</label> 
          <div class="col-md-6">
            <input type="text" v-model='name' class="form-control"> 
          </div>
        </div> 
        <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right">Years</label> 
          <div class="col-md-6">
            <input type="number" min="0" v-model='years' class="form-control"> 
          </div>
        </div> 
        <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right">Months</label> 
          <div class="col-md-6">
            <input type="number" min="0" max="11" v-model='months' class="form-control"> 
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
      <form @submit.prevent="deleteSkill" role="form">
        <p class="text-center">Delete this skill?</p>
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
      <h5 class="card-title text-muted font-weight-bolder mb-0"><small>{{ name }}</small></h5>
      <h3 class="mb-0"><small v-if='interval'>{{ interval }}</small></h3>
    </template>
  </div>
</div>
</template>

<script>
  export default {
    props: ['skill'],
    data: function () {
      return {
        the_skill: this.skill,
        name: this.skill.name,
        years: this.skill.years,
        months: this.skill.months,
        interval: this.skill.interval,
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
          this.name = this.the_skill.name
          this.years = this.the_skill.years
          this.months = this.the_skill.months
          this.error_message = ''
          this.error = false
        }
        this.updated = false
      }
    },
    methods: {
      updateSkill: function(){
        var vm = this
        vm.saving = true
        vm.error = false
        $.ajax({
            url: vm.the_skill.update,
            type: 'PUT',
            data: { name: vm.name, years: vm.years, months: vm.months },
            success: function(response) {
                vm.saving = false
                if(response.status=='success'){
                  vm.updated = true
                  vm.the_skill = JSON.parse(response.skill)
                  vm.name = vm.the_skill.name
                  vm.years = vm.the_skill.years
                  vm.months = vm.the_skill.months
                  vm.interval = vm.the_skill.interval
                  vm.update_mode = false
                }else{
                  vm.error_message = response.message
                  vm.error = true
                }
            }
        })
      },
      deleteSkill: function(){
        var vm = this
        vm.saving = true
        vm.error = false
        $.ajax({
            url: vm.the_skill.delete,
            type: 'DELETE',
            success: function(response) {
              if(response.status=='success'){
                vm.$emit('skill-removed', vm.the_skill.id)
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
