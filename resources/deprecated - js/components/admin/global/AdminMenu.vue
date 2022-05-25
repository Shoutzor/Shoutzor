<template>
    <div class="navbar-expand-md">
        <div id="navbar-menu" class="collapse navbar-collapse">
            <div class="navbar navbar-light">
                <div class="container-xl">
                    <ul class="navbar-nav">
                        <router-link
                            v-slot="{ href, navigate, isExactActive }"
                            :to="{name: 'admin-dashboard'}"
                        >
                            <li :class="['nav-item', isExactActive && 'active']">
                                <a :href="href"
                                   class="nav-link"
                                   @click="navigate">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <chart-bar-icon class="icon"></chart-bar-icon>
                                    </span>
                                    <span class="nav-link-title">
                                      Dashboard
                                    </span>
                                </a>
                            </li>
                        </router-link>
                        <router-link
                            v-slot="{ href, navigate, isExactActive }"
                            :to="{name: 'admin-users'}"
                        >
                            <li :class="['nav-item', isExactActive && 'active']">
                                <a :href="href"
                                   class="nav-link"
                                   @click="navigate">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <users-icon class="icon"></users-icon>
                                    </span>
                                    <span class="nav-link-title">
                                      Users
                                    </span>
                                </a>
                            </li>
                        </router-link>
                        <router-link
                            v-slot="{ href, navigate, isExactActive }"
                            :to="{name: 'admin-roles-list'}"
                        >
                            <li :class="['nav-item', isExactActive && 'active']">
                                <a :href="href"
                                   class="nav-link"
                                   @click="navigate">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <key-icon class="icon"></key-icon>
                                    </span>
                                    <span class="nav-link-title">
                                      Roles
                                    </span>
                                </a>
                            </li>
                        </router-link>
                        <router-link
                            v-slot="{ href, navigate, isExactActive }"
                            :to="{name: 'admin-modules'}"
                        >
                            <li :class="['nav-item', isExactActive && 'active']">
                                <a :href="href"
                                   class="nav-link"
                                   @click="navigate">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <ThreedCubeSphereIcon class="icon"></ThreedCubeSphereIcon>
                                    </span>
                                    <span class="nav-link-title">
                                      Modules
                                    </span>
                                </a>
                            </li>
                        </router-link>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "admin-menu"
};
</script>
