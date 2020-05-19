<template>
    <div class="navbar-expand-md">
        <div class="navbar collapse navbar-collapse navbar-light" id="navbar-menu">
            <div class="container-xl">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="./index.html" >
                            <span class="nav-link-title">Home</span>
                        </a>
                    </li>
                </ul>
                <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last">
                    <header-search></header-search>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import HeaderSearch from "./HeaderSearch";

    export default {
        name: 'headerMenu',
        components: {
            HeaderSearch
        }
    }
</script>
