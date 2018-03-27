<template>
  
</template>

<script>
    import Swal from 'sweetalert';
    export default {
        created(){ 
            window.events.$on('notification', (payload) => {
               Swal(payload.message);
            })
        }  
    }
    
</script>

<style>
    alert-noty{
        position: fixed;
        right: 20px;
        bottom: 40px;
        z-index: 1;
    }
</style>
