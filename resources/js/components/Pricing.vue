<template>
<div>
    <div class="row">
            <div class="col-12">
                <form class="d-flex align-items-center justify-content-center mb-4">
                    <span>
                        Monthly
                    </span>
                    <div class="custom-control custom-switch custom-switch-dark mx-3">
                        <input type="checkbox" class="custom-control-input" v-on:change="togglePlans" id="billingSwitch" data-toggle="price" data-target=".price">
                        <label class="custom-control-label" for="billingSwitch"></label>
                    </div>
                    <span>
                        Annually
                    </span>
                </form>
            </div>
        </div>
        <div class="row mb-6">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="pricing-card">
                    <div class="card-body">
                        <h4 class="card-title">Single Job</h4>
                        
                        <p>Only need one Job, we have you covered</p>
                        
                        <ul class="list-check">
                            <li class="list-check-item">1 30 day Job Post</li>
                            <li class="list-check-item">PAYG</li>
                            <li class="list-check-item">Applicant Tracking</li>
                            <li class="list-check-item">Candidate Matching</li>
                            <li class="list-check-item">Applicant Pipeline</li>
                        </ul>
                        <h2 class="font-weight-bold mb-3">£{{ this.pricing['Monthly'][0] }} <span class="font-weight-bold fs-20">per job</span></h2>
                        <p class="text-muted mb-4">job live for 30 days and an option to renew for &pound;39 after 30 days</p>
                        <a :href=this.route class="btn btn-primary">Buy one job</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="pricing-card">
                    <div class="card-body">
                        <h4 class="card-title">Growth</h4>
                        <p>Best for Startups &amp; SME for up to 10 jobs per month</p>

                        <ul class="list-check">
                            <li class="list-check-item">10 Jobs Per Month</li>
                            <li class="list-check-item">Applicant Tracking</li>
                            <li class="list-check-item">Job Marketing</li>
                            <li class="list-check-item">Candidate Matching</li>
                            <li class="list-check-item">Applicant Pipeline</li>
                        </ul>
                        <h2 v-if="this.the_mode=='monthly'" class="font-weight-bold mb-3">£{{ this.pricing['Monthly'][1] }} <span class="font-weight-bold fs-20">/mo</span></h2>
                        <h2 v-else class="font-weight-bold mb-3">£{{ this.pricing['Annually'][1] }} <span class="font-weight-bold fs-20">/yr</span></h2>
                        <p class="text-muted mb-4">Get 2 months free with an annual subscription plan</p>
                        <a :href=this.route class="btn btn-primary">Subscribe to Growth plan</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="pricing-card">
                    <div class="card-body">
                        <h4 class="card-title">Enterprise</h4>
                        <p>Enterprise hiring for unlimited jobs per month</p>

                        <ul class="list-check">
                            <li class="list-check-item-checked">All Growth Features</li>
                            <li class="list-check-item">Unlimited Jobs</li>
                            <li class="list-check-item">Multiple Users</li>
                            <li class="list-check-item">Dedicated Job Marketing</li>
                            <li class="list-check-item">Company Job Page</li>
                            <li class="list-check-item">ATS Integration</li>
                        </ul>
                        <h2 v-if="this.the_mode=='monthly'" class="font-weight-bold mb-3">£{{ this.pricing['Monthly'][2] }} <span class="font-weight-bold fs-20">/mo</span></h2>
                        <h2 v-else class="font-weight-bold mb-3">£{{ this.pricing['Annually'][2] }} <span class="font-weight-bold fs-20">/yr</span></h2>
                        <p class="text-muted mb-4">Get 2 months free with an annual subscription plan</p>
                        <a :href=this.route class="btn btn-primary">Subscribe to Enterprise plan</a>
                    </div>
                </div>
            </div>
        </div>
        </div>
</template>

<script>
    export default {
        props: ['data', 'mode', 'route'],
        data: function () {
    return {
      the_mode: this.mode,
      pricing: null
    }
  },
        methods: {
            togglePlans: function(){
              this.the_mode = (this.the_mode=='monthly') ? 'annually':'monthly'
            }
          },
          created: function(){
        this.pricing = JSON.parse(this.data)
      }
    }
</script>
