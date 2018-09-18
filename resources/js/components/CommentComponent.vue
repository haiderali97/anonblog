<template>
    <section>
            <!-- Post Comment -->            
            <div class='card'>
                <div class='card-header'>Post a comment</div>
                <div class='card-body'>

                        <div class="form-group row">
                            <label for="blog_post" class="col-md-4 col-form-label text-md-right">Comment</label>

                            <div class="col-md-6">  
                                <textarea v-if="error" id="comment" class="form-control is-invalid" name="comment" v-model="comment"></textarea>                              
                                <textarea v-else id="comment"  class="form-control" name="comment" v-model="comment"></textarea> 
                                    <span v-if="error" class="invalid-feedback" role="alert">
                                        <strong>{{ error }}</strong>
                                    </span>                                                                                                
                            </div>
                           
                        </div>                   

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button @click="postComment" class="btn btn-primary">
                                    Post
                                </button>
                            </div>                            
                        </div>


                </div>
            </div>
            <!-- Post Comment -->

            <!-- Comments with Pagination -->
            <div class='card'>
                <div class='card-header'>Comments</div>
                <div class='card-body comments'>
                    <comment v-for="comment in comments" :comment="comment" :key="comment.id" />
                    <div v-if="paginate.hasPages">
                        <button v-if="paginate.prev_page_url" class="btn btn-primary" @click="paginateComments(0)">Previous Page</button>
                        <button v-if="paginate.next_page_url" class="btn btn-primary" @click="paginateComments(1)">Next Page</button>
                    </div>
                </div>
            </div>
            <!-- Comments with Pagination -->
    </section>
</template>

<script>
const Comment = require('./Comment');
const csrfToken = require('./lib/csrfToken');
const axios = require('axios');
const headers = {...csrfToken}   
module.exports = {
    props :{
        blog_id : { type: String, required: true }
    },
    components: {
        Comment
    },
    mounted (){
      this.getComments();
    },

    data : function(){
        return {
            comment : '',
            error : 0,
            comments : [],
            paginate: {}
        }
    },
    methods : {

        validateForm : function(){
            self = this;
            return new Promise(function(resolve,reject){
                //Validate form 
                if(!self.comment) reject('Comment cannot be empty');
                if(self.comment.length < 15) reject('Your comment needs to be at least 15 characters');
                if(self.comment.length > 180) reject('Your comment needs to be less than 180 characters');
                resolve(1);
            });
        },

        postComment : function(event){
            console.log("im running");
            self = this;
            this.validateForm().then(function(da){
                self.error = 0;
                return self.submitComment();
            }).catch(function(err){
                self.error = err;
            });
        },

        submitComment : function(){
            self = this;
            return new Promise(function(resolve,reject){
                data = {comment:self.comment,blog_id:self.blog_id}
                route = '/api/postComment'
                axios.post(route,data,headers).then(function(data){
                    resolve(data);
                    self.getComments();
                    self.comment = '';
                }).catch(function(err){
                    reject('An unexpected error occured! Im sorry :(');
                });
            });
        },

        paginateComments : function(type){
            //1 = next, 0 = previous
            if(type==1){                
                page = (this.paginate.next_page_url) ? this.paginate.next_page_url.split("=")[1] : 1;
            } else {                 
                page = (this.paginate.prev_page_url) ? this.paginate.prev_page_url.split("=")[1] : 1;                
            }
            console.log(page);
            this.getComments(page);
        },

        getComments : function(page=1){
            self = this;
            url = '/api/'+self.blog_id+'/getComments/?page='+page
            axios.get(url).then(function(response){
                self.comments = response.data.data;
                delete response.data.data;
                self.paginate = response.data;
            }).catch(function(err){

            });
        }

    },

}
</script>