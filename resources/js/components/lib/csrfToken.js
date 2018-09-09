getToken = function(){
   let token = document.querySelector('meta[name="csrf-token"]');
   return token.getAttribute('content');
}
module.exports = {
    'X-CSRF-TOKEN' : getToken()
}