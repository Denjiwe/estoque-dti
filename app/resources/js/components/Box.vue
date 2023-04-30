<template>
    <div class="box mb-4" style="width: 100%;">
        <div class="card-header"><h2 class="mt-2">{{titulo}}</h2></div>

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
        props: ['titulo'],
    }
</script>

<style>
    .box {
        width: 100%;
        background-color: white;
        border-radius: 10px;
        border: 1px solid #dbdbdb;
        box-shadow: 1px black solid;
        padding: 15px;
    }
</style>