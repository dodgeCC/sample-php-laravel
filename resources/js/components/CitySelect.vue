<template>
  <div class="form-group">
  <label for="city_id">City</label>
  <select :value="city_id" name="city_id" class="form-control">
      <option value="">Select city</option>
      <option v-for="city in this.cities" :value="city.id" :key="city.id">{{ city.name }}</option>
  </select>
  </div>
</template>

<script>
    export default {
        props: ['cities', 'city_id'],
    data: function () {
    return {
      selected_city_id: null
    }
  },
  created: function(){
    this.selected_city_id = this.city_id
  }
    }
</script>
