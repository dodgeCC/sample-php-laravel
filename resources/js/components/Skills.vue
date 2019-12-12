<template>
<div>
  <div class="card">
        <div class="card-header">
        <div v-if='saving' class="spinner-border spinner-border-sm float-right" role="status">
          <span class="sr-only">Saving...</span>
        </div>
        Add Skill
        </div> 
        <div class="card-body">
          <form @submit.prevent="addSkill" role="form">
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
                  Add
                </button>
              </div>
            </div>
          </form>
          <p v-if='error' class="">{{ error_message }}</p>
        </div>
      </div>
      <div class="">
        <skill v-for="skill in the_skills" :key="skill.id" :skill="skill" v-on:skill-removed=removeSkill></skill>
      </div>
  </div>
</template>

<script>
  export default {
    props: ['action', 'skills'],
    data: function () {
      return {
        the_skills: JSON.parse(this.skills),
        name: '',
        years: null,
        months: null,
        saving: false,
        error: false,
        error_message: ''
      }
    },
    methods: {
      addSkill: function(){
        var vm = this
        vm.saving = true
        vm.error = false
        $.post(vm.action, { name: vm.name, years: vm.years, months: vm.months }, function(response){
          vm.saving = false
          if(response.status=='success'){
            vm.the_skills = JSON.parse(response.skills)
            vm.name = ''
            vm.years = null
            vm.months = null
          }else{
            vm.error_message = response.message
            vm.error = true
          }
        })
      },
      removeSkill: function(skill_id){
        this.the_skills = this.the_skills.filter(skill => skill.id != skill_id)
      }
    }
  }
</script>
