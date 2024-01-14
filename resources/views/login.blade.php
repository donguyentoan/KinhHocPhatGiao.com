
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form in HTML and CSS | Codehal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css">
</head>

<body class="bg-cover bg-center bg-fixed" style="background-image: url('/image/img.jpg')">
    <div class="min-h-screen flex items-center justify-center">
        <div class="w-96 bg-white bg-opacity-70 rounded-lg p-8 border-2 border-white">
            <h2 class="text-3xl font-semibold mb-4 text-center">Log in</h2>
            <form>
                <div class="mb-4 relative">
                    <input class="border border-gray-300 rounded-lg w-full py-2 pl-10 pr-3 focus:outline-none focus:border-blue-500"
                        type="email" placeholder="Email">
                </div>
                <div class="mb-4 relative">
                    <input class="border border-gray-300 rounded-lg w-full py-2 pl-10 pr-3 focus:outline-none focus:border-blue-500"
                        type="password" placeholder="Password">
                   
                </div>
                <div class="mb-4 flex items-center justify-between">
                    <label class="flex items-center space-x-2 text-gray-600">
                        <input type="checkbox" class="form-checkbox text-blue-500">
                        <span>Remember</span>
                    </label>
                    <a href="#" class="text-blue-500">Forgot Password</a>
                </div>
                <button
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg transition duration-300 ease-in-out transform hover:scale-105">
                    Log in
                </button>
                <p class="text-center mt-4">Don't have an account? <span class="font-semibold text-blue-500">Register</span></p>
            </form>
        </div>
    </div>
</body>


</html>
