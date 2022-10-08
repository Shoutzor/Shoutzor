<template>
    <div class="list-item form-check form-switch">
        <input :checked="hasPermission" class="form-check-input" type="checkbox" :id="'permission_' + permission.name" role="switch">
        <div class="text-truncate">
            <label :for="'permission_' + permission.name">
                <div class="text-body d-block">{{ permission.name }}</div>
                <small class="d-block text-muted text-truncate mt-n1">{{ permission.description }}</small>
            </label>
        </div>
    </div>
</template>

<script>
export default {
    name: 'permission-item',
    props: {
        permission: {
            type: Object,
            required: true
        },
        hasPermission: {
            type: Boolean,
            required: true
        }
    }
}
</script>
