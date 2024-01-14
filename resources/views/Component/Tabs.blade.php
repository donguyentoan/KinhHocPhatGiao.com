<script src="https://cdn.tailwindcss.com"></script>
<div class="flex flex-col gap-6 justify-center items-center w-full h-screen ">
 
  <div class="w-1/4 mx-auto mt-4 text-cyan-500">
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
      <div class="p-4 active" tab-id="first">
        <div class="item flex">
            <div class="w-1/2">
                <img class="w-16" src="/image/nuphu.jpeg" alt="">
            </div>
            <div class="w-1/2 ">
                <h1 class="text-base">kieu nu</h1>
            </div>
        </div>
        <div class="item flex">
            <div class="w-1/2">
                <img class="w-16" src="/image/nuphu.jpeg" alt="">
            </div>
            <div class="w-1/2 ">
                <h1 class="text-base">kieu nu</h1>
            </div>
        </div>
        <div class="item flex">
            <div class="w-1/2">
                <img class="w-16" src="/image/nuphu.jpeg" alt="">
            </div>
            <div class="w-1/2 ">
                <h1 class="text-base">kieu nu</h1>
            </div>
        </div>
       
      </div>
      <div class="p-4 hidden" tab-id="second">
      <div class="item flex">
            <div class="w-1/2">
                <img class="w-16" src="/image/nuphu.jpeg" alt="">
            </div>
            <div class="w-1/2 ">
                <h1 class="text-base">kieu nu 1</h1>
            </div>
        </div>
        <div class="item flex">
            <div class="w-1/2">
                <img class="w-16" src="/image/nuphu.jpeg" alt="">
            </div>
            <div class="w-1/2 ">
                <h1 class="text-base">kieu nu 1</h1>
            </div>
        </div>
        <div class="item flex">
            <div class="w-1/2">
                <img class="w-16" src="/image/nuphu.jpeg" alt="">
            </div>
            <div class="w-1/2 ">
                <h1 class="text-base">kieu nu 1</h1>
            </div>
        </div>
      </div>
      <div class="p-4 hidden" tab-id="third">
      <div class="item flex">
            <div class="w-1/2">
                <img class="w-16" src="/image/nuphu.jpeg" alt="">
            </div>
            <div class="w-1/2 ">
                <h1 class="text-base">kieu nu 2</h1>
            </div>
        </div>
        <div class="item flex">
            <div class="w-1/2">
                <img class="w-16" src="/image/nuphu.jpeg" alt="">
            </div>
            <div class="w-1/2 ">
                <h1 class="text-base">kieu nu 2</h1>
            </div>
        </div>
        <div class="item flex">
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

<script>
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