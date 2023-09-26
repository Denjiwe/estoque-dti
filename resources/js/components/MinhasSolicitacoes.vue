<script setup>
</script>

<template>
    <div class="card-box">
        <h1>Minhas Solicitações</h1>
        <p v-for="solicitacao in solicitacoesAbertas" :key="solicitacao.id">{{ solicitacao }}</p>
    </div>
</template>