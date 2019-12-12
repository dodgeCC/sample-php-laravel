<update-address :user="user" inline-template>
    <div class="card">
        <div class="card-header">Address</div>

        <div class="card-body">
            <!-- Success Message -->
            <div class="alert alert-success" v-if="form.successful">
                Your address has been updated!
            </div>

            <form role="form">
                <!-- Address -->
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Address</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" name="address"
                               v-model="form.address"
                               :class="{'is-invalid': form.errors.has('address')}">

                        <span class="invalid-feedback" v-show="form.errors.has('address')">
                            @{{ form.errors.get('address') }}
                        </span>
                    </div>
                </div>

                <!-- Update Button -->
                <div class="form-group">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary"
                                @click.prevent="update"
                                :disabled="form.busy">

                            Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</update-address>
