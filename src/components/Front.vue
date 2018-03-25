<template>
    <div>
        <Navigation></Navigation>
        <Bg_cover1></Bg_cover1>
        <Bg_cover2 :company_name="company_name"></Bg_cover2>
        <Company_map></Company_map>
        <Scroll_top_btn></Scroll_top_btn>
        <Footer :company_name="company_name"></Footer>
    </div>
</template>

<script>
    import Navigation from '@/components/front/Navigation'
    import Bg_cover1 from '@/components/front/Bg_cover1'
    import Bg_cover2 from '@/components/front/Bg_cover2'
    import Scroll_top_btn from '@/components/common/Scroll_top_btn'
    import Company_map from '@/components/front/Company_map'
    import Footer from '@/components/front/Footer'

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
            Footer
        }
    }
</script>

<style scoped>

</style>
