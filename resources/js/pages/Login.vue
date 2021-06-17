<template>
    <div class="container">
        <div class="form-signin" v-if="seen">
            <a class="brand text-center">
                <img :src="'/img/logo.png'"  srcset="assets/img/logo-dark@2x.png 2x" alt=""/>
            </a>
            <h2 class="form-signin-heading">Please sign in</h2>
            <div class="form-group">
                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="email" id="inputEmail" v-model="login_email" class="form-control" placeholder="Email address">
            </div>

            <div class="form-group">
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="inputPassword" v-model="login_pwd" class="form-control" placeholder="Password">
            </div>
            <button class="btn btn-lg btn-primary btn-block" @click="signIn()">Sign in</button>

            <div class="mt-4">
                <span>
                    Don't have an account yet ?
                </span>
                <a @click="seen = !seen" class="text-primary anchor">Sign Up</a>
            </div>
        </div>
        <div class="form-signin" v-else>
            <a href="index.html" class="brand text-center">
                <img :src="'/img/logo.png'" srcset="assets/img/logo-dark@2x.png 2x" alt=""/>
            </a>
            <h2 class="form-signin-heading">Please sign up</h2>
            <div class="form-group">
                <label for="inputName" class="sr-only">Full Name</label>
                <input type="text" id="inputName" v-model="user_name" class="form-control" placeholder="Full Name">
            </div>

            <div class="form-group">
                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="email" id="inputEmail" v-model="user_email" class="form-control" placeholder="Email address" required>
            </div>

            <div class="form-group">
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="inputPassword" v-model="user_pwd" class="form-control" placeholder="Password" required>
            </div>

            <div class="form-group">
                <label for="inputConfirmPassword" class="sr-only">Confirm Password</label>
                <input type="password" id="inputConfirmPassword" v-model="user_confirm_pwd" class="form-control" placeholder="Confirm Password" required>
            </div>
            <button :disabled="isLoading" class="btn btn-lg btn-primary btn-block" @click="signUp()">
            <div v-if="isLoading" class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
            <span v-else> Sign up</span>
            </button>
        </div>
        
 </div>
</template>

<script>
import Swal from 'sweetalert2';
export default {
     data() {
            return {
                seen : true,
                login_email:'',
                login_pwd:'',
                user_name:'',
                user_email:'',
                user_pwd:'',
                user_confirm_pwd:'',
                isLoading: false,
                fullPage: true
            }
        },
         components: {
            
        },
         methods: {
            async signUp() {
                 if(this.user_name =='' || this.user_email =='' || this.user_pwd =='' || this.user_confirm_pwd ==''){
                    Swal.fire('Requied...', 'All fields are required!', 'warning')
                 }else if(this.user_pwd !== this.user_confirm_pwd){
                    Swal.fire('Error...', 'Password & Confirm Password must be same.', 'warning')
                 }else{
                        this.isLoading = true;
                        await this.register();           
                 }
           
        },
       async register(){
           await  axios.post('api/register', {
                        name: this.user_name,
                        email: this.user_email,
                        password: this.user_pwd,
                        password_confirmation: this.user_confirm_pwd
                    }).then(response => {
                        console.log(response);
                      this.successMessage();
                    }).catch(error => {
                        if(error.response.status == '422'){
                            let res_error = error.response.data.errors.email[0]; 
                            this.errorMessage(res_error);
                        }else if(error.response.status == '500'){
                            let res_error = 'Someting went wrong';
                            this.errorMessage(res_error);

                        }
                    });
        },
       async signIn(){
           if(this.login_email =='' || this.login_pwd ==''){
                    Swal.fire('Requied...', 'All fields are required!', 'warning')
            }else{
                        await this.login();           
                 }

        },
        async login(){
             await  axios.post('api/login', {
                        email: this.login_email,
                        password: this.login_pwd
                    }).then(response => {
                        console.log(response.data.access_token);
                        localStorage.setItem('token', response.data.access_token);
                        this.$emit('loggedin');
                    }).catch(error => {
                        if(error.response.status == '500'){
                           let res_error = 'Someting went wrong';
                            this.errorMessage(res_error);
                        }else{
                             let res_error =error.response.data.message;
                            this.errorMessage(res_error);
                        }
                    });

        },
        errorMessage(error){
            Swal.fire('Error', error, 'error')

        },
        successMessage(){
             Swal.fire('Success', 'Register Successfully', 'success');
             this.seen = !this.seen;
             this.user_name='';
             this.user_email='';
             this.user_pwd='';
             this.user_confirm_pwd='';
        }
        }
}
</script>
<style scoped>
.anchor{
cursor: pointer
}
 .lds-ellipsis {
  display: inline-block;
  position: relative;
  width: 80px;
  height: 80px;
}
.lds-ellipsis div {
  position: absolute;
  top: 33px;
  width: 13px;
  height: 13px;
  border-radius: 50%;
  background: #000;
  animation-timing-function: cubic-bezier(0, 1, 1, 0);
}
.lds-ellipsis div:nth-child(1) {
  left: 8px;
  animation: lds-ellipsis1 0.6s infinite;
}
.lds-ellipsis div:nth-child(2) {
  left: 8px;
  animation: lds-ellipsis2 0.6s infinite;
}
.lds-ellipsis div:nth-child(3) {
  left: 32px;
  animation: lds-ellipsis2 0.6s infinite;
}
.lds-ellipsis div:nth-child(4) {
  left: 56px;
  animation: lds-ellipsis3 0.6s infinite;
}
@keyframes lds-ellipsis1 {
  0% {
    transform: scale(0);
  }
  100% {
    transform: scale(1);
  }
}
@keyframes lds-ellipsis3 {
  0% {
    transform: scale(1);
  }
  100% {
    transform: scale(0);
  }
}
@keyframes lds-ellipsis2 {
  0% {
    transform: translate(0, 0);
  }
  100% {
    transform: translate(24px, 0);
  }
}   
</style>