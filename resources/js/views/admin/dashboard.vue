<template>
    <div>
        <div class="row row-cards">
            <div class="col-sm-6 col-md-4">
                <div class="card card-sm">
                    <div class="card-body d-flex align-items-center">
                        <span class="bg-lime-lt avatar mr-3">
                            <users-icon></users-icon>
                        </span>
                        <div class="ms-3 lh-sm">
                            <div class="strong">
                                132 Accounts
                            </div>
                            <div class="text-muted">12 waiting approval</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-100"></div>

            <div class="col-sm-12">
                <health-check ref="healthcheck"></health-check>
            </div>
        </div>
    </div>
</template>

<script>
import HealthCheck from "@js/components/admin/dashboard/HealthCheck";

export default {
    name: "admin-dashboard",
    components: {HealthCheck}
};
</script>
