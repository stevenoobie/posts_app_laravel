<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'My App' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-[#ebebea] dark:bg-[#0a0a0a] text-[#1b1b18] min-h-screen flex justify-center items-center">

    <!-- Sidebar -->
   <div class="card rounded-lg p-6 h-min shadow bg-white ">
    {{ $slot }}
   </div>

 
</body>
</html>
