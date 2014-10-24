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
