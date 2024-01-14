<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>
<body>
<section class="text-gray-600 body-font overflow-hidden">
  
  <div class=" w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
            <h2 class="text-sm text-center title-font text-gray-500 tracking-widest">{{$sutra->type_name}}</h2>
            <h1 class="text-gray-900 text-center text-3xl title-font font-medium mb-1">{{$sutra->name}}</h1>
            <p class="leading-relaxed">{{$sutra->content}}</p>
        </div>
        <div class="container px-5 py-24 mx-auto flex">
         
        

    <div class="w-full ">
        <img alt="ecommerce" class=" w-full h-auto  object-cover object-center rounded" src="/productsphotos/{{$sutra->image}}">
    </div>
    <div class="pagination">
    {{$contentChunks->links() }}
    </div>


</div>
</section>
    
</body>
</html>