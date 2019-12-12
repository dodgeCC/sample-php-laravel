<template>
    <div class="job-card job-card-row">
        <section>
            <header>
                <img :src="this.job_details.photo_url" :alt="this.job_details.company" />
                
                <h5>{{ this.job_details.title }}</h5>

                <ul>
                    <li>
                        <small>
                            <i class="material-icons">place</i>
                            <span>{{ this.job_details.location }}</span>
                        </small>
                    </li>
                    <li>
                        <small>
                            <i class="material-icons">schedule</i>
                            <span>{{ this.job_details.type }}</span>
                        </small>
                    </li>
                    <li>
                        <small>
                            <i class="material-icons">attach_money</i>
                            <span>{{ this.job_details.wage }}</span>
                        </small>
                    </li>
                </ul>
            </header>
            <footer>
                <small><a :href=this.job_details.url class="no-stretch">View Job <i class="material-icons">arrow_forward</i></a></small>
                <small>
                <a v-if=this.application class="no-stretch">Applied {{ this.application }}</a>
                <a v-else-if=this.apply :href=this.job_details.apply_url class="no-stretch">Apply</a>
                </small>
            </footer>
        </section>
    </div>
</template>

<script>
    export default {
        props: ['job', 'apply', 'application'],
        data: function () {
          return {
            job_details: null
          }
        },
        created: function() {
          this.job_details = JSON.parse(this.job)
      }
    }
</script>
