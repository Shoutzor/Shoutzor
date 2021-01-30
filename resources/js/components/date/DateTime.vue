<template>
    <span class="time">{{ displayTime }}</span>
</template>

<script>
    function formatTime(seconds) {
        let date = new Date(seconds * 1000).toISOString().substr(11, 8);

        if(date.substring(0, 6) === "00:00:") {
            date = date.substring(3, date.length);
        } else if(date.substring(0, 3) === "00:") {
            date = date.substring(3, date.length);
        }

        return date;
    }

    export default {
        props: ['time'],
        data: function() {
            return {
                displayTime: formatTime(this.time)
            }
        }
    }
</script>
