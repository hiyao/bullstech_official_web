<template>
    <div>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand logo" href="/">Bulls Tech</a>

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#" v-b-modal.under-construction-modal>
                            <i class="fa fa-fw fa-user-o"></i>Login
                        </a>
                    </li>
                    <!--            <li class="nav-item">-->
                    <!--                <a class="nav-link" href="login.html">-->
                    <!--                    <i class="fa fa-fw fa-sign-in"></i>Login</a>-->
                    <!--            </li>-->
                    <!-- <li class="nav-item">
                      <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
                        <i class="fa fa-fw fa-sign-out"></i>Logout</a>
                    </li> -->
                </ul>
            </div><!--container-->
        </nav>
    </div>
</template>

<script>
    export default {
        name: "Navigation"
    }
</script>

<style scoped>
    nav.navbar .container {
        height: 35px;
    }

    #mainNav .navbar-brand {
        width: 100%;
    }

    .navbar-nav {
        position: absolute;
        right: 30px;
        flex-direction: unset;
    }

    .navbar-nav .nav-link {
        padding-left: 10px;
    }

    .navbar-nav .nav-link:focus {
        outline: none;
    }

    .navbar .logo {
        text-indent: -999em;
        background: url(../../../company/images/logo.png) no-repeat center center;
        background-size: 145px;
    }
</style>
