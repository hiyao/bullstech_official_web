<template>
    <div class="bg-cover parallax">
        <div class="container">
            <h2 class="col-md-4 slogan">
                {{ message }}
                <br><br>
                <b-button size="" variant="primary"><i class="fa fa-fw fa-hand-o-right"></i> Get More</b-button>
            </h2>
        </div>

        <div class="content1"></div>
    </div>
</template>

<script>
    export default {
        name: "Bg_cover1",
        data() {
            return {
                message: "Work with BULLS, make your works working."
            }
        }
    }
</script>

<style scoped>
    .bg-cover {
        background: url(../../assets/front/images/bg-cover.png) no-repeat center center;
        background-size: cover;
    }

    .bg-cover .slogan {
        font-family: "SF Display";
        font-weight: 100;
        color: rgba(255, 255, 255, 0.8);
        padding-top: 300px;
        padding-bottom: 150px;
    }

    .content1 {
        background: url(../../assets/front/images/content1.png) no-repeat center bottom;
        background-size: cover;
        min-height: 400px;
    }

    .parallax {
        /* Create the parallax scrolling effect */
        background-attachment: fixed !important;
    }

    /* Turn off parallax scrolling for tablets and phones. Increase the pixels if needed */
    @media only screen and (max-device-width: 1366px) {
        .parallax {
            background-attachment: scroll;
        }
    }
</style>
