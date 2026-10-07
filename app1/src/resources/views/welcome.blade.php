<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
      pebble - みんなのスキを見つけよう
    </title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @include('partials.head')
  </head>

  <body
    class="flex items-center min-h-screen flex-col" style="background-image: url('{{ asset('logo/background3.png') }}');">

    <header class="w-full flex justify-center p-3" style="backdrop-filter: blur(80px);">
      <img src="{{ asset('logo/logo.png') }}" alt="Pebble" class="h-12 w-auto">
    </header>
    <!-- スマホ専用ヘッダー画像 -->
    <div class="mobile-top sm:hidden absolute left-0 right-0 mx-auto flex justify-center z-30 ms-3 top-[30px]">
      <img src="{{ asset('logo/logo.png') }}" alt="Pebble" class="w-auto mt-6">
    </div>

    <div>
      <main class="flex flex-col-reverse lg:flex-row max-w-4xl mx-auto w-full p-3">
        <section class="py-32 mt-12">
          <div class="container">
            <div class="grid lg:grid-cols-2 gap-8 items-center">
              <div class="flex items-center justify-center p-3">
                <img src="{{ asset('logo/top.png') }}" alt="top.png"
            class="rounded-xl" style="box-shadow: 0px 5px 15px 0px rgba(49, 42, 36, 0.3);">
              </div>
              <div class="flex flex-col items-center lg:items-start justify-center">
                <h1 class="text-5xl font-semibold text-stone-800 text-center lg:text-left mb-6">
                  Find You Like!
                </h1>
                <p class="text-center lg:text-left text-zinc-600 mb-8 max-w-xl">
                  肩の力を抜いて、ゆるーく楽しめばいい。
                  <br>
                  毎日のちょっとした発見や旅先での思い出が楽しくなる。
                </p>
                <div class="flex space-x-4 mb-5 lg:justify-start">
                  <a href="{{ route('register') }}" class="bg-zinc-800 text-white font-semibold py-2 px-2 rounded" style="box-shadow: inset 0px 0px 10px 0px rgba(214, 214, 214, 0.3); transition: 0.2s;" onmouseover="this.style.opacity=0.91" onmouseout="this.style.opacity=1">
                    いますぐ始める
                  </a>
                  <a href="{{ route('login') }}" class="bg-white font-semibold border border-zinc-300 text-black py-2 px-2 rounded" style="box-shadow: inset 0px 0px 10px 0px rgba(214, 214, 214, 0.3); transition: 0.2s;" onmouseover="this.style.opacity=0.95" onmouseout="this.style.opacity=1">
                    アカウントをお持ちの方
                  </a>
                </div>
              </div>
            </div>
          </div>
        </section>
      </main>
    </div>
    <footer class="w-full text-zinc-800 p-4 text-center" style="backdrop-filter: blur(80px);">
      © 2026 Pebble
    </footer>
    <!-- スマホ専用フッター画像 -->
      <div class="mobile-footer-image w-full flex justify-center mb-5">
        <p class="w-full text-zinc-800 text-center">
          © 2026 Pebble
        </p>
      </div>
  </body>
</html>

