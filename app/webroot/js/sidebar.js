var up = 1;

function sidebarHide(){
 $('#side-menu').toggle();
 $('.notes').toggle();

 if(up == 1){
   $('.fa-caret-left').addClass('fa-caret-right');
   $('.fa-caret-left').removeClass('fa-caret-left');
   up = 0;
 }else{
   $('.fa-caret-right').addClass('fa-caret-left');
   $('.fa-caret-right').removeClass('fa-caret-right');
   up = 1;
 }

 if($('#page-wrapper').css('margin-left') == '10px')
   $('#page-wrapper').css('margin-left','250');
 else
   $('#page-wrapper').css('margin-left','10px');
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
