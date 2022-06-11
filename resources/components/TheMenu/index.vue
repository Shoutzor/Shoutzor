<template>
    <nav id="navbar-left" class="fixed d-lg-block sidebar collapse">
        <div id="navbar-left-menu">
            <span class="sidebar-heading d-flex justify-content-between align-items-center px-3 mb-1 text-muted">Music zone</span>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <router-link :to="{name: 'dashboard'}" class="nav-link">
                        <b-icon-house-fill></b-icon-house-fill>
                        Dashboard
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link :to="{name: 'dashboard'}" class="nav-link">
                        <b-icon-clock-history></b-icon-clock-history>
                        History
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link :to="{name: 'dashboard'}" class="nav-link">
                        <b-icon-star></b-icon-star>
                        Most Played
                    </router-link>
                </li>
            </ul>
            <span v-if="isAuthenticated" class="sidebar-heading d-flex justify-content-between align-items-center px-3 mb-1 text-muted">Your zone</span>
            <ul v-if="isAuthenticated" class="nav flex-column">
                <li class="nav-item">
                    <router-link :to="{name: 'dashboard'}" class="nav-link">
                        <b-icon-cloud-upload></b-icon-cloud-upload>
                        Upload manager
                    </router-link>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
export default {
    name: 'the-menu',

    props: {
        isAuthenticated: {
            type: Boolean,
            required: false,
            default: false
        },
    }
}
</script>
