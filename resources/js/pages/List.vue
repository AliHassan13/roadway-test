<template>
        <!--main contents start-->
        <main class="main-content">

            <!--profile heading start-->
            <div class="bg-dark profile-img mb-4 text-light d-flex align-items-end">
                <div class="container-fluid">
                    <div class="row mb-4 pt-5 pb-3 d-flex align-items-end">
                        <div class="col-md-6">
                            <div class="media mb-4">
                                <div class="media-body mt-1 profile-text-shadow">
                                    <strong class="f30">Add New List</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4 pt-5 pb-3 d-flex align-items-end">
                        <div class="col-md-6">
                            <div class="media mb-4">
                                <div class="media-body mt-1 profile-text-shadow">
                                    <button class="btn btn-primary" @click="BackToDashboard()">Back to Dashboard</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                         <div class="card card-shadow mb-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <strong>Add New List</strong>
                                </div>
                            </div>
                            <div class="card-body">
                                    <div class="form-group">
                                        <label for="InputTitle">Title</label>
                                        <input type="text" class="form-control" id="InputTitle" v-model="title" placeholder="Enter title">
                                    </div>
                                    <div class="form-group">
                                        <label for="InputDescription">Description</label>
                                        <textarea name="description" class="form-control" id="InputDescription" v-model="description" cols="30" rows="10"></textarea>
                                    </div>
                                    <button @click="addList" class="btn btn-block btn-primary">Submit</button>                            
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <!--profile heading end-->
           
        </main>
</template>
 
<script>
import Swal from 'sweetalert2';
    export default {
        
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                title: '',
                description:'',
                token:""
            }
        },
        created() {
          if(localStorage.getItem('token')){
            this.token = localStorage.getItem('token');
          }else{
              this.$router.push('/');
          }
        },
        methods: {
            async addList() {
                 if(this.title =='' || this.description ==''){
                    Swal.fire('Requied...', 'Both fields are required!', 'warning')
                 }else{

                       await this.saveList();           
                 }
           
        },
       async saveList(){
           await axios.post('api/list', {
                        title: this.title,
                        description: this.description,
                    },{headers:{"Authorization":"Bearer "+this.token}}).then(response => {
                      this.successMessage();
                    });
        },
        successMessage(){
            Swal.fire({
                    title: 'Success',
                    text: 'List Successfully Stored!',
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'Done',
                    cancelButtonText: ''
                    }).then((result) => {
                    if (result.isConfirmed) {
                      this.$router.push('/')  
                      
                    } 
                    })
        },
        BackToDashboard(){
            this.$router.push('/') 
        }
        }
    }
</script> 
