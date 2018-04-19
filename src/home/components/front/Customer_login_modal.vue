<template>
    <!-- Modal Component -->
    <b-modal id="customer-login-modal" centered title="System message" ok-title="Enter">
        <b-form @submit="onSubmit" @reset="onReset">
            <b-form-row class="my-1">
                <h2>Hi, there:</h2>
                <h4>If you want get more information, please enter your email and region, thanks.</h4>
            </b-form-row>
            <b-form-group id="customer-form-group-email"
                          label="Email address:"
                          label-for="input-email"
                          description="">
                <b-form-input id="input-email"
                              size="sm"
                              type="text"
                              placeholder="Enter your email"
                              v-model="customer_form.email">
                </b-form-input>
            </b-form-group>
            <b-form-group id="customer-form-group-email"
                          label="Region:"
                          description="">
                <radio v-for="region in regions_data" :value="region.name" :key="region.name" v-model="customer_form.region">
                    {{ region.name }}
                </radio>
            </b-form-group>
        </b-form>
    </b-modal>
</template>

<script>
    export default {
        name: "Customer_login_modal",
        data() {
            return {
                regions_data: [
                    { name: 'Africa' },
                    { name: 'Mid East' },
                    { name: 'New Zealand' },
                    { name: 'Asia' },
                    { name: 'Europe' },
                    { name: 'N.America' },
                    { name: 'S.America' },
                    { name: 'Russia' },
                    { name: 'Australia' },
                    { name: 'Oceania' },
                    { name: 'Other' }
                ],
                customer_form: {
                    email: '',
                    region: ''
                }
            }
        },
        methods: {
            onSubmit(){

            },
            onReset(){

            }
        }
    }
</script>

<style scoped>
    .checkbox-component > input + label > .input-box,
    .radio-component > input + label > .input-box {
        border-color: #4d82ff;
        background: #4d82ff;
    }
    .checkbox-component > input + label > .input-box > .input-box-tick > path {
        stroke: #fff;
    }
    .radio-component > input + label > .input-box > .input-box-circle {
        background: #fff;
    }
</style>
