<template>
    <span class="datetime">{{ displayDateTime }}</span>
</template>

<script>
    import moment from 'moment';

    export default {
        props: ['datetime'],
        data: function() {
            return {
                displayDateTime: moment(String(this.datetime)).format('hh:mm:ss DD-MM-YYYY')
            }
        }
    }
</script>
