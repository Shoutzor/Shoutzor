<template>
    <nav id="navbar-left" class="d-md-block col-md-4 col-lg-2 sidebar collapse">
        <div id="navbar-left-menu" class="position-sticky">
            <span class="sidebar-heading d-flex justify-content-between align-items-center px-3 mb-1 text-muted">Music zone</span>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <router-link :to="{name: 'dashboard'}" class="nav-link">
                        <b-icon-house-fill></b-icon-house-fill>
                        Dashboard
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link :to="{name: 'history'}" class="nav-link">
                        <b-icon-clock-history></b-icon-clock-history>
                        History
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link :to="{name: 'popular'}" class="nav-link">
                        <b-icon-star></b-icon-star>
                        Most Played
                    </router-link>
                </li>
            </ul>
            <template v-if="isAuthenticated">
                <span class="sidebar-heading d-flex justify-content-between align-items-center px-3 mb-1 mt-md-5 text-muted">Your zone</span>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <router-link :to="{name: 'upload'}" class="nav-link">
                            <b-icon-cloud-upload></b-icon-cloud-upload>
                            Upload manager
                        </router-link>
                    </li>
                </ul>
            </template>
        </div>
    </nav>
</template>

<script>
export default {
    name: 'the-menu',
    computed: {
        isAuthenticated() {
            return this.auth.isAuthenticated;
        }
    }
}
</script>
