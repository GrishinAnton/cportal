<template>

    <b-button class="salary-hide__button" :size="'sm'" :variant="'danger'" @click="toggle">
        {{ toggleText ? 'Скрыть' : 'Показать' }}
    </b-button>

</template>

<script>
    export default {
        props: {
            toggleText: Boolean
        },
        methods: {
            toggle() {                
                this.$emit('toggle')
            }
        }        
    }
</script>
