<template>
  <div class="form-group">
  <label for="selected_country_id">Country</label>
  <select v-model="selected_country_id" name="country_id" v-on:change="$emit('update-cities', selected_country_id)" class="form-control">
      <option disabled value="">Select country</option>
      <option v-for="country in this.countries" :value="country.id">{{ country.name }}</option>
  </select>
  </div>
</template>

<script>
    export default {
        props: ['countries', 'country_id', 'cities_route'],
    data: function () {
    return {
      selected_country_id: null
    }
  },
  created: function(){
    this.selected_country_id = this.country_id
  }
    }
</script>
