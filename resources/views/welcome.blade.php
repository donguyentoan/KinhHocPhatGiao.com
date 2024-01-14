
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<style>
.bg1 a:hover{
    background: transparent url(https://www.daophatngaynay.com/logo2_eng.gif) no-repeat 0 0;
}
.bg1  a{
    background: transparent url(https://www.daophatngaynay.com/logo2_eng.gif) no-repeat 0% 100%;
    /* text-indent: -9999px; */
    display: block;
    width: 232px;
    height: 135px;
    outline: none;
}
.bg2 a:hover{
    background: transparent url(https://www.daophatngaynay.com/logo2_vn.gif) no-repeat 0 0;
}
.bg2  a{
    background: transparent url(https://www.daophatngaynay.com/logo2_vn.gif) no-repeat 0% 100%;
    /* text-indent: -9999px; */
    display: block;
    width: 232px;
    height: 135px;
    outline: none;
}

</style>
<body class="bg-[#fcfec4]">
    <section >
        <div class="container px-5 py-5 mx-auto ">
                <div>
                    <div class="flex justify-center">
                        <img class="h-64" src="https://www.daophatngaynay.com/buddha-moi.gif" alt="">
                    </div>
                    <div class="flex justify-center">
                        <div onmouseover="hover()" onmouseout="cenhover()"  id="title" class="title bg1 p-2 ">
                            <a href="/kinhphat" title="Đạo Phật Ngày Nay" rel="1" class="tooltip"></a></div>
                        <div class="p-2">
                            <img src="https://www.daophatngaynay.com/logo_tron.gif" alt="">
                        </div>
                        <div onmouseover="hover()" onmouseout="cenhover()"  id="title" class=" bg2 p-2 ">
                            <a  href="/kinhphat" title="Đạo Phật Ngày Nay" rel="1" class="tooltip group"></a></div>
                        </div>
                    </div>

                </div>
                <div id="banner" class="banner flex justify-center mb-5 ">
                       
                </div>
        </div>
    </section>


<script>
    const banner = document.getElementById('banner');
    function hover()
    { 
        
        banner.innerHTML = ` <img src="https://www.daophatngaynay.com/lang_viet.gif" alt="">`
    }
     function cenhover()
    { 
        
        banner.innerHTML = ``
    }
</script>
    
</body>

</html>