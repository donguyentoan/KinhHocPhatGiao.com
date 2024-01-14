<!DOCTYPE html>
<html lang="en">
<head>
    @include('/head')
</head>
<body>
    @include('header')

    
    <section class="text-gray-600 body-font">
  <div class="container px-5 py-24 mx-auto">
    <div class="flex flex-col text-center w-full mb-20">
      <h1 class="text-5xl font-medium title-font mb-4 text-gray-900">Tác Giả</h1>
      <p class="lg:w-2/3 mx-auto leading-relaxed text-base">Phật giáo có nhiều trường phái và vùng miền khác nhau trên thế giới, và có rất nhiều vị tu sĩ . Dưới đây là một số ví dụ về các vị tu sĩ Phật giáo </p>
    </div>
    <div class="flex flex-wrap -m-4">
        @foreach($author as $item)
      <div class="p-4 lg:w-1/4 md:w-1/2">
        <div class="h-full flex flex-col items-center text-center">
          <img alt="team" class=" md:w-10/12 w-[400px] h-[450px]  flex-shrink-0 rounded-lg  h-56 object-cover object-center mb-4 " src="/productsphotos/{{$item->image}}">
          <div class="w-full">
            <h2 class="title-font font-medium text-lg text-gray-900">{{$item->name}}</h2>
           
            <a href="/information/{{$item->id}}"><p class="mb-4 text-blue-500">  Thông Tin Chi Tiết</p></a> 
           
          </div>
        </div>
      </div>
      @endforeach
      
    </div>
  </div>
</section>
    


    @include('footer')
</body>
</html>