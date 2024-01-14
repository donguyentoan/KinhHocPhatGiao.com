<nav class="w-full text-gray-600 body-font bg-[#e483158f]">
    <div class="xl:max-w-6xl mx-auto px-4">
      <div class="flex justify-between">
          <div class="flex space-x-4">

            <!-- logo -->
            <div>
            <a href="/kinhphat" class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
       
       <img class="w-30 h-16"  src="/image/logothb.png" alt="">
       <!-- <span class="ml-3 text-xl">Tailblocks</span> -->
     </a>
            </div>

            <!-- primary nav -->
            <div class="hidden md:flex items-center space-x-1">
                <a href="/kinhphat" class="text-white pr-5 hover:text-gray-900">Kinh Phật </a>
                <a href="/introduce" class="text-white pr-5 hover:text-gray-900">Giới Thiệu</a>
                <a href="/tacgia" class=" text-white pr-5 hover:text-gray-900">Tác Giả</a>
                <a href="/contact" class="text-white pr-5 hover:text-gray-900">Liên Hệ</a>
               


            </div>
          </div>
        
          <!-- secondary nav -->
          <div class="hidden md:flex items-center space-x-1">
          <div class=" relative mx-auto text-gray-600 mr-10">
                    <input class="border-2 border-gray-300 bg-white h-8 px-5 pr-16 rounded-lg text-sm focus:outline-none"
                      type="search" name="search" placeholder="Tìm Kiếm Kinh Sách ...">
                    <button type="submit" class="absolute -right-2 -top-3 mt-5 mr-4">
                      <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"
                        viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve"
                        width="512px" height="512px">
                        <path
                          d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                      </svg>
                    </button>
                </div>
          <a href="/kinhphat"> <button class=" hidden_mobile inline-flex items-center  text-white  border-2 bg-[#f69220] py-1 px-3 focus:outline-none hover:bg-gray-200 rounded-[5px] text-base mt-4 md:mt-0">Kinh Phật
    </button></a>
          </div>
        
          <!-- mobile button goes here -->
          <div class="md:hidden flex items-center">
            <button class="mobile-menu-button">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
            </button>
            
          </div>
       </div>
    </div>

    <!-- mobile menu -->
    <div class="mobile-menu hidden md:hidden">
      
      <a href="/kinhphat" class="block py-2 px-4 text-sm hover:bg-gray-200">Kinh Phật </a>
      <a href="/introduce" class="block py-2 px-4 text-sm hover:bg-gray-200">Giới Thiệu</a>
      <a href="/tacgia" class=" block py-2 px-4 text-sm hover:bg-gray-200">Tác Giả</a>
      <a href="/contact" class="block py-2 px-4 text-sm hover:bg-gray-200">Liên Hệ</a>
    </div>
</nav>



<script>
  const btn = document.querySelector('button.mobile-menu-button');
const menu = document.querySelector('.mobile-menu');

// add event listners
btn.addEventListener("click",()=>{
  menu.classList.toggle("hidden");
});
</script>

    <style>
      @media only screen and (max-width: 414px) {
      .hidden_mobile{
  display: none !important;
  
 }
 .pbmobile{
  padding-bottom:30px;
 }
 .ifauthor{
  padding: 20px;
 }
}

    </style>
   
   
  </div>
