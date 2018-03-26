<template>
    <!-- Modal Component -->
    <b-modal id="modal-login" centered title="Login" ok-title="Enter">
        <b-container fluid>
            <b-row class="my-1">
                <b-col sm="2"><label for="input-small">Username:</label></b-col>
                <b-col sm="10">
                    <b-form-input id="input-small" size="sm" type="text" placeholder="Enter your name"></b-form-input>
                </b-col>
            </b-row>
            <b-row class="my-1">
                <b-col sm="2"><label for="input-small">Password:</label></b-col>
                <b-col sm="10">
                    <b-form-input id="input-small" size="sm" type="password"
                                  placeholder="Enter your password"></b-form-input>
                </b-col>
            </b-row>
        </b-container>
    </b-modal>
</template>

<script>
    export default {
        name: "Login_modal"
    }
</script>

<style scoped>

</style>
