Vue.component('update-address', {
    props: ['user'],

    data() {
        return {
            form: new SparkForm({
                address: ''
            })
        };
    },

    mounted() {
        this.form.address = this.user.address;
    },

    methods: {
        update() {
            Spark.put('/settings/profile/address', this.form)
                .then(response => {
                    Bus.$emit('updateUser');
                });
        }
    }
});
