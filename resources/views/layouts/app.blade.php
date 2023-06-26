<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard</title>
    <style>
        /* Reset styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Header styles */
        header {
            background-color: #fff;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 10;
        }

        nav {
            display: flex;
            position: fixed;
            padding: 0 30px;
            background: white;
        }

        nav ul {
            display: flex;
            list-style: none;
        }

        nav ul li {
            margin-right: 20px;
        }

        nav ul li:last-child {
            margin-right: 0;
        }

        nav ul li a {
            display: block;
            padding: 10px;
            color: #333;
            text-decoration: none;
        }

        nav ul li a:hover {
            color: #666;
        }

        /* Sidebar styles */
        .wrapper {
            display: flex;
            flex-direction: row;
            align-items: stretch;
            margin-top: 60px;
            height: calc(100vh - 60px);
        }

        aside {
            background: #343a40;
            color: #fff;
            width: 250px;
            height: 100%;
        }

        aside .logo {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        aside .logo img {
            width: 50px;
            margin-right: 10px;
        }

        aside h1 {
            font-size: 1.5rem;
        }

        aside ul {
            list-style: none;
        }

        aside ul li {
            padding: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        aside ul li:last-child {
            border-bottom: none;
        }

        aside ul li a {
            color: #fff;
            display: block;
            text-decoration: none;
        }

        aside ul li.active a {
            font-weight: bold;
        }

        aside ul li span.badge {
            float: right;
            margin-top: 2px;
            margin-left: 10px;
            background-color: #f00;
            color: #fff;
            padding: 5px;
            border-radius: 50%;
        }

        aside ul li ul.submenu {
            display: none;
            list-style: none;
        }

        aside ul li:hover ul.submenu {
            display: block;
        }

        aside ul li ul.submenu li {
            padding: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        aside ul li ul.submenu li:last-child {
            border-bottom: none;
        }

        aside ul li ul.submenu li a {
            color: #fff;
        }

        main {
            flex: 1;
            background-color: #f5f5f5;
            padding-top: 60px;
        }
    </style>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body id="app">
    <header>
        <nav class="d-flex">
            <div class="logo text-white d-flex align-items-center justify-content-center"
                style="width:250px; background : #343a40; height : 60px;">
                <h2>{{ config('app.name') }}</h2>
            </div>
        </nav>
    </header>
    <div class="wrapper">
        <aside>
            <ul>
                <li class="active"><a href="{{ route('home') }}">Dashboard</a></li>
                <li><a href="{{ route('video.index') }}">Video</a></li>
                <li><a href="#">Products</a>
                    <ul class="submenu">
                        <li><a href="{{ route('products.index') }}">List</a></li>
                        <li><a href="{{ route('products.create') }}">Create</a></li>
                    </ul>
                </li>
            </ul>
        </aside>
        <main>
            @yield('content')
        </main>
    </div>
</body>

</html>
