<template>
<div>
     <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="error-wrap">
                    <h1>congratulations</h1>
                    <h4>You Email is Verified</h4>
                <router-link class="btn btn-pill btn-primary" :to="{ name: 'home' }">
                        Go Home Page
                </router-link>
                </div>
            </div>
        </div>


    </div>
    <div class="error-img">
        <img :src="'/img/happy.png'" alt=""/>
    </div>
</div>
</template>

<script>

export default {
    
}
</script>
<style scoped>

    
</style>