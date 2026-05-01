<html>
 
 <head>
         <title>Kinh Phật</title>
          
 <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
 <script src="https://cdn.tailwindcss.com"></script>
     
  <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700i" rel="stylesheet">
  
  
     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
     <script src="/booklet/jquery.easing.1.3.js" type="text/javascript"></script>
     <script src="/booklet/jquery.booklet.1.1.0.min.js" type="text/javascript"></script>
 
     <link href="/booklet/jquery.booklet.1.1.0.css" type="text/css" rel="stylesheet" media="screen" />
 </head>
      
      <style>
          
               *{
   margin:0;
   padding:0;
 }
 body{
 width: 100%;
   color:#444;
   font-size:12px;
   color: #333;
     font-family: 'Oswald', sans-serif;
     /* background:transparent url(/images/toan.jpeg) no-repeat ; */
     background: #FCFEC4;
     background-size:cover;

  
 }
  
  
 .booklet           {
   width:900px;
   height:607px;
   position:relative;
   margin:0 auto 10px;
   -moz-box-shadow:0px 0px 1px #fff;
   -webkit-box-shadow:0px 0px 1px #fff;
   box-shadow:0px 0px 1px #fff;
   -moz-border-radius:10px;
   -webkit-border-radius:10px;
   border-radius:10px;
 }
 .booklet .b-wrap-left  {
   background:#fff url(/images/left_bg.jpg) no-repeat top left;
   -webkit-border-top-left-radius: 10px;
   -webkit-border-bottom-left-radius: 10px;
   -moz-border-radius-topleft:10px;
   -moz-border-radius-bottomleft: 10px;
   border-top-left-radius: 10px;
   border-bottom-left-radius: 10px;
 }
 .booklet .b-wrap-right {
   background:#efefef url(/images/right_bg.jpg) no-repeat top left;
   -webkit-border-top-right-radius: 10px;
   -webkit-border-bottom-right-radius: 10px;
   -moz-border-radius-topright: 10px;
   -moz-border-radius-bottomright: 10px;
   border-top-right-radius: 10px;
   border-bottom-right-radius: 10px;
 }
 .booklet .b-counter {
   bottom:10px;
   position:absolute;
   display:block;
   width:90%;
   height:20px;
   border-top:1px solid #ddd;
   color:#222;
   text-align:center;
   font-size:12px;
   padding:5px 0 0;
   background:transparent;
   -moz-box-shadow:0px -1px 1px #fff;
   -webkit-box-shadow:0px -1px 1px #fff;
   box-shadow:0px -1px 1px #fff;
   opacity:0.8;
 }
 /* .book_wrapper{
   margin:0 auto;
   padding-top:50px;
   width:905px;
   height:540px;
   position:relative;
   /* background:transparent url(/images/bg.png) no-repeat 9px 27px; */
  */
 .book_wrapper h1{
   color:orange;
   margin:5px 5px 5px 15px;
   font-size:24px;
   background:transparent url(/images/h1.png) no-repeat bottom left;
   padding-bottom:7px;
     text-transform: uppercase;
     font-weight: normal;
 }
 .book_wrapper p{
   font-size:15px;
   margin:5px 5px 5px 15px;
 }
 .book_wrapper a.article,
 .book_wrapper a.demo{
   background:transparent url(/images/circle.png) no-repeat 50% 0px;
   display:block;
   width:95px;
   height:41px;
   text-decoration:none;
   outline:none;
   font-size:16px;
   color:#555;
   float:left;
   line-height:41px;
   padding-left:47px;
 }
 .book_wrapper a.demo{
   margin-left:50px;
 }
 .book_wrapper a.article:hover,
 .book_wrapper a.demo:hover{
   background-position:50% -41px;
   color:#13386a;
 }
 .book_wrapper img{
   margin:10px 0px 5px 35px;
   width:300px;
   padding:4px;
   border:1px solid #ddd;
   -moz-box-shadow:1px 1px 1px #fff;
   -webkit-box-shadow:1px 1px 1px #fff;
   box-shadow:1px 1px 1px #fff;
 }
 .booklet .b-wrap-right img{
   border:1px solid #E6E3C2;
 }
 a#next_page_button,
 a#prev_page_button{
   display:none;
   position:absolute;
   width:41px;
   height:40px;
   cursor:pointer;
   margin-top:-20px;
   top:50%;
   background:transparent url(/images/buttons.png) no-repeat 0px -40px;
 }
 a#prev_page_button{
   left:-30px;
 }
 a#next_page_button{
   right:-30px;
   background-position:-41px -40px;
 }
 a#next_page_button:hover{
   background-position:-41px 0px;
 }
 a#prev_page_button:hover{
   background-position:0px 0px;
 }
 .imgBook
 {
  display: none;
 }
 .content
 {
  height: 100%;
  background-size: cover; 

 }


.book_wrapper {

  width: 80%;
    margin: 0 auto;
    padding-top: 50px;
    width: 905px;
    height: 540px;
    position: relative;
    background: transparent url(/images/bg.png) no-repeat 5px 27px;
}
.left {
  width: 20%;

}
h1.sutraName{

    animation: sutraName;
    animation-duration: 1s;
    
    
}
@keyframes sutraName {
  0%   {transform: translateX(-200%)}
  100% {transform: translateX(0)}
}



          </style>
      
   
     <body>
            <a href="/kinhphat" class="go_back">
                <img class="_w-12 _ml-5 _mt-2" src="/image/back.png" alt="">
              </a>
        <div class="content content_mobile lg:_flex-row sm:_flex sm:_flex-col  md:_flex w-full" >
       
          <div class="  left  _mx-auto _text-white _w-1/3">
              <h1 class=" _text-black sutraName _pl-[50px] transition ease-in-out">{{$sutra->name  }}</h1>
              <img class="_p-9" src="/image/buddha-moi.gif" alt="">
              <img class="_ml-24 _w-1/2" src="/image/hiennay.png" alt="">
             

            
          </div>
          <div class="_w-4/5 sm:_w-full">
            <div class="book_wrapper  ">
          
                  
                <div id="mybook" style="display:none;">
                  <div class="b-load">
                  @for($i = 0 ; $i < count($contentChunks)-1 ; $i = $i+2)
                    <div class="book">
                      <img class="imgBook" src="/images/1.jpg" alt=""/>
                      
                      <p>{!!$contentChunks[$i]!!}</p>
                  
                    </div>
                    <div class="book">
                      <img class="imgBook"   src="/images/2.jpg" alt="" />
                      
                      <p >{!!$contentChunks[$i+1]!!}</p>
                      
                       
                    </div>
                    @endfor
                  
                  </div>
                 
                </div>
             
            </div>
            <div class="comment _flex _justify-end _pr-5">
              
               
              
                <img onclick="firstModal.showModal()" class="fixed  _w-16 _h-16 " src="/image/comment.png" alt="">
          
        </div>
              </div>


            

              <dialog id="firstModal" class=" _relative  _mt-10 _p-10 _border-2 _border-gray-300 _w-1/2 _mx-auto">
                <div class="_grid ">
                  
               
                   <textarea name="" id="" cols="30" rows="10"></textarea>
                   <div class="_flex _justify-end" ><button class="_mt-5 _bg-white _hover:_bg-gray-100 _text-gray-800 _font-semibold _py-2 _px-4 _w-[10%] _border _border-gray-400 _rounded _shadow">
                      Save
                    </button></div>
                    <p onclick="firstModal.close()" class="  ">
                      <img class="_fixed _top-5 _right-[21%] _w-10 _h-10" src="/image/remove.png" alt="">
                    </p>
                  </div>
                </div>
              </dialog>

   

  </div>
</div>
        </div>        
        </div>
    
         <script type="text/javascript">
       $(function() {
         var $mybook 		= $('#mybook');
         var $bttn_next		= $('#next_page_button');
         var $bttn_prev		= $('#prev_page_button');
         var $loading		= $('#loading');
         var $mybook_images	= $mybook.find('img');
         var cnt_images		= $mybook_images.length;
         var loaded			= 0;
          
         $mybook_images.each(function(){
           var $img 	= $(this);
           var source	= $img.attr('src');
           $('<img/>').load(function(){
             ++loaded;
             if(loaded == cnt_images){
               $loading.hide();
               $bttn_next.show();
               $bttn_prev.show();
               $mybook.show().booklet({
                 name:               null,                            //  
                 width:              800,                             //  
                 height:             500,                             //   
                 speed:              600,                             //  
                 direction:          'LTR',                           //  
                                            //  
                 next:               $bttn_next,          			//  
                 prev:               $bttn_prev,          			//  
                                        
               });
               Cufon.refresh();
             }
           }).attr('src',source);
         });
         
       });
       tailwind.config = {
        corePlugins: {
          preflight: false,
        },
        prefix: '_',
      }

         </script>
  
     </body>
  
 </html>