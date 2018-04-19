<template>
    <div>
        <button @click="topFunction()" id="scroll-top-btn" title="Go to top" :style="{display: display}">
            <i class="fa fa-angle-up"></i>Top
        </button>
    </div>
</template>

<script>
    export default {
        name: "Scroll_top_btn",
        data: function () {
            return {
                display: 'none'
            }
        },
        mounted() {
            const that = this;
            window.addEventListener("scroll", function () {
                let display = (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) ? "block": "none";
                that.setScrollDisplay(display);
            });
        },
        methods: {
            setScrollDisplay(display) {
                this.display = display
            },
            topFunction() {
                document.body.scrollTop = 0; // For Safari
                document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
            }
        }
    }
</script>

<style scoped>
    #scroll-top-btn {
        position: fixed; /* Fixed/sticky position */
        bottom: 45px; /* Place the button at the bottom of the page */
        right: 25px; /* Place the button 30px from the right */
        z-index: 99; /* Make sure it does not overlap */
        border: none; /* Remove borders */
        outline: none; /* Remove outline */
        background-color: #2A2E39; /* Set a background color */
        color: white; /* Text color */
        cursor: pointer; /* Add a mouse pointer on hover */
        padding: 10px; /* Some padding */
        border-radius: 5px; /* Rounded corners */
        font-size: 18px; /* Increase font size */
    }

    #scroll-top-btn:hover {
        background-color: #555; /* Add a dark-grey background on hover */
    }
</style>
