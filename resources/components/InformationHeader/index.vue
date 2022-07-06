<template>
    <div class="information-header">
        <div class="item-background">
            <img class="item-image" :src="image" alt="image"/>
            <div class="item-image-overlay"></div>
        </div>
        <div class="information-content card card-aside">
            <img alt="image" class="item-image card-aside-column" :src="image"/>

            <div class="item-content card-body d-flex flex-column mt-auto">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
import "./InformationHeader.scss";

export default {
    name: "information-header",
    props: {
        image: {
            type: String,
            required: true
        }
    }
}
</script>
