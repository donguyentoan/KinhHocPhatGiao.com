
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind Admin Template</title>
    <meta name="author" content="David Grzyb">
    <meta name="description" content="">

    <!-- Tailwind -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-family-karla flex">

    <!-- <aside class="relative bg-[#343a40] h-screen w-64 hidden sm:block shadow-xl">
        <div class="p-4">
            <a href="index.html" class="text-white text-xs font-semibold uppercase hover:text-gray-300">Admin</a>
        <div class="user-panel mt-3 pb-3 mb-3 flex border-b-2" style=" color: #343a40;">
        <div class="image ">
        <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="rounded-full  w-8 h-8 mr-2 elevation-2" alt="User Image">
        </div>
        <div class="info pt-1">
        <a href="#" class="d-block text-white ">Thien Hoang Bao</a>
        </div>
        </div>
        </div>
        <nav class="text-white text-base font-semibold pt-3">
            <a href="index.html" class="flex items-center active-nav-link text-white py-4 pl-6 nav-item">
                <i class="fas fa-tachometer-alt mr-3"></i>
                Dashboard
            </a>
            <a href="blank.html" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                <i class="fas fa-sticky-note mr-3"></i>
                SuTra
            </a>
            <a href="tables.html" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                <i class="fas fa-table mr-3"></i>
                Tables
            </a>
            <a href="forms.html" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                <i class="fas fa-align-left mr-3"></i>
                Forms
            </a>
            <a href="tabs.html" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                <i class="fas fa-tablet-alt mr-3"></i>
                Tabbed Content
            </a>
            <a href="calendar.html" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                <i class="fas fa-calendar mr-3"></i>
                Calendar
            </a>
        </nav>
        <a href="#" class="absolute w-full upgrade-btn bottom-0 active-nav-link text-white flex items-center justify-center py-4">
            <i class="fas fa-arrow-circle-up mr-3"></i>
            Upgrade to Pro!
        </a>
    </aside> -->

    @include('sidebar')


   
    <div class="w-full flex flex-col h-screen overflow-y-hidden">
    <table class="table table-striped projects">
   <thead>
    <div class="add flex justify-end">
    <h1 class=" w-24 m-5 mr-2 text-xs py-2 px-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md  focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75"> <a href="/addSutra">Create Sutra</a></h1>
    </div>
        
      <tr class="text-center">
         <th style="width: 11%">
            Image
         </th>
         <th style="width: 20%">
            Sutra Name
         </th>
         <th style="width: 20%">
            Language
         </th>
         <th>
            Athor
         </th>
         <th>
            Type
         </th>
        
         <th style="width: 20%"> Action</th>
      </tr>
   </thead>
   <tbody>
   
   @foreach($sutras as $item)

  
 
      <tr class="text-center ">
         <td class="p-5 ">
            <img class="w-10 mx-auto" src="/productsphotos/{{$item->image}}" alt="">
            
         </td>
         <td>
            <a>
            {{$item->name}}
            </a>
            <br>
            
         </td>
         <td>
           {{$item->language_name}}
           
         </td>
         <td>
         {{$item->athors_name}}
          
         </td>
         <td class="project_progress">
            <div class="progress progress-sm">
                  {{$item->type_name}}
            </div>
      
          
           
         </td>
         
         <td class="project-actions text-right">
            <a class=" mr-2 text-xs py-2 px-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md  focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75" href="/view/{{$item->id}}">
          
            <i class="  fas fa-folder">
            </i>
            
            View
            </a>
            <a class=" mr-2 text-xs py-2 px-2 bg-green-500 text-white font-semibold rounded-lg shadow-md  focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75" href="#">
            <i class="fas fa-pencil-alt">
            </i>
            Edit
            </a>
            <a class=" text-xs py-2 px-2 bg-red-500 text-white font-semibold rounded-lg shadow-md  focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75" href="/del/{{$item->id}}">
            <i class="fas fa-trash">
            </i>
            Delete
            </a>
         </td>
      </tr>
      @endforeach
    
    
   </tbody>
</table>
{{ $sutras->links() }}


    </div>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    <!-- ChartJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>

    <script>
        var chartOne = document.getElementById('chartOne');
        var myChart = new Chart(chartOne, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        var chartTwo = document.getElementById('chartTwo');
        var myLineChart = new Chart(chartTwo, {
            type: 'line',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</body>
</html>
