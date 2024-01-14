<!DOCTYPE html>
<html lang="en">
<head>
   @include('head')
</head>
<body>
    @include('header')
    <div class="container mx-auto pt-24 pb-24">
        <p class="ifauthor">
            {{$author->information}}
            
        </p>
    </div>

    @include('footer')
    
</body>
</html>