<template>
    <div class="row row-cards">
        <div class="col-sm-6 col-md-4">
            <div class="card card-sm">
                <div class="card-body d-flex align-items-center">
                          <span class="bg-blue text-white stamp mr-3">
                              <font-awesome-icon
                                  :icon="['fas', 'user-alt']"
                              ></font-awesome-icon>
                          </span>
                    <div class="mr-3 lh-sm">
                        <div class="strong">
                            132 Accounts
                        </div>
                        <div class="text-muted">12 waiting approval</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "admin-dashboard"
};
</script>
