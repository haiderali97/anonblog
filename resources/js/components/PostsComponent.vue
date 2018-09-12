<template>
    <div class='card'>
        <div class='card-header'>
            posts
        </div>
        <div v-infinite-scroll="pullContent" class='card-body'>
            <div class='card-header' v-for="post in posts">{{post.blog_title}}</div>
        </div>        
    </div>

</template>
<script>
module.exports = {
    directives : {infiniteScroll},
    data : function(){
        return {
            posts : {},
            paginate : []
        }
    },
    methods : {
        pullContent : function(){
            self = this;                        
            if(typeof self.paginate.next_page_url == 'undefined'){
                page = 1; 
            } else {
                if(!self.paginate.next_page_url) return;
                page = self.paginate.next_page_url = self.paginate.next_page_url.split("=")[1];
            }                     
            route = `/api/getPosts/?page=`+page;
            axios.get(route).then(function(response){
                if(self.posts.length){
                    self.posts = [...self.posts,...response.data.data];
                } else {
                    self.posts = response.data.data;                
                }                
                delete response.data.data;
                self.paginate = response.data;
            }).catch(function(err){
                //Do nothing lul
            });
        }
    }
}
</script>