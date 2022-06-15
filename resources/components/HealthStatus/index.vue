<template>
    <div class="card card-sm rounded-0">
        <div class="card-body d-flex">
            <StatusIcon
                v-if="healthy === true"
                classes="bg-success text-white"
                iconName="b-icon-check2"></StatusIcon>
            <StatusIcon
                v-else
                classes="bg-danger text-white"
                iconName="b-icon-exclamation-circle"></StatusIcon>

            <div class="ms-3 w-100">
                <div class="fw-bold">{{ name }}</div>
                <div class="pre-text">{{ description }}</div>
            </div>
        </div>
    </div>
</template>

<script>
import "./HealthStatus.css";

import StatusIcon from "@components/StatusIcon";

export default {
    name: 'health-status',
    components: {StatusIcon},
    props: {
        healthy: {
            type: Boolean,
            required: true
        },
        name: {
            type: String,
            required: true
        },
        description: {
            type: String,
            required: false,
            default: ''
        }
    }
}
</script>
