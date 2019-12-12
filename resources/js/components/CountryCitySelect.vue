<template>
  <div><country-select :countries=JSON.parse(this.countries) :country_id=this.country_id :cities_route=this.cities_route v-on:update-cities=updateCities></country-select>
  <city-select :cities=this.select_cities :city_id=this.selected_city_id></city-select></div>
</template>

<script>
    export default {
        props: ['countries', 'country_id', 'cities', 'city_id', 'cities_route'],
    data: function () {
    return {
      select_cities: [],
      selected_city_id: null
    }
  },
  methods: {
    updateCities: function(selected_country_id){
      var vm = this
      $.post(this.cities_route, { country_id: selected_country_id }, function(response){
        vm.select_cities = response.cities
        vm.selected_city_id = null
      })
    }
  },
  created: function(){
    this.select_cities = JSON.parse(this.cities)
    this.selected_city_id = this.city_id
  }
    }
</script>
