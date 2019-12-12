<template>
    <section class="job-card">
        <header>
            
            <img :src="this.job_details.photo_url" :alt="this.job_details.company" />
            
            <p><small>{{ this.job_details.company }}</small></p>
            <h5>{{ this.job_details.title }}</h5>
        </header>
        <footer>
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
            <small><a :href=this.job_details.url>View Job <i class="material-icons">arrow_forward</i></a></small>
        </footer>
    </section>
</template>

<script>
    export default {
        props: ['job'],
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
