<template>
    <div class="navbar-expand-md">
        <div class="collapse navbar-collapse" id="navbar-menu">
            <div class="navbar navbar-light">
                <div class="container-xl">
                    <ul class="navbar-nav">
                        <router-link
                            :to="{name: 'admin-dashboard'}"
                            v-slot="{ href, navigate, isExactActive }">
                            <li :class="['nav-item', isExactActive && 'active']">
                                <a :href="href"
                                   @click="navigate"
                                   class="nav-link">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <font-awesome-icon
                                            :icon="['fa', 'chart-bar']"
                                            class="icon"
                                        ></font-awesome-icon>
                                    </span>
                                    <span class="nav-link-title">
                                      Dashboard
                                    </span>
                                </a>
                            </li>
                        </router-link>
                        <router-link
                            :to="{name: 'admin-users'}"
                            v-slot="{ href, navigate, isExactActive }">
                            <li :class="['nav-item', isExactActive && 'active']">
                                <a :href="href"
                                   @click="navigate"
                                   class="nav-link">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <font-awesome-icon
                                            :icon="['fa', 'user']"
                                            class="icon"
                                        ></font-awesome-icon>
                                    </span>
                                    <span class="nav-link-title">
                                      Users
                                    </span>
                                </a>
                            </li>
                        </router-link>
                        <router-link
                            :to="{name: 'admin-roles-list'}"
                            v-slot="{ href, navigate, isExactActive }">
                            <li :class="['nav-item', isExactActive && 'active']">
                                <a :href="href"
                                   @click="navigate"
                                   class="nav-link">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <font-awesome-icon
                                            :icon="['fa', 'key']"
                                            class="icon"
                                        ></font-awesome-icon>
                                    </span>
                                    <span class="nav-link-title">
                                      Roles
                                    </span>
                                </a>
                            </li>
                        </router-link>
                        <router-link
                            :to="{name: 'admin-packages'}"
                            v-slot="{ href, navigate, isExactActive }">
                            <li :class="['nav-item', isExactActive && 'active']">
                                <a :href="href"
                                   @click="navigate"
                                   class="nav-link">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <font-awesome-icon
                                            :icon="['fa', 'cubes']"
                                            class="icon"
                                        ></font-awesome-icon>
                                    </span>
                                    <span class="nav-link-title">
                                      Packages
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
