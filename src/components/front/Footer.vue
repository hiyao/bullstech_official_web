<template>
    <footer class="landing-footer">
        <div class="container">
            <div class="text-center">
                <small>{{ msg }}</small>
            </div>
        </div>
    </footer>
</template>

<script>
    export default {
        name: "Footer",
        props: ['company_name'],
        data() {
            return {
                msg: "Copyright © " + this.company_name + " 2018"
            }
        }
    }
</script>

<style scoped>
    footer.landing-footer {
        position: fixed;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 36px;
        background-color: #2A2E39;
        line-height: 36px;
        color: #84858d;
    }
</style>
