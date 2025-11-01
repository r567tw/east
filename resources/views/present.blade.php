<!DOCTYPE html>
<html lang="zh-Hant">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>專案展示</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<style>
  body { scroll-behavior: smooth; }
  header { background: #0d6efd; color: white; padding: 100px 0; text-align: center; }
  section { padding: 60px 0; }
  .bg-lightgray { background: #f8f9fa; }
</style>
</head>
<body>

<!-- Hero / 導覽 -->
<header>
  <div class="container">
    <h1 class="display-4">專案展示</h1>
    <a href="#features" class="btn btn-light btn-lg mt-3">Go</a>
    <a href="{{ route('home') }}" class="btn btn-outline-light btn-lg mt-3">回首頁</a>
  </div>
</header>

<!-- 功能亮點 -->
<section id="features">
  <div class="container">
    <h2 class="mb-4 text-center">作品展示</h2>
    <div class="row g-4">

    @foreach ($features as $item)
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="{{ $item["icon"] }}"></i>  {{ $item["title"]}}</h5>
                    <p class="card-text">{{ $item["description"]}}</p>
                    @if (!empty($item["link"]))
                        <a href="{{ $item["link"] }}" target="_blank" class="card-link">{{ $item["action"] }}</a>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
    </div>
  </div>
</section>

<!-- 技術架構 Carousel -->
<section class="bg-lightgray py-5">
  <div class="container">
    <h2 class="text-center mb-4">技術架構</h2>
    <p class="text-center">
        本平台自架於 <img src="https://devicon-website.vercel.app/api/ubuntu/plain.svg" alt="Ubuntu Logo" style="width: 30px; vertical-align: middle;"> Ubuntu Server、
        DNS 由 <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/cloudflare/cloudflare-original.svg" alt="Cloudflare Logo" style="width: 30px; vertical-align: middle;"> Cloudflare 支援
    </p>
    <div class="row justify-content-center">
      @foreach ($technologies as $tech)
        <div class="col-6 col-md-4 col-lg-2 mb-4 d-flex justify-content-center">
          <div class="card shadow-sm" style="width: 120px;">
            <img src="{{ $tech["image"] }}" class="card-img-top mx-auto mt-3" style="width:60px;" alt="{{ $tech["title"] }}">
            <div class="card-body p-2">
              <h6 class="card-title text-center">{{ $tech['title'] }}</h6>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- 監控 -->
<section class="bg-lightgray py-5">
  <div class="container">
    <h2 class="text-center mb-4">監控</h2>
    <div class="row justify-content-center">
      @foreach ($monitors as $monitor)
        <div class="col-6 col-md-2 col-lg-2 mb-4 d-flex justify-content-center">
          <div class="card shadow-sm" >
            <img src="{{ $monitor["image"] }}" class="card-img-top mx-auto mt-3" style="width:60px;" alt="{{ $monitor["title"] }}">
            <div class="card-body p-2">
              <h6 class="card-title text-center">{{ $monitor['title'] }}</h6>
              <p class="card-text text-center">{{ $monitor['description'] ?? '' }}</p>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-4">
  <div class="container">
    <p class="mb-0">© {{ date("Y")}} 專案展示 | GitHub: <a href="https://github.com/r567tw/east" class="text-white">專案原始碼</a></p>
  </div>
</footer>
</body>
</html>
