<template>
    <nav id="navbar-left" class="d-md-block col-12 col-md-4 col-lg-2 sidebar collapse">
        <div id="navbar-left-menu" class="position-sticky">
            <span class="sidebar-heading d-flex justify-content-between align-items-center px-3 mb-1 text-muted">App zone</span>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <router-link :to="{name: 'dashboard'}" class="nav-link">
                        <b-icon-house-fill class="icon" />
                        <span class="text ps-1">Dashboard</span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link :to="{name: 'history'}" class="nav-link">
                        <b-icon-clock-history class="icon" />
                        <span class="text ps-1">History</span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link :to="{name: 'popular'}" class="nav-link">
                        <b-icon-star class="icon" />
                        <span class="text ps-1">Most Played</span>
                    </router-link>
                </li>
            </ul>
            <template v-if="isAuthenticated">
                <span class="sidebar-heading d-flex justify-content-between align-items-center px-3 mb-1 mt-md-5 text-muted">User zone</span>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <router-link :to="{name: 'upload'}" class="nav-link">
                            <b-icon-cloud-upload class="icon" />
                            <span class="text ps-1">Upload manager</span>
                        </router-link>
                    </li>
                </ul>
            </template>
        </div>
    </nav>
</template>

<script>
import "./TheMenu.scss";

export default {
    name: 'the-menu',
    computed: {
        isAuthenticated() {
            return this.auth.isAuthenticated;
        }
    }
}
</script>
