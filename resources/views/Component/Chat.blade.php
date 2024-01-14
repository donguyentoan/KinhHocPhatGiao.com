<style>
  #journal-scroll::-webkit-scrollbar {
    width: 6px;
    cursor: pointer;
  }
  
  #journal-scroll::-webkit-scrollbar-track {
    background-color: rgba(229, 231, 235 var(--bg-opacity));
    cursor: pointer;
  }
  
  #journal-scroll::-webkit-scrollbar-thumb {
    cursor: pointer;
    background-color: #a0aec0;
  }
</style>
<div id="showmes" class="h-screen fixed top-0  right-20 hidden">
   
  <div class="flex justify-center items-center h-screen ">
   
        <div class="w-80 h-96 bg-white rounded shadow-2xl">
            
            <nav class="w-full h-10  bg-[#e483158f] rounded-tr rounded-tl flex justify-between items-center">
                <div class="flex justify-center items-center"> <i class="mdi mdi-arrow-left font-normal text-white ml-1"></i> <img src="https://i.imgur.com/IAgGUYF.jpg" class="rounded-full ml-1" width="25" height="25"> <span class="text-xs font-medium  ml-1 text-white">Thiện Hoằng Bảo</span> </div>
                <div class="flex items-center"> <i class="mdi mdi-video text-gray-300 mr-4"></i> <i class="mdi mdi-phone text-gray-300 mr-2"></i> <i class="mdi mdi-dots-vertical text-gray-300 mr-2"></i> </div>
            </nav>
            <div class="overflow-auto px-1 py-1" style="height: 19rem;" id="journal-scroll">
                <div class="flex items-center pr-10"> <img src="https://i.imgur.com/IAgGUYF.jpg" class="rounded-full shadow-xl" width="15" height="15" style="box-shadow: "> <span class="flex ml-1 h-auto bg-gray-400 text-white text-xs font-normal rounded-md px-1 p-1 items-end ">Xin Chào Tôi Có Thể Giúp Gì Cho Bạn<span class="text-white pl-1" style="font-size: 8px;">01:25am</span></span> </div>
               
                <div class="text-xl p-3  " id="chatmsg"> </div>
            </div>
            <div class="flex justify-between items-center p-1 ">
                <div class="relative"> <i class="mdi mdi-emoticon-excited-outline absolute top-1 left-1 text-gray-400" style="font-size: 17px !important;font-weight: bold;"></i> <input type="text" class="rounded-full pl-6 pr-12 py-2 focus:outline-none h-auto placeholder-gray-100  border-[1px] border-gray-300 bg-gray-300 text-white" style="font-size: 11px;width: 250px;" placeholder="..." id="typemsg"> <i class="mdi mdi-paperclip absolute right-8 top-1 transform -rotate-45 text-gray-400"></i> <i class="mdi mdi-camera absolute right-2 top-1 text-gray-400"></i> </div>
                <div class="w-7 h-7 rounded-full bg-blue-300 text-center items-center flex justify-center hover:bg-gray-900 hover:text-white"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-mic-fill" viewBox="0 0 16 16">
  <path d="M5 3a3 3 0 0 1 6 0v5a3 3 0 0 1-6 0V3z"/>
  <path d="M3.5 6.5A.5.5 0 0 1 4 7v1a4 4 0 0 0 8 0V7a.5.5 0 0 1 1 0v1a5 5 0 0 1-4.5 4.975V15h3a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1h3v-2.025A5 5 0 0 1 3 8V7a.5.5 0 0 1 .5-.5z"/>
</svg> </div>
                <div class="w-7 h-7 rounded-full bg-blue-300 text-center items-center flex justify-center"> <button class="w-7 h-7 rounded-full text-center items-center flex justify-center focus:outline-none hover:bg-gray-900 hover:text-white" onclick="sendbtn();"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
  <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
</svg></button> </div>
            </div>
        </div>
    </div>
</div>"