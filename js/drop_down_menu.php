
<!-------- Start hide show user profile drop down menu using jQuery ---->
<script>
  $(document).ready(function(){
   $(".dropdown_header").click(function(){
     $(this).find(".dropdown_menu_header").stop().slideToggle("fast");
   });
   
  });
  
 // Hide drop down menu on click outside of the element in jQuery
  $(document).on('click',function(event){
    var trigger = $('.dropdown_header');
    
    if(trigger !== event.target && !trigger.has(event.target).length){
        $(".dropdown_menu_header").slideUp("fast");   
    }
  }); 
  </script>
 <!-------- End hide show user profile drop down menu using jQuery ----> 
  
   <!------ Start hide show cart drop down menu using jQuery ------->
 <script>
   $(document).ready(function(){
      $(".cart").click(function(){
        $(this).find("ul ul").stop().slideToggle('fast');  
      });
   });  
   
   
 // Hide drop down menu on click outside of the element in jQuery
  $(document).on('click',function(event){
    var trigger = $('.cart');
    
    if(trigger !== event.target && !trigger.has(event.target).length){
        $(".sub_dropdown_cart").slideUp("fast");   
    }
  });
 
 </script>
 <!------ End hide show cart drop down menu using jQuery ------->
 
<!------- Hide show search engine ------------------------------->

<script>
$(document).ready(function(){
 $(".search_mobile").on('click',function(){
   $("#form_mobile").stop().slideToggle();
 });

});

// Hide search engine on click outside of the element in jQuery
  $(document).on('click',function(event){
    var trigger = $('.search_mobile_box, #form_mobile');
    
    if(trigger !== event.target && !trigger.has(event.target).length){
        $("#form_mobile").slideUp("fast");   
    }
  });

</script> 
 
 
 
 
 
 
 