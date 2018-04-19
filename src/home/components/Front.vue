<template>
    <div>
        <Navigation></Navigation>
        <Bg_cover1></Bg_cover1>
        <Bg_cover2 :company_name="company_name"></Bg_cover2>
        <Company_map></Company_map>
        <Scroll_top_btn></Scroll_top_btn>
        <Footer :company_name="company_name"></Footer>
        <!--<Employee_login_modal></Employee_login_modal>-->
        <!--<Customer_login_modal></Customer_login_modal>-->
        <Under_construction_modal></Under_construction_modal>
    </div>
</template>

<script>
    import Navigation from '@home/components/front/Navigation'
    import Bg_cover1 from '@home/components/front/Bg_cover1'
    import Bg_cover2 from '@home/components/front/Bg_cover2'
    import Scroll_top_btn from '@home/components/common/Scroll_top_btn'
    import Company_map from '@home/components/front/Company_map'
    import Footer from '@home/components/front/Footer'
    // import Customer_login_modal from '@home/components/front/Customer_login_modal'
    // import Employee_login_modal from '@home/components/front/Employee_login_modal'
    import Under_construction_modal from '@home/components/front/Under_construction_modal'

    export default {
        name: "front",
        data() {
            return {
                company_name: 'Bulls Technology Co., Ltd.'
            }
        },
        components: {
            Navigation,
            Bg_cover1,
            Bg_cover2,
            Company_map,
            Scroll_top_btn,
            Footer,
            // Employee_login_modal,
            // Customer_login_modal,
            Under_construction_modal
        }
    }
</script>

<style scoped>

</style>
