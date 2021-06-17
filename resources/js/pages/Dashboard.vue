<template>
    <div class="app-body">
        <!--main contents start-->
        <main class="main-content">

             <div class="bg-dark profile-img mb-4 text-light d-flex align-items-end">
                <div class="container-fluid">
                    <div class="row mb-4 pt-5 pb-3 d-flex align-items-end">
                        <div class="col-md-6">
                            <div class="media mb-4">
                                <div class="media-body mt-1 profile-text-shadow">
                                    <strong class="f30">Dashboard</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4 pt-5 pb-3 d-flex align-items-end">
                        <div class="col-md-6">
                            <div class="media mb-4">
                                <div class="media-body mt-1 profile-text-shadow">
                                    <button class="mt-30 btn btn-primary" @click="logout()">Logout</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                  <div class="col-md-2">
                
                       <router-link class="btn btn-primary" :to="{ name: 'list' }">
                        Add List
                        </router-link>
                  </div>
                  <div class="col-md-6 offset-md-4">
                      <div class="input-group mb-4">
                            <input type="text" class="form-control form-control-lg" placeholder="Search for..." v-model="searchTitle">
                            <span class="input-group-btn">
                                <button class="btn btn-primary text-uppercase pl-5 pr-5" type="button" @click="searchList()">Search</button>
                            </span>
                        </div>
                  </div>
                </div>
                <!-- state start-->
                <div class="row">
                    <div class="col-sm-4"  v-for="list in lists.data" :key="list.id">
                        <div class="card  border-primary mb-4">
                            <div class="card-header bg-primary ">
                                <div class="card-title text-white">
                                    {{ list.title.length < 45 ? list.title : list.title.substring(0,45) + "..."}}
                                </div>
                            </div>
                            <div class="card-body min-height">
                                <p class="card-text">{{ list.description.length < 300 ? list.description : list.description.substring(0,300) + "..."}}</p>
                            </div>
                             <div class="card-footer">
                                 <div class="row">
                                     <div class="col-md-6 col-offset-md-4">
                                        <a  class="btn btn-success text-white" title="Edit" @click="edit(list)"><i class="fas fa-edit"></i></a>
                                        <a  class="btn btn-danger text-white" title="Delete" @click="deletelist(list.id)"><i class="fas fa-trash-alt"></i></a>
                                     </div>
                                 </div>
                             </div>
                        </div>
                    </div>
                   
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-4 col-offset-md-6">
                     <pagination :data="lists" @pagination-change-page="getLists"></pagination>
                    </div>
                </div>
                <!-- state end-->
            </div>
        </main>
        <!--main contents end-->
        <modal-component
         @listupdated="getLists"
         ref="modallist" />
    </div>
    
</template>

<script>
import ModalComponent from '../components/ModalComponent.vue';
import Swal from 'sweetalert2';
export default {
  components: { ModalComponent },
     name: "detail-modal",
      mounted() {
            console.log('Component mounted.')
         this.getLists();

        },
        data() {
            return {
                lists:{},
                edit_list:{},
                searchTitle:'',
                searched:false,
                token:''
            }
        },
        created() {
        this.token = localStorage.getItem('token');
        console.log('created');
     
        },
        methods: {
             getLists(page = 1) {
                
                (this.searched)?this.search(page):this.getalllist(page);
            },
            getalllist(page = 1){
                 axios.get('api/list?page=' + page,{headers:{"Authorization":"Bearer "+this.token}
                    }).then(response => {
                    console.log(response.data);
                    this.lists = response.data;
                });
            },
        edit(list){
            this.$refs.modallist.edit_list(list)
              $('#exampleModal').modal('toggle');
        },
        deletelist(id){
            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to delete this Todo-list!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it'
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                    'Deleted!',
                    'Your Todo-list file has been deleted.',
                    'success'
                    );
                    this.deleteList(id);
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                    'Cancelled',
                    'Your Todo-list is safe :)',
                    'error'
                    )
                }
                })
        },
        deleteList(id){
            console.log(id);
            axios.delete('api/list/' + id,{headers:{"Authorization":"Bearer "+this.token}
                    }).then(response => {
                    this.getLists();
                });
        },
        async searchList() {
                 if(this.searchTitle ==''){
                    Swal.fire('Requied...', 'Kindly type any list title!', 'warning')
                 }else{

                       await this.search();           
                 }
           
        },
       async search(page){
            await axios.post('api/list/search?page='+page, {
                       search: this.searchTitle
                    },{
                        headers:{
                            "Authorization":"Bearer "+this.token
                        }
                    }).then(response => {
                      if(response.data.data.length <1){
                          console.log(response.data.data.length);
                          this.searchTitle='';
                        Swal.fire('Not Found...', 'No data found..', 'warning');
                      }
                      this.searched=true;
                      this.lists = response.data;
                    });
        },
        async logout(){
             await axios.get('api/logout',{headers:{"Authorization":"Bearer "+this.token}
                    }).then(response => {
                        localStorage.removeItem('token');
                       this.$emit('loggedout');
                    });

        }
    }
    
}
</script>
<style scoped>
.min-height{
min-height : 190px !important;
}
</style>