<script setup>
import { ref, watchEffect } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';
import Toast from 'primevue/toast';

const page = usePage();
const toast = useToast();
const show = ref(true);
const style = ref('success');
const message = ref('');

watchEffect(async () => {
    style.value = page.props.jetstream.flash?.bannerStyle || page.props.jetstream.flash?.status || 'success';
    message.value = page.props.jetstream.flash?.banner || page.props.jetstream.flash.message || '';
    
    if(show.value && message.value && style.value) {
        toast.add({ severity: style.value, summary: style.value.toUpperCase(), detail: message.value, life: 3000 });
    }

    if(page.props.errors?.status && page.props.errors?.message) {
        toast.add({ severity: page.props.errors.status, summary: page.props.errors.status.toUpperCase(), detail: page.props.errors.message, life: 3000 });
    }
});
</script>

<template>
    <div>
        <Toast />
    </div>
</template>
