<template>
    <div class="list-item">
        <div class="text-truncate">
            <span class="text-body d-block">{{ name }}</span>
            <small class="d-block text-muted text-truncate mt-n1">{{ description }}</small>
        </div>
        <div>
            <input class="form-check-input" type="checkbox">
        </div>
    </div>
</template>

<script>
    export default {
        props: ['permission']
    }
</script>
