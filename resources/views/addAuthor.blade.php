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
                            <form class="p-5 bg-white rounded-xl shadow-xl" method="post" action="/addAuthorSutras" enctype="multipart/form-data">
                            @csrf
                                <p class="text-lg text-gray-800 font-medium pb-4">Customer information</p>
                                <div class="pb-5">
                                    <label class="block text-sm text-gray-600" for="cus_name"> Name Author</label>
                                    <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="cus_name" name="name" type="text"  placeholder="Sutra Name" >
                                </div>
                               
                                <label for="message" class="block text-sm text-gray-600">Information Author</label>
                                <textarea name="information" id="message " rows="4" class=" bg-gray-200 block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Content Sutra"></textarea>
                                
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