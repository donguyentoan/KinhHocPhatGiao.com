<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-400">
<div class="w-full lg:w-1/2 mt-6 pl-0 lg:pl-2 mx-auto">
                      
                        <div class="leading-loose">
                            <form class="p-5 bg-white rounded-xl shadow-xl" method="post" action="/addSutras" enctype="multipart/form-data">
                            @csrf
                            
                                <p class="text-lg text-gray-800 font-medium pb-4">Customer information</p>
                                <div class="pb-5">
                                    <label class="block text-sm text-gray-600" for="cus_name">Sutra Name</label>
                                    <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="cus_name" name="name" type="text"  placeholder="Sutra Name" >
                                </div>
                               
                                <label for="message" class="block text-sm text-gray-600">Content Sutra</label>
                                <textarea name="content" id="message " rows="4" class=" bg-gray-200 block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Content Sutra"></textarea>
                                <label for="cars">Choose a type:</label>
                                <br>

                                <select name="type_id" class=" bg-gray-200 w-full h-10 border-2 border-gray-300" id="cars"> 
                                <option value="1">Kinh Điển</option>
                                <option value="2">Sách Thiền Tập</option>
                              
                                
                                </select>
                               
                                <label for="cars">Choose a Author:</label>
                                <br>

                                <select name="athor_id" class=" bg-gray-200 w-full h-10 border-2 border-gray-300" id="cars"> 
                                @foreach($authorsutras as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                                <!-- <option value="2">Thích Nhật Từ </option>
                                <option value="3">Thích Trí Tịnh</option>
                                <option value="4">Thích Pháp Hòa</option> -->
                                </select>
                                <label for="cars">Choose a Language:</label>
                                <br>

                                <select  name="language_id" class=" bg-gray-200 mb-4 w-full h-10 border-2 border-gray-300" id="cars"> 
                                <option value="1">Tiếng Việt</option>
                              
                                
                                </select>

                                <label class="" for="cars">Choose a Image:</label><br>
                                <input name="image"  type="file"  id="">

                            
                                <div class="mt-6 flex justify-end">
                                    <button class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded" type="submit">Save</button>
                                </div>
                            </form>
                        </div>
                       
                    </div>
    
</body>
</html>