<template>
                <div class="card-header">                    
                   
                    <span v-if="renderUp">
                        <span class="clickableSpan" @click="upvote"><i class="fas fa-thumbs-up"></i></span>&nbsp;{{upvotes}}
                    </span>
                    <span v-else>
                        <span><i class="fas fa-thumbs-up"></i></span>&nbsp;{{upvotes}}
                    </span>
                    
                    &nbsp;&nbsp;
                    
                    <span v-if="renderDown">
                        <span  class="clickableSpan" @click="downvote"><i class="fas fa-thumbs-down"></i></span>&nbsp;{{downvotes}}
                    </span>
                    <span v-else>
                        <span><i class="fas fa-thumbs-down"></i></span>&nbsp;{{downvotes}}
                    </span>
                
                </div>
</template>

<script>
    const csrfToken = require('./lib/csrfToken');
    const axios = require('axios');
    const headers = {...csrfToken}    
    module.exports =  {
        props : {
            blog_id: { type : String, required : true },
            upvotes: {type: String, required : true},
            downvotes: {type: String, required: true}
        },
        data : function(){
            return {
                upcounter : 100,
                downcounter : 21,
                renderDown: (localStorage.getItem(this.blog_id) == 'upvote') ? false : true, 
                renderUp : (localStorage.getItem(this.blog_id) == 'downvote') ? false : true
            }
        },
        methods : {
            upvote : function(event){ 
               self = this;                             
               x = localStorage.getItem(this.blog_id);
               console.log(headers);
               if(!x){                                      
                   this.castVote('upvote').then(function(data){
                        console.log(headers);
                        localStorage.setItem(self.blog_id,'upvote');                   
                        self.upvotes = data.upvotes;
                        self.downvotes = data.downvotes; 
                        self.renderUp = true;
                        self.renderDown = false;                        
                   }).catch(function(err){});
               } else {
                   this.castVote('removeupvote').then(function(data){
                        localStorage.removeItem(self.blog_id);                   
                        self.upvotes = data.upvotes;
                        self.downvotes = data.downvotes;
                        self.renderUp = true;
                        self.renderDown = true; 
                   }).catch(function(err){});                  
               }
            },

            downvote : function(event){
                self = this;
                x = localStorage.getItem(this.blog_id);
                console.log(x);
                if(!x){
                    this.castVote('downvote').then(function(data){
                        localStorage.setItem(self.blog_id,'downvote');                    
                        self.upvotes = data.upvotes;
                        self.downvotes = data.downvotes;
                        self.renderUp = false;
                        self.renderDown = true;
                    }).catch(function(err){});                    
                } else {
                    this.castVote('removedownvote').then(function(data){
                        localStorage.removeItem(self.blog_id);                    
                        self.upvotes = data.upvotes;
                        self.downvotes = data.downvotes;
                        self.renderUp = true;
                        self.renderDown = true;                                            
                    }).catch(function(err){});
                }
            },

            castVote : function(vote){
                self = this;
                return new Promise(function(resolve,reject){
                    let route = '/api/castvote/';
                    let data = {};
                    data.blog_id = self.blog_id;
                    data.voteType = vote;
                    
                    axios.post(route,data,headers)
                    .then(function(data){                                              
                        resolve(data.data);
                    }).catch(function(err){
                        console.log(err);
                        reject(err);
                    })
                });
            }
            
        }
    }
</script>
