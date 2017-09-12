$(function() {
    $('#side-menu').metisMenu();
});

function sidebarHide(){
 $('#side-menu').toggle();
 $('.notes').toggle();
 $('.navbar-brand').toggle();
 $('#bars-side-menu').toggle();

 if($('#page-wrapper').css('margin-left') == '30px')
   $('#page-wrapper').css('margin-left','230');
 else
   $('#page-wrapper').css('margin-left','30px');
}

function toggleSidebarCookie(){
   if(getCookie("sideBar") == 1){
     setCookie("sideBar",0);
   }else{
     setCookie("sideBar",1);
   }
}

function setCookie(cname, cvalue){
    document.cookie = cname + "=" + cvalue;
}

function delete_cookie( name ){
  document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

function getCookie(cname){
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) != -1) return c.substring(name.length, c.length);
    }
    return "";
}

function sidebarClick(){
  sidebarHide();
  toggleSidebarCookie();
}

$(document).ready(function() {
  if(getCookie("sideBar") == 1){
    sidebarHide();
  }
});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 500) {
            sidebarClick();
        }
    })
})
