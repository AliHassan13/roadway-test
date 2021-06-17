<template>
<div>
     <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="error-wrap">
                    <h1>404</h1>
                    <h4>Page Not Found</h4>
                    <p>The page you are looking for doesn't exit.</p>
                <router-link class="btn btn-pill btn-primary" :to="{ name: 'home' }">
                        Go Home Page
                </router-link>
                </div>
            </div>
        </div>


    </div>
    <div class="error-img">
        <img :src="'/img/error.svg'" alt=""/>
    </div>
</div>
</template>

<script>

export default {
    
}
</script>
<style scoped>

    
</style>