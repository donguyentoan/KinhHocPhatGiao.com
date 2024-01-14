<!DOCTYPE html>
<html lang="en">
@include('/head')
<style>
  @media only screen and (max-width: 414px) {
 .sutra{
  width: 373px;

 }
 body{
  width: 400px;
 }
 .hidden_mobile{
  display: none !important;
 }
 .pbmobile{
  padding-bottom:30px;
 }
 
}

</style>
<body>



@include('header')
<section class="text-gray-600 body-font">
    <div class="container py-16 px-5  mx-auto border-b-2 border-gray-300">
      <h1 class="text-xl font-medium  text-black  my-4 w-40 border-b-2 border-red-500">Kinh Sách Đề Cử</h1>
                    <div class="flex flex-wrap -m-4">
                            @foreach($sutraslimit as $item)
                              <div class="p-4 md:w-1/4">
                                <div class=" sutra h-full border-[1px] border-gray-200 border-opacity-60 rounded-lg overflow-hidden pt-2">
                                  <img class="md:h-[300px] w-full object-contain object-center hover:scale-110" src="/productsphotos/{{$item->image}}" alt="blog">
                                  <div class="p-6">
                                    <h2 class="tracking-widest text-xs title-font font-medium text-gray-400 mb-1">{{$item->type_name}}</h2>
                                    <h1 class="title-font text-base font-medium text-gray-900 mb-3">{{$item->name}}</h1>
                                  
                                    <div class="flex items-center flex-wrap ">
                                      <a href="/sutraDetail/{{$item->id}}" class="text-indigo-500 inline-flex items-center md:mb-2 lg:mb-0">Read More
                                        <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                          <path d="M5 12h14"></path>
                                          <path d="M12 5l7 7-7 7"></path>
                                        </svg>
                                      </a>
                                      <span class="text-gray-400 mr-3 inline-flex items-center lg:ml-auto md:ml-0 ml-auto leading-none text-sm pr-3 py-1 border-r-2 border-gray-200">
                                        <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                          <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                          <circle cx="12" cy="12" r="3"></circle>
                                        </svg>0.0K
                                      </span>
                                      <span class="text-gray-400 inline-flex items-center leading-none text-sm">
                                        <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                          <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"></path>
                                        </svg>0
                                      </span>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              @endforeach
                    </div>
    </div>
</section>
<section class="text-gray-600 body-font">
  <div class="container px-5 py-10 mx-auto">
  <h1 class="text-xl font-medium  text-black my-4 w-56 border-b-2 border-red-500">Kinh Sách Mới Cập Nhật</h1>
       <div class="flex">
            <div class="w-3/4">
                            <div class="flex flex-wrap -m-4">
                          @foreach($sutras as $item)
                            <div class="p-4 md:w-1/3">
                              <div class=" sutra h-full border-[1px] border-gray-200 border-opacity-60 rounded-lg overflow-hidden pt-2">
                                <img class="md:h-[300px] w-full object-contain object-center hover:scale-110" src="/productsphotos/{{$item->image}}" alt="blog">
                                <div class="p-6">
                                  <h2 class="tracking-widest text-xs title-font font-medium text-gray-400 mb-1">{{$item->type_name}}</h2>
                                  <h1 class="title-font text-base font-medium text-gray-900 mb-3">{{$item->name}}</h1>
                                
                                  <div class="flex items-center flex-wrap ">
                                    <a href="/sutraDetail/{{$item->id}}" class="text-indigo-500 inline-flex items-center md:mb-2 lg:mb-0">Learn More
                                      <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14"></path>
                                        <path d="M12 5l7 7-7 7"></path>
                                      </svg>
                                    </a>
                                    <span class="text-gray-400 mr-3 inline-flex items-center lg:ml-auto md:ml-0 ml-auto leading-none text-sm pr-3 py-1 border-r-2 border-gray-200">
                                      <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                      </svg>0.0K
                                    </span>
                                    <span class="text-gray-400 inline-flex items-center leading-none text-sm">
                                      <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"></path>
                                      </svg>0
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>
                            @endforeach
                          </div>
                      </div>
            <div class="w-1/4 ml-3">
              <div class="sutra-box p-3 border-[1px] border-gray-200 rounded-md">
                    <h2 class="  title text-xl font-bold text-black my-4 w-48 border-b-2 border-red-500">Kinh Sách Mới Đăng </h2>
                    <div class="row">
                      <div class="book">
                        <div class="menu-item flex  items-center py-3">
                          <div class="top-trending w-9 h-9 px-2 mr-3 rounded-full bg-red-500 flex justify-center items-center text-white"> 1</div>
                            <h3 class="title">
                              <a class="font-medium text-xs" href="/tuyet-pham-thien-y/" title="Tuyệt Phẩm Thiên Y - Giang Nguyên">KINH THỰC TẬP VÔ NGÃ</a>
                            </h3>
                        </div>
                        <div class="menu-item flex  items-center py-3">
                          <div class="top-trending w-9 h-9 px-2 mr-3 rounded-full bg-red-500 flex justify-center items-center text-white"> 2</div>
                            <h3 class="title">
                              <a class="font-medium text-xs" href="/tuyet-pham-thien-y/" title="Tuyệt Phẩm Thiên Y - Giang Nguyên">KINH THỰC TẬP VÔ NGÃ</a>
                            </h3>
                        </div>
                        <div class="menu-item flex  items-center py-3">
                          <div class="top-trending w-9 h-9 px-2 mr-3 rounded-full bg-red-500 flex justify-center items-center text-white"> 3</div>
                            <h3 class="title">
                              <a class="font-medium text-xs" href="/tuyet-pham-thien-y/" title="Tuyệt Phẩm Thiên Y - Giang Nguyên">KINH THỰC TẬP VÔ NGÃ</a>
                            </h3>
                        </div>
                       
                    
                       
                      </div>
                      
                    </div>
              </div>
              
            
        
            </div>
            
       </div>
           
   
  </div>
</section>
 <section class="text-gray-600 body-font">

            <div class="container py-5 px-5  mx-auto">
                  <h1 class="text-xl font-medium  text-black  my-4 w-44 border-b-2 border-red-500">Kinh Sách Đã Đọc</h1>
                  <div class="flex">
                    
                 
                        <div class="w-3/4">
                          <div class="flex justify-between ">
                                <div class="w-1/3">
                                    <div class="box-item">
                                        <div class="flex">
                                            <div class="  mr-2  ">
                                                <img class="h-32 " src="/image/nuphu.jpeg" alt="">
                                        </div>
                                        <div class=" ml-2 ">
                                            <p class="text-xs border-[1px] mb-2 border-blue-400 text-center rounded-md text-black py-1 px-2 w-32">Kinh Phật</p>
                                            <h1 class="text-base  pb-2 font-medium">Kinh Phật Căn Bản</h1>
                                            <div class="flex  items-center"> 
                                                <img class="w-3 h-3 mr-1" src="/image/star.png" alt="">
                                                <p class="text-xs" >0/10</p> 
                                            </div>
                                        </div>
                                        </div>
                                      
                                    </div>
                                </div>
                                <div class="w-1/3">
                                    <div class="box-item">
                                        <div class="flex">
                                            <div class="  mr-2  ">
                                                <img class="h-32 " src="/image/nuphu.jpeg" alt="">
                                        </div>
                                        <div class=" ml-2 ">
                                            <p class="text-xs border-[1px] mb-2 border-blue-400 text-center rounded-md text-black py-1 px-2 w-32">Kinh Phật</p>
                                            <h1 class="text-base  pb-2 font-medium">Kinh Phật Căn Bản</h1>
                                            <div class="flex  items-center"> 
                                                <img class="w-3 h-3 mr-1" src="/image/star.png" alt="">
                                                <p class="text-xs" >0/10</p> 
                                            </div>
                                        </div>
                                        </div>
                                      
                                    </div>
                                </div>
                                <div class="w-1/3">
                                    <div class="box-item">
                                        <div class="flex">
                                            <div class="  mr-2  ">
                                                <img class="h-32 " src="/image/nuphu.jpeg" alt="">
                                        </div>
                                        <div class=" ml-2 ">
                                            <p class="text-xs border-[1px] mb-2 border-blue-400 text-center rounded-md text-black py-1 px-2 w-32">Kinh Phật</p>
                                            <h1 class="text-base  pb-2 font-medium">Kinh Phật Căn Bản</h1>
                                            <div class="flex  items-center"> 
                                                <img class="w-3 h-3 mr-1" src="/image/star.png" alt="">
                                                <p class="text-xs" >0/10</p> 
                                            </div>
                                        </div>
                                        </div>
                                      
                                    </div>
                                </div>
                                
                                
                          </div>
                          <div class="flex justify-between pt-10">
                                <div class="w-1/3">
                                    <div class="box-item">
                                        <div class="flex">
                                            <div class="  mr-2  ">
                                                <img class="h-32 " src="/image/nuphu.jpeg" alt="">
                                        </div>
                                        <div class=" ml-2 ">
                                            <p class="text-xs border-[1px] mb-2 border-blue-400 text-center rounded-md text-black py-1 px-2 w-32">Kinh Phật</p>
                                            <h1 class="text-base  pb-2 font-medium">Kinh Phật Căn Bản</h1>
                                            <div class="flex  items-center"> 
                                                <img class="w-3 h-3 mr-1" src="/image/star.png" alt="">
                                                <p class="text-xs" >0/10</p> 
                                            </div>
                                        </div>
                                        </div>
                                      
                                    </div>
                                </div>
                                <div class="w-1/3">
                                    <div class="box-item">
                                        <div class="flex">
                                            <div class="  mr-2  ">
                                                <img class="h-32 " src="/image/nuphu.jpeg" alt="">
                                        </div>
                                        <div class=" ml-2 ">
                                            <p class="text-xs border-[1px] mb-2 border-blue-400 text-center rounded-md text-black py-1 px-2 w-32">Kinh Phật</p>
                                            <h1 class="text-base  pb-2 font-medium">Kinh Phật Căn Bản</h1>
                                            <div class="flex  items-center"> 
                                                <img class="w-3 h-3 mr-1" src="/image/star.png" alt="">
                                                <p class="text-xs" >0/10</p> 
                                            </div>
                                        </div>
                                        </div>
                                      
                                    </div>
                                </div>
                                <div class="w-1/3">
                                    <div class="box-item">
                                        <div class="flex">
                                            <div class="  mr-2  ">
                                                <img class="h-32 " src="/image/nuphu.jpeg" alt="">
                                        </div>
                                        <div class=" ml-2 ">
                                            <p class="text-xs border-[1px] mb-2 border-blue-400 text-center rounded-md text-black py-1 px-2 w-32">Kinh Phật</p>
                                            <h1 class="text-base  pb-2 font-medium">Kinh Phật Căn Bản</h1>
                                            <div class="flex  items-center"> 
                                                <img class="w-3 h-3 mr-1" src="/image/star.png" alt="">
                                                <p class="text-xs" >0/10</p> 
                                            </div>
                                        </div>
                                        </div>
                                      
                                    </div>
                                </div>
                                
                                
                          </div>
                          <div class="flex justify-between pt-10">
                                <div class="w-1/3">
                                    <div class="box-item">
                                        <div class="flex">
                                            <div class="  mr-2  ">
                                                <img class="h-32 " src="/image/nuphu.jpeg" alt="">
                                        </div>
                                        <div class=" ml-2 ">
                                            <p class="text-xs border-[1px] mb-2 border-blue-400 text-center rounded-md text-black py-1 px-2 w-32">Kinh Phật</p>
                                            <h1 class="text-base  pb-2 font-medium">Kinh Phật Căn Bản</h1>
                                            <div class="flex  items-center"> 
                                                <img class="w-3 h-3 mr-1" src="/image/star.png" alt="">
                                                <p class="text-xs" >0/10</p> 
                                            </div>
                                        </div>
                                        </div>
                                      
                                    </div>
                                </div>
                                <div class="w-1/3">
                                    <div class="box-item">
                                        <div class="flex">
                                            <div class="  mr-2  ">
                                                <img class="h-32 " src="/image/nuphu.jpeg" alt="">
                                        </div>
                                        <div class=" ml-2 ">
                                            <p class="text-xs border-[1px] mb-2 border-blue-400 text-center rounded-md text-black py-1 px-2 w-32">Kinh Phật</p>
                                            <h1 class="text-base  pb-2 font-medium">Kinh Phật Căn Bản</h1>
                                            <div class="flex  items-center"> 
                                                <img class="w-3 h-3 mr-1" src="/image/star.png" alt="">
                                                <p class="text-xs" >0/10</p> 
                                            </div>
                                        </div>
                                        </div>
                                      
                                    </div>
                                </div>
                                <div class="w-1/3">
                                    <div class="box-item">
                                        <div class="flex">
                                            <div class="  mr-2  ">
                                                <img class="h-32 " src="/image/nuphu.jpeg" alt="">
                                        </div>
                                        <div class=" ml-2 ">
                                            <p class="text-xs border-[1px] mb-2 border-blue-400 text-center rounded-md text-black py-1 px-2 w-32">Kinh Phật</p>
                                            <h1 class="text-base  pb-2 font-medium">Kinh Phật Căn Bản</h1>
                                            <div class="flex  items-center"> 
                                                <img class="w-3 h-3 mr-1" src="/image/star.png" alt="">
                                                <p class="text-xs" >0/10</p> 
                                            </div>
                                        </div>
                                        </div>
                                      
                                    </div>
                                </div>
                                
                                
                          </div>
                      </div>

                      <div class="w-1/4 mx-auto  text-cyan-500">
                        <div class="full-tab w-full">
                        <ul id="tabs" class="inline-flex p-2   w-80  ">
                          <li class=" w-28   text-center   cursor-pointer rounded-t-md  -mb-2 bg-white active" tab-to="first">
                            Tranding 
                          </li>
                          <li class="w-28  text-center p-1 cursor-pointer" tab-to="second">
                            Comment 
                          </li>
                          <li class=" w-28  text-center p-1 cursor-pointer" tab-to="third">
                            Laster
                          </li>
                        </ul>
                                  
                        <div id="tab-contents" class="w-[304px]  ml-[8px]  border-t-[1px]    border-l-[1px] border-r-[1px] border-[#06b6d4]">
                          <div class=" active" tab-id="first">
                            <div class="item  p-5 flex  border-b-[1px] border-gray-200">
                                <div class="w-1/2">
                                    <img class="w-16" src="/image/nuphu.jpeg" alt="">
                                </div>
                                <div class="w-1/2 ">
                                    <h1 class="text-base">kieu nu 0</h1>
                                </div>
                            </div>
                            <div class="item p-5 flex  border-b-[1px] border-gray-200">
                                <div class="w-1/2">
                                    <img class="w-16" src="/image/nuphu.jpeg" alt="">
                                </div>
                                <div class="w-1/2 ">
                                    <h1 class="text-base">kieu nu 0</h1>
                                </div>
                            </div>
                            <div class="item p-5 flex  border-b-[1px] border-gray-200">
                                <div class="w-1/2">
                                    <img class="w-16" src="/image/nuphu.jpeg" alt="">
                                </div>
                                <div class="w-1/2 ">
                                    <h1 class="text-base">kieu nu 0</h1>
                                </div>
                            </div>
                           
                          
                          </div>
                          <div class=" hidden" tab-id="second">
                          <div class="item p-5 flex  border-b-[1px] border-gray-200">
                                <div class="w-1/2">
                                    <img class="w-16" src="/image/nuphu.jpeg" alt="">
                                </div>
                                <div class="w-1/2 ">
                                    <h1 class="text-base">kieu nu 1</h1>
                                </div>
                            </div>
                            <div class="item p-5 flex  border-b-[1px] border-gray-200">
                                <div class="w-1/2">
                                    <img class="w-16" src="/image/nuphu.jpeg" alt="">
                                </div>
                                <div class="w-1/2 ">
                                    <h1 class="text-base">kieu nu 1</h1>
                                </div>
                            </div>
                            <div class="item  p-5 flex  border-b-[1px] border-gray-200">
                                <div class="w-1/2">
                                    <img class="w-16" src="/image/nuphu.jpeg" alt="">
                                </div>
                                <div class="w-1/2 ">
                                    <h1 class="text-base">kieu nu 1</h1>
                                </div>
                            </div>
                          </div>
                          <div class=" hidden" tab-id="third">
                          <div class="item flex p-5  border-b-[1px] border-gray-200">
                                <div class="w-1/2">
                                    <img class="w-16" src="/image/nuphu.jpeg" alt="">
                                </div>
                                <div class="w-1/2 ">
                                    <h1 class="text-base">kieu nu 2</h1>
                                </div>
                            </div>
                            <div class="item flex p-5 border-b-[1px] border-gray-200">
                                <div class="w-1/2">
                                    <img class="w-16" src="/image/nuphu.jpeg" alt="">
                                </div>
                                <div class="w-1/2 ">
                                    <h1 class="text-base">kieu nu 2</h1>
                                </div>
                            </div>
                            <div class="item flex p-5 border-b-[1px] border-gray-200">
                                <div class="w-1/2">
                                    <img class="w-16" src="/image/nuphu.jpeg" alt="">
                                </div>
                                <div class="w-1/2 ">
                                    <h1 class="text-base">kieu nu 2</h1>
                                </div>
                            </div>
                          </div>
                        </div>
                        </div>
                      
                        
                      </div>
                     
                  </div>
                 
            </div>
             
    
            </section>





@include('footer')

<script>
function scrolls() {
  
    window.scrollTo({
      top: 0, 
      behavior: 'smooth'
      /* you can also use 'auto' behaviour
         in place of 'smooth' */
    });
  };
  function showmessage()
  {
   
  
    var showmes = document.getElementById('showmes');
    if (showmes) {
      showmes.style.display = 'block';
    }


  }
  function sendbtn() {
  
  var printtext = document.getElementById('chatmsg');
  var copytext = document.getElementById('typemsg');
  var currentdate = new Date();
  
  var copiedtext = copytext.value;
  
  var printnow = '<div class="flex justify-end pt-2 pl-10">'+'<span class="bg-green-900 p-2 h-auto text-gray-200 text-xs font-normal rounded-md px-1 items-end flex justify-end overflow-hidden " style="font-size: 10px;">'+copiedtext+'<span class="text-gray-400 pl-1" style="font-size: 8px;">'+currentdate.getHours()+':'+currentdate.getMinutes()+'</span>'+'</span>'+'</div>';
  
  printtext.insertAdjacentHTML('beforeend', printnow);
  
  var box = document.getElementById('journal-scroll');
  box.scrollTop = box.scrollHeight;
}
document.querySelectorAll('#tabs [tab-to]').forEach(function(item) {
    item.addEventListener('click', function(e) {
        let link = this.getAttribute('tab-to');
        let active_content = document.querySelector('#tab-contents .active');
        let tab_el = document.querySelector('#tab-contents [tab-id="' + link + '"]');
        let active_tab = document.querySelector('#tabs .active')

        active_content.classList.remove("active");
        active_content.classList.add("hidden");
        
        tab_el.classList.remove("hidden");
        tab_el.classList.add("active");

        active_tab.classList.remove("active", "rounded-t-md", "border-t", "border-l", "border-r", "border-b" , "-mb-2", "bg-white" , "border-[#06b6d4]");
        this.classList.add("active", "rounded-t-md", "border-t", "border-l", "border-r", "-mb-2" , "border-b",  "bg-white" , "border-[#06b6d4]" );
    });
});
</script>
</body>
</html>