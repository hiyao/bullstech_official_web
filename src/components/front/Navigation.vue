<template>
    <div>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand logo" href="/">Bulls Tech</a>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#" v-b-modal.modal-center>
                        <i class="fa fa-fw fa-user-o"></i>Register
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

    <!-- Modal Component -->
    <b-modal id="modal-center" centered title="Bootstrap-Vue">
        <p class="my-4">Vertically centered modal!</p>
    </b-modal>
    </div>
</template>

<script>
    export default {
        name: "Navigation"
    }
</script>

<style scoped>
    nav.navbar .container {
        height: 40px;
    }

    #mainNav .navbar-brand {
        width: 100%;
    }

    .navbar-nav {
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
        background: url(../../assets/front/images/logo.png) no-repeat center center;
        background-size: 145px;
    }
</style>
