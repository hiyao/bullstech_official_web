<template>
    <div class="bg-cover2">
        <div class="contact-box">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-3"><h2>Contact</h2></div>
                    <div class="col-md-9">
                        <h5>{{ company_name }}</h5>
                        <ul>
                            <li><span class="icon-address"></span> {{ address }}</li>
                            <li><span class="icon-phone"></span> {{ phone }}</li>
                            <li><span class="icon-fax"></span> {{ fax }}</li>
                        </ul>
                    </div>
                </div>
            </div><!--container-->
        </div>
    </div>
</template>

<script>
    export default {
        name: "Bg_cover2",
        props: ['company_name'],
        data() {
            return {
                address: '37 Limin Road Nanzi District 81165 Kaohsiung, Taiwan',
                phone: '8867-351-8853',
                fax: '8867-351-8873'
            }
        }
    }
</script>

<style scoped>
    .bg-cover2 {
        background: url(../../assets/front/images/bg-cover2.png) no-repeat center center;
        background-size: cover;
        padding-top: 310px;
    }

    .contact-box {
        background: url(../../assets/front/images/logo-bg.png) no-repeat 1200px bottom rgba(40, 42, 49, 0.9);
        background-size: 120px;
        color: rgba(255, 255, 255, 0.8);
    }

    .contact-box h2 {
        font-family: "SF Display";
        font-weight: 100;
        text-align: center;
    }

    .contact-box h5 {
        font-family: "SF Text";
        font-weight: 600;
        font-size: 17px;
        margin-top: 60px;
        margin-bottom: 30px;
    }

    .contact-box ul {
        list-style: none;
        padding: 0;
        margin-bottom: 60px;
    }

    .contact-box ul span {
        margin-right: 15px;
    }

    .contact-box ul li {
        line-height: 40px;
        font-size: 15px;
    }

    .icon-address {
        display: block;
        background: url(../../assets/front/images/address.png) no-repeat;
        background-size: 20px;
        width: 20px;
        height: 20px;
        float: left;
        margin-top: 5px;
    }

    .icon-phone {
        display: block;
        background: url(../../assets/front/images/phone.png) no-repeat;
        background-size: 18px;
        width: 20px;
        height: 20px;
        float: left;
        margin-top: 5px;
    }

    .icon-fax {
        display: block;
        background: url(../../assets/front/images/fax.png) no-repeat;
        background-size: 20px;
        width: 20px;
        height: 20px;
        float: left;
        margin-top: 12px;
    }
</style>
