<template>
    <div class="list-item">
        <div>
            <input class="form-check-input" type="checkbox" :checked="hasPermission">
        </div>
        <div class="text-truncate">
            <span class="text-body d-block">{{ permission.name }}</span>
            <small class="d-block text-muted text-truncate mt-n1">{{ permission.description }}</small>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['permission', 'hasPermission']
    }
</script>
