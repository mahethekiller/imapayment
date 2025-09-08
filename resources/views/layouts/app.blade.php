<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Landing Page')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
       <script src="https://code.jquery.com/jquery-3.6.4.min.js" crossorigin="anonymous"></script>

    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-KBX1R9TEDL"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-KBX1R9TEDL');
    </script>

    <!-- Custom Styles -->
    <style>
        body { font-family: Garamond, serif; background-color: #f6f4f5; }
        .banner { width:100%; max-height: 400px; object-fit:cover; }
        .box { background-color: #ffd966; border-radius:12px; padding:20px; margin:20px 0; text-align:center; }
        .boxsmall { background-color:#a6a6a6; border-radius:8px; height:65px; color:#fff; font-weight:bold; display:flex; justify-content:center; align-items:center; margin:10px auto; }
        .price { font-size:28px; color:#000; text-align:center; }
        .pricered { font-size:28px; color:red; text-align:center; }
        .tick { width:25px; height:23px; }
    </style>

    @stack('head')
</head>
<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T8QHTK6" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

    <!-- Banner -->
    <div class="container my-5">
    @if(isset($lp) && $lp->banner_path)
        <div class="text-center my-4">
            <a href="{{ $lp->banner_link ?? '#' }}" target="_blank">
                <img src="{{ asset('storage/' . $lp->banner_path) }}" alt="{{ $lp->title }}" class="banner img-fluid rounded">
            </a>
        </div>
    @endif


        @yield('content')
    </div>

    <footer class="text-center text-muted py-3" style="font-size:12px;">
        <p><i>© Copyright 2025, all rights reserved with IMA India Private Limited</i></p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')



</body>
</html>
