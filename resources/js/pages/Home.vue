<template>

<div>
    <div  v-if="login">
        <dashboard @loggedout="toggle"/>
    </div>
    <div v-else>
    <login @loggedin="toggle" />

    </div>
</div>
    
</template>

<script>
import Dashboard from './Dashboard.vue';
import Login from './Login.vue';
export default {
  components: {Dashboard, Login },
      mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                 login:false
            }
        },
        created() {
         if(localStorage.getItem('token')){
             this.login=true;
         }
        },
        methods: {
             toggle() {
                this.login = !this.login;
                // (this.searched)?this.search(page):this.getalllist(page);
            }
    
    }
    
}
</script>
<style scoped>
.min-height{
min-height : 190px !important;
}
</style>