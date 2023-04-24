<template>
    <div class="card mb-4">
        <div class="card-header">{{titulo}}</div>

        <div class="card-body">
            <slot name="body"></slot>
        </div>

        <div class="card-footer">
            <slot name="footer"></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['titulo']
    }
</script>