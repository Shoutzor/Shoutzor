<template>
    <nav>
        <ul :class="classes">
            <li class="page-item" :class="hasPrev ? '' : 'disabled'">
                <span class="page-link" @click.prevent="onPrev">Previous</span>
            </li>

            <li class="page-item" v-for="page in showBefore">
                <span class="page-link" @click.prevent="onNavigate(page)">{{ page }}</span>
            </li>

            <li class="page-item active"><span class="page-link">{{ modelValue }}</span></li>

            <li class="page-item" v-for="page in showAfter">
                <span class="page-link" @click.prevent="onNavigate(page)">{{ page }}</span>
            </li>

            <li class="page-item" :class="hasNext ? '' : 'disabled'">
                <span class="page-link" @click.prevent="onNext">Next</span>
            </li>
        </ul>
    </nav>
</template>

<script>
import "./BasePagination.scss";

import {computed, reactive} from "vue";

export default {
    name: 'base-pagination',
    props: {
        modelValue: {
            type: Number,
            required: true
        },
        totalPages: {
            type: Number,
            required: true
        },
        maxPerSide: {
            type: Number,
            required: false,
            default: 2
        },
        onNavigate: {
            type: Function,
            required: true
        },
        size: {
            type: String,
            required: false,
            validator: function (value) {
                return ['normal', 'large', 'small'].indexOf(value) !== -1;
            },
            default: 'normal'
        },
        justify: {
            type: String,
            required: false,
            validator: function (value) {
                return ['start', 'center', 'end'].indexOf(value) !== -1;
            },
            default: 'start'
        }
    },
    setup(props) {
        props = reactive(props);

        return {
            classes: computed(() => ({
                'pagination': true,
                'pagination-sm': props.size === 'small',
                'pagination-lg': props.size === 'large',
                'justify-content-start': props.justify === 'start',
                'justify-content-center': props.justify === 'center',
                'justify-content-end': props.justify === 'end',
            }))
        }
    },
    computed: {
        hasPrev() {
            return this.modelValue - 1 >= 1;
        },
        hasNext() {
            return this.modelValue + 1 <= this.totalPages;
        },
        maxPagesToShow() {
            return this.maxPerSide * 2;
        },
        maxOnLeftSide() {
            if(this.modelValue <= this.maxPerSide) {
                return this.modelValue;
            }

            return this.maxOnRightSide >= this.maxPerSide
                ? this.maxPerSide
                : this.maxPagesToShow - this.maxOnRightSide;
        },
        maxOnRightSide() {
            // Nothing to show on the right side when we're on the last page already
            if(this.modelValue >= this.totalPages) {
                return 0;
            }

            // Start with the max that we can show
            let toShow = this.maxPerSide * 2;

            // If the left side is showing it's maximum amount
            if(this.modelValue > this.maxPerSide) {
                toShow = this.maxPerSide;
            }
            // Left side will be showing less than the maxPerSide
            else {
                toShow -= this.modelValue - 1;
            }

            // Finally, do a check that we're not showing pages beyond the number of totalPages
            if(toShow >= this.totalPages - this.modelValue) {
                return this.totalPages - this.modelValue;
            }

            return toShow;
        },
        showBefore() {
            let res = [];
            for(let i = 1; i <= this.maxOnLeftSide; i++) {
                let n = this.modelValue - i;
                // There is no page 0 or lower
                if(n < 1) {
                    continue;
                }
                res.push(n);
            }
            res.reverse();
            return res;
        },
        showAfter() {
            let res = [];
            for(let i = 1; i <= this.maxOnRightSide; i++) {
                res.push(i + this.modelValue);
            }
            return res;
        }
    },
    methods: {
        onNext() {
            if(!this.hasNext) {
                return;
            }
            this.onNavigate(this.modelValue + 1);
        },
        onPrev() {
            if(!this.hasPrev) {
                return;
            }
            this.onNavigate(this.modelValue - 1);
        }
    }
}
</script>
