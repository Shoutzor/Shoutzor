<template>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#" @click.prevent="onPrev">Previous</a></li>
            <template v-for="page in showBefore">
                <li class="page-item"><a class="page-link" href="#" @click.prevent="onNavigate(page)">{{ page }}</a></li>
            </template>
            <li class="page-item active"><a class="page-link" href="#">{{ modelValue }}</a></li>
            <template v-for="page in showAfter">
                <li class="page-item"><a class="page-link" href="#" @click.prevent="onNavigate(page)">{{ page }}</a></li>
            </template>
            <li class="page-item"><a class="page-link" href="#" @click.prevent="onNext">Next</a></li>
        </ul>
    </nav>
</template>

<script>
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
        maxPagesToShow: {
            type: Number,
            required: false,
            default: 5
        },
        onNavigate: {
            type: Function,
            required: true
        },
    },
    computed: {
        hasPrev() {
            return this.modelValue - 1 >= 1;
        },
        hasNext() {
            return this.modelValue + 1 <= this.totalPages;
        },
        maxPerSide() {
            return Math.floor(this.maxPagesToShow / 2);
        },
        maxOnLeftSide() {
            if(this.modelValue <= this.maxPerSide) {
                return this.modelValue;
            }

            let c = this.maxPagesToShow - this.maxOnRightSide;
            return this.maxOnRightSide >= this.maxPerSide ? this.maxPerSide : c;
        },
        maxOnRightSide() {
            // We're still on the left side
            if(this.modelValue <= this.maxPerSide) {
                return this.maxPagesToShow - this.modelValue;
            }

            if(this.modelValue >= this.totalPages) {
                return 0;
            }

            let c = this.totalPages - this.modelValue;
            return this.maxPerSide < c ? this.maxPerSide : c;
        },
        showBefore() {
            let res = [];
            for(let i = 1; i <= this.maxOnLeftSide; i++) {
                let n = this.modelValue - i;
                if(n <= 0) {
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
