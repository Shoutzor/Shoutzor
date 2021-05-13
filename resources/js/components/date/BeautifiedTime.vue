<template>
    <span class="time">{{ displayTime }}</span>
</template>

<script>
function formatTime(seconds) {
    let sec_num = parseInt(seconds, 10); // don't forget the second param
    let h = Math.floor(sec_num / 3600);
    let m = Math.floor((sec_num - (h * 3600)) / 60);
    let s = sec_num - (h * 3600) - (m * 60);

    //If hours eq 0, hide it
    if(h === 0) {
        h = "";
    }
    else {
        if(h < 10) {
            h = "0" + h + ":";
        }
        else {
            h = h + ":";
        }
    }

    if(m < 10) {
        m = "0" + m;
    }
    if(s < 10) {
        s = "0" + s;
    }
    return h + m + ':' + s;
}

export default {
    props: ['time'], data: function() {
        return {
            displayTime: formatTime(this.time)
        }
    }
}
</script>
