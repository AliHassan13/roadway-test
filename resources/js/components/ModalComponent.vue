<template>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">List Detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                         <div class="form-group">
                            <label for="InputTitle">Title</label>
                            <input type="text" class="form-control" id="InputTitle" v-model="editList.title" placeholder="Enter title">
                        </div>
                        <div class="form-group">
                            <label for="InputDescription">Description</label>
                            <textarea name="description" class="form-control" id="InputDescription" v-model="editList.description" cols="30" rows="10"></textarea>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="update()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>    
</template>

<script>
import Swal from 'sweetalert2';
export default {
      mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
              editList:{},
              token:''
            }
        },
        created() {
            this.token = localStorage.getItem('token');
        },
        methods: {
            edit_list(list){
            this.editList=JSON.parse(JSON.stringify(list));
            },
            update(){
                let id =this.editList.id;
                axios.patch('api/list/'+id, {
                        title: this.editList.title,
                        description: this.editList.description,
                    },{headers:{"Authorization":"Bearer "+this.token}
                    })
                .then(response => {
                     this.successMessage();
                });
            },
        successMessage(){
            Swal.fire({
                    title: 'Success',
                    text: 'List Updated Successfully!',
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'Done',
                    cancelButtonText: ''
                    }).then((result) => {
                    if (result.isConfirmed) {
                     $('#exampleModal').modal('toggle');
                     this.$emit('listupdated');
                    } 
                    })
        }
    }
    
}
</script>