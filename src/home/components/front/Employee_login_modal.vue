<template>
    <!-- Modal Component -->
    <b-modal id="employee-login-modal" centered title="Login" ok-title="Enter">
        <b-container fluid>
            <b-row class="my-1">
                <b-col sm="2"><label for="form-employee-username">Username:</label></b-col>
                <b-col sm="10">
                    <b-form-input id="form-employee-username"
                                  type="text"
                                  placeholder="Enter your name"
                                  v-model="login_form.username">
                    </b-form-input>
                </b-col>
            </b-row>
            <b-row class="my-1">
                <b-col sm="2"><label for="form-employee-password">Password:</label></b-col>
                <b-col sm="10">
                    <b-form-input id="form-employee-password"
                                  type="password"
                                  placeholder="Enter your password"
                                  v-model="login_form.password">
                    </b-form-input>
                </b-col>
            </b-row>
        </b-container>
    </b-modal>
</template>

<script>
    export default {
        name: "Employee_login_modal",
        data() {
            return {
                login_form: {
                    username: '',
                    password: ''
                }
            }
        }
    }
</script>

<style scoped>

</style>
