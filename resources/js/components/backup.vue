<template>
    <div class='card'>
        <div class='card-header'>
            posts
        </div>
        <div class='card-body'>
            <p v-for="post in posts">{{post.blog_title}}</p>
        </div>
        <div class='scrollination'></div>
    </div>

</template>
<script>
module.exports = {
    created(){
        window.addEventListener('scroll', this.handleScroll);
    },
    mounted(){
        this.scroll();
        this.pullContent();
    },
    data : function(){
        return {
            posts : {},
            paginate : []
        }
    },
    methods : {
        handleScroll : function(){
           // console.log("scroll detected");    
        },

        scroll : function(){
            
            window.onscroll = () => {
    if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight) {
        alert("you're at the bottom of the page");
    }
            }
        },

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
</script>s