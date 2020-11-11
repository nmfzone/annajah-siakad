@extends('layouts.sub')

@section('content-lv2')
  <div class="w-full mb-10">
    <carousel
      autoplay
      loop
      slide-class="h-40 md:h-2/4vh lg:h-9/10vh"
      :slides='@json($slides)'
      :pagination-enabled="false"
      :autoplay-hover-pause="false"
      :autoplay-timeout="5000"></carousel>
  </div>

  <div class="relative flex flex-wrap items-start px-4 lg:px-12 xl:px-36 2xl:px-60 md:-mt-32">
    <div class="w-full md:w-1/3 flex flex-col p-4">
      <div class="aio-icon h-32 w-32 md:h-48 md:w-48 text-4xl md:text-6xl bg-blue-600-imp border-blue-500-imp">
        <div class="aio-inner bg-blue-500-imp">
          <img src="{{ asset('images/icons/ab.png') }}" class="w-16">
        </div>
      </div>

      <div class="w-full mt-4 text-center font-exo">
        <h3 class="text-xl font-bold">Bilingual</h3>

        <p class="text-gray-700 pt-4 font-thin">
          Santri dibimbing agar dapat berkomunikasi secara bilingual.
        </p>
      </div>
    </div>
    <div class="w-full md:w-1/3 flex flex-col p-4">
      <div class="aio-icon h-32 w-32 md:h-48 md:w-48 text-4xl md:text-6xl bg-indigo-600-imp border-indigo-500-imp">
        <div class="aio-inner bg-indigo-500-imp">
          <i class="fas fa-book"></i>
        </div>
      </div>

      <div class="w-full mt-4 text-center font-exo">
        <h3 class="text-xl font-bold">Tahfidzul Qur'an</h3>

        <p class="text-gray-700 pt-4 font-thin">
          Santri dibimbing agar dapat menjadi penghafal Al Qur'an.
        </p>
      </div>
    </div>
    <div class="w-full md:w-1/3 flex flex-col p-4">
      <div class="aio-icon h-32 w-32 md:h-48 md:w-48 text-4xl md:text-6xl bg-green-600-imp border-green-500-imp">
        <div class="aio-inner bg-green-500-imp">
          <i class="fas fa-desktop"></i>
        </div>
      </div>

      <div class="w-full mt-4 text-center font-exo">
        <h3 class="text-xl font-bold">Multimedia</h3>

        <p class="text-gray-700 pt-4 font-thin">
          Pendidikan berbasis teknologi.
        </p>
      </div>
    </div>
  </div>

  <transition-viewport name="fadeUp">
    <div class="flex flex-wrap items-start px-4 lg:px-12 xl:px-36 2xl:px-60 mt-16">
      <div class="w-full md:w-1/2 p-4 flex flex-col">
        <div class="border-l-8 border-gray-400 pl-6">
          <h3 class="text-3xl flex flex-col md:text-6xl lg:text-7.5xl font-bold font-inter">
            <span class="text-blue-550 md:-mt-6 lg:-mt-8">Ulul Albab</span>
            <span class="text-yellow-350 md:-mt-12 md:-mb-4 lg:-mt-18 lg:-mb-6">Generation</span>
          </h3>
        </div>

        <div class="w-full mt-4 sm:mt-16 font-muli text-base sm:text-lg leading-10 text-justify">
          Ululalbab sering diartikan dengan yang mempunyai akal atau orang yang berakal.
          Aktivitas utama ulul albab adalah berpikir dan berdzikir.
          Berpikir yaitu melibatkan beragam obyek atau fenomena alam, sedangkan Berdzikir yaitu mengingat Allah dalam situasi apapun.
          Ululalbab dapat menjaga integrasi antara berpikir dan berdzikir yaitu antara ilmu dan iman.
          Harapanya Ululalbab generation nantinya dapat mencetak generasi dinamis untuk masa depan dengan pikiran yang kritis, kreatif, dan kontemplatif.
        </div>
      </div>
      <div class="w-full md:w-1/2 p-4 md:pl-8">
        <img src="{{ asset('images/gambar-2.png') }}" class="w-full">
      </div>
    </div>
  </transition-viewport>

  <div class="flex flex-wrap items-start px-4 lg:px-12 xl:px-36 2xl:px-60 mt-16">
    <transition-viewport name="fadeDown" class="w-full sm:w-1/3 p-4">
      <div class="h-full flex flex-col items-center bg-maincolor lg:rounded-b-full p-8 sm:p-4 lg:pb-32 min-h-40">
        <img src="{{ asset('images/header-smart.png') }}" class="h-20 sm:h-12 lg:h-20">

        <div class="table mt-6 sm:mt-12 font-muli font-light text-base sm:text-lg leading-7 text-white">
          <div class="table-row">
            <div class="table-cell pr-5 text-yellow-350">
              <i class="fas fa-check"></i>
            </div>
            <div class="table-cell">
              Tercapainya kualitas siswa yang kuat Tahfidzul Qur’an dan berprestasi secara akademik.
            </div>
          </div>
          <div class="table-row">
            <div class="table-cell pr-5 text-yellow-350">
              <i class="fas fa-check"></i>
            </div>
            <div class="table-cell">
              Terwujudnya pembelajaran yang kreatif dan inovatif berbasis bilingual dan multimedia.
            </div>
          </div>
          <div class="table-row">
            <div class="table-cell pr-5 text-yellow-350">
              <i class="fas fa-check"></i>
            </div>
            <div class="table-cell">
              Terwujudnya siswa dan tenaga pendidik yang berakhlakul karimah, berprestasi, kompeten, dan kompetitif.
            </div>
          </div>
          <div class="table-row">
            <div class="table-cell pr-5 text-yellow-350">
              <i class="fas fa-check"></i>
            </div>
            <div class="table-cell">
              Terbentuknya pribadi siswa dan warga sekolah yang berperan aktif dalam pelestarian lingkungan dan peduli kemanusiaan.
            </div>
          </div>
        </div>
      </div>
    </transition-viewport>
    <transition-viewport name="fadeUp" class="w-full sm:w-1/3 p-4">
      <div class="h-full flex flex-col items-center bg-maincolor lg:rounded-b-full p-8 sm:p-4 lg:pb-32 min-h-40">
        <img src="{{ asset('images/header-integrity.png') }}" class="h-20 sm:h-12 lg:h-20">

        <div class="table mt-6 sm:mt-12 font-muli font-light text-base sm:text-lg leading-7 text-white">
          <div class="table-row">
            <div class="table-cell pr-5 text-yellow-350">
              <i class="fas fa-check"></i>
            </div>
            <div class="table-cell">
              Terwujudnya siswa dan warga sekolah yang berjiwa kepemimpinan sebagai <i>kholifatullah Fil Ardh</i>.
            </div>
          </div>
        </div>
      </div>
    </transition-viewport>
    <transition-viewport name="fadeDown" class="w-full sm:w-1/3 p-4">
      <div class="h-full flex flex-col items-center bg-maincolor lg:rounded-b-full p-8 sm:p-4 lg:pb-32">
        <img src="{{ asset('images/header-good-manner.png') }}" class="h-20 sm:h-12 lg:h-20">

        <div class="table mt-6 sm:mt-12 font-muli font-light text-base sm:text-lg leading-7 text-white">
          <div class="table-row">
            <div class="table-cell pr-5 text-yellow-350">
              <i class="fas fa-check"></i>
            </div>
            <div class="table-cell">
              Terwujudnya aqidah islamiyah warga sekolah yang sesuai dengan Al Qur'an dan As Sunah.
            </div>
          </div>
          <div class="table-row">
            <div class="table-cell pr-5 text-yellow-350">
              <i class="fas fa-check"></i>
            </div>
            <div class="table-cell">
              Terwujudnya wawasan keislaman yang <i>kaffah</i> (<i>comprehensive</i>) bagi siswa dan warga sekolah.
            </div>
          </div>
        </div>
      </div>
    </transition-viewport>
  </div>

{{--  <div class="relative mt-16 skewed-bg-left py-10 sm:py-20">--}}
{{--    <transition-viewport name="slideLeft">--}}
{{--      <div class="relative flex flex-wrap items-start px-4 lg:px-12 xl:px-36 2xl:px-60 sm:mt-10">--}}
{{--        <div class="w-full md:w-1/2 p-4 md:pr-10">--}}
{{--          <img src="{{ asset('images/gambar-1.jpeg') }}" class="w-full">--}}
{{--        </div>--}}
{{--        <div class="w-full md:w-1/2 flex flex-col p-4">--}}
{{--          <div class="relative w-full">--}}
{{--            <div class="text-3xl sm:text-5xl font-bold font-exo text-indigo-800">--}}
{{--              SMART--}}
{{--            </div>--}}
{{--            <div class="w-20 h-2 bg-orange-500"></div>--}}
{{--          </div>--}}

{{--          <div class="table mt-6 sm:mt-12 font-muli font-light text-base sm:text-lg leading-7">--}}
{{--            <div class="table-row">--}}
{{--              <div class="table-cell pr-5 text-teal-400">--}}
{{--                <i class="fas fa-check-circle"></i>--}}
{{--              </div>--}}
{{--              <div class="table-cell">--}}
{{--                Tercapainya kualitas siswa yang kuat Tahfidzul Qur’an dan berprestasi secara akademik.--}}
{{--              </div>--}}
{{--            </div>--}}
{{--            <div class="table-row">--}}
{{--              <div class="table-cell pr-5 text-teal-400">--}}
{{--                <i class="fas fa-check-circle"></i>--}}
{{--              </div>--}}
{{--              <div class="table-cell">--}}
{{--                Terwujudnya pembelajaran yang kreatif dan inovatif berbasis bilingual dan multimedia.--}}
{{--              </div>--}}
{{--            </div>--}}
{{--            <div class="table-row">--}}
{{--              <div class="table-cell pr-5 text-teal-400">--}}
{{--                <i class="fas fa-check-circle"></i>--}}
{{--              </div>--}}
{{--              <div class="table-cell">--}}
{{--                Terwujudnya siswa dan tenaga pendidik yang berakhlakul karimah, berprestasi, kompeten, dan kompetitif.--}}
{{--              </div>--}}
{{--            </div>--}}
{{--            <div class="table-row">--}}
{{--              <div class="table-cell pr-5 text-teal-400">--}}
{{--                <i class="fas fa-check-circle"></i>--}}
{{--              </div>--}}
{{--              <div class="table-cell">--}}
{{--                Terbentuknya pribadi siswa dan warga sekolah yang berperan aktif dalam pelestarian lingkungan dan peduli kemanusiaan.--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--        </div>--}}
{{--      </div>--}}
{{--    </transition-viewport>--}}
{{--  </div>--}}

{{--  <div class="relative skewed-bg-right py-10 sm:py-20">--}}
{{--    <transition-viewport name="slideRight">--}}
{{--      <div class="relative flex flex-wrap items-start px-4 lg:px-12 xl:px-36 2xl:px-60 sm:mt-10">--}}
{{--        <div class="w-full block sm:hidden md:w-1/2 p-4 md:pr-10">--}}
{{--          <img src="{{ asset('images/gambar-1.jpeg') }}" class="w-full">--}}
{{--        </div>--}}
{{--        <div class="w-full md:w-1/2 flex flex-col p-4">--}}
{{--          <div class="relative w-full mt-0 md:mt-8">--}}
{{--            <div class="text-3xl sm:text-5xl font-bold font-exo text-indigo-800">--}}
{{--              INTEGRITY--}}
{{--            </div>--}}
{{--            <div class="w-28 h-2 bg-orange-500"></div>--}}
{{--          </div>--}}

{{--          <div class="table mt-6 sm:mt-12 font-muli font-light text-base sm:text-lg leading-7">--}}
{{--            <div class="table-row">--}}
{{--              <div class="table-cell pr-5 text-teal-400">--}}
{{--                <i class="fas fa-check-circle"></i>--}}
{{--              </div>--}}
{{--              <div class="table-cell">--}}
{{--                Terwujudnya siswa dan warga sekolah yang berjiwa kepemimpinan sebagai <i>kholifatullah Fil Ardh</i>.--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--        </div>--}}
{{--        <div class="w-full hidden sm:block md:w-1/2 p-4 md:pl-10">--}}
{{--          <img src="{{ asset('images/gambar-1.jpeg') }}" class="w-full">--}}
{{--        </div>--}}
{{--      </div>--}}
{{--    </transition-viewport>--}}
{{--  </div>--}}

{{--  <div class="relative skewed-bg-left py-10 sm:py-20">--}}
{{--    <transition-viewport name="slideLeft" class="relative">--}}
{{--      <div class="relative flex flex-wrap px-4 lg:px-12 xl:px-36 2xl:px-60 sm:mt-10">--}}
{{--        <div class="w-full md:w-1/2 p-4 md:pr-10">--}}
{{--          <img src="{{ asset('images/gambar-1.jpeg') }}" class="w-full">--}}
{{--        </div>--}}
{{--        <div class="w-full md:w-1/2 flex flex-col p-4">--}}
{{--          <div class="relative w-full mt-0 md:mt-8">--}}
{{--            <div class="flex items-center justify-center text-3xl font-bold font-exo text-white bg-indigo-600 w-64 h-18">--}}
{{--              GOOD MANNER--}}
{{--            </div>--}}
{{--            <div class="absolute max-sm:half-triangle-left max-sm:border-r-indigo-800-imp sm:half-triangle-right sm:border-l-indigo-800-imp top-18 sm:left-44"></div>--}}
{{--            <div class="text-3xl sm:text-5xl font-bold font-exo text-indigo-800">--}}
{{--              GOOD MANNER--}}
{{--            </div>--}}
{{--            <div class="w-40 h-2 bg-orange-500"></div>--}}
{{--          </div>--}}

{{--          <div class="table mt-6 sm:mt-12 font-muli font-light text-base sm:text-lg leading-7">--}}
{{--            <div class="table-row">--}}
{{--              <div class="table-cell pr-5 text-teal-400">--}}
{{--                <i class="fas fa-check-circle"></i>--}}
{{--              </div>--}}
{{--              <div class="table-cell">--}}
{{--                Terwujudnya aqidah islamiyah warga sekolah yang sesuai dengan Al Qur'an dan As Sunah.--}}
{{--              </div>--}}
{{--            </div>--}}
{{--            <div class="table-row">--}}
{{--              <div class="table-cell pr-5 text-teal-400">--}}
{{--                <i class="fas fa-check-circle"></i>--}}
{{--              </div>--}}
{{--              <div class="table-cell">--}}
{{--                Terwujudnya wawasan keislaman yang <i>kaffah</i> (<i>comprehensive</i>) bagi siswa dan warga sekolah.--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--        </div>--}}
{{--      </div>--}}
{{--    </transition-viewport>--}}
{{--  </div>--}}

  <div class="bg-gray-100 mt-20 pt-4 pb-16">
    <div class="flex flex-col items-center mt-10 px-8 lg:px-16 xl:px-40 2xl:px-64">
      <h3 class="text-3xl font-bold font-exo">
        <span class="text-blue-600">Basis</span>
        <span class="text-blue-800">Pembelajaran</span>
      </h3>

      <div class="flex justify-center border-b border-gray-200 mt-4 text-center w-full">
        <div class="w-16 h-2 bg-maincolor"></div>
      </div>
    </div>

    <div class="flex flex-wrap items-start justify-center mt-10 px-4 lg:px-12 xl:px-36 2xl:px-60 font-muli">
      <div class="w-full flex flex-col p-4 sm:w-1/3">
        <div class="aio-icon h-32 w-32 md:h-32 md:w-32 text-4xl bg-blue-700-imp border-blue-500-imp">
          <div class="aio-inner bg-blue-500-imp">
            <i class="fas fa-language"></i>
          </div>
        </div>

        <div class="w-full mt-4 text-center">
          <div class="ribbon">
            <div class="ribbon-inner"></div>
            <h3 class="text-base font-bold ribbon-text">Terpadu</h3>
          </div>

          <p class="text-gray-700 pt-4 font-thin">
            Kurikulum Islam Terpadu (pada semua bidang studi) dengan mengintegrasikan materi Al-Qur'an, As Sunnah, dan Siroh yang berkaitan dengan mata pelajaran.
          </p>
        </div>
      </div>
      <div class="w-full flex flex-col p-4 sm:w-1/3">
        <div class="aio-icon h-32 w-32 md:h-32 md:w-32 text-4xl bg-blue-700-imp border-blue-500-imp">
          <div class="aio-inner bg-blue-500-imp">
            <i class="fas fa-language"></i>
          </div>
        </div>

        <div class="w-full mt-4 text-center">
          <div class="ribbon">
            <div class="ribbon-inner"></div>
            <h3 class="text-base md:text-sm lg:text-base font-bold ribbon-text">Interactive Learning</h3>
          </div>

          <p class="text-gray-700 pt-4 font-thin">
            Pembelajaran <i>minds on</i> dan <i>hands on</i> (kemampuan berfikir suatu objek dan mengaplikasikannya).
          </p>
        </div>
      </div>
      <div class="w-full flex flex-col sm:w-1/3 p-4">
        <div class="aio-icon h-32 w-32 md:h-32 md:w-32 text-4xl bg-blue-700-imp border-blue-500-imp">
          <div class="aio-inner bg-blue-500-imp">
            <i class="fas fa-language"></i>
          </div>
        </div>

        <div class="w-full mt-4 text-center">
          <div class="ribbon">
            <div class="ribbon-inner"></div>
            <h3 class="text-base font-bold ribbon-text">Fun Literacy</h3>
          </div>

          <p class="text-gray-700 pt-4 font-thin">
            Berbahasa dan pengembangan diri.
          </p>
        </div>
      </div>
    </div>
    <div class="flex flex-wrap flex-start justify-center px-4 lg:px-12 xl:px-36 2xl:px-60 mt-8 lg:mt-16 font-exo">
      <div class="w-full flex flex-col p-4 sm:w-1/3">
        <div class="aio-icon h-32 w-32 md:h-32 md:w-32 text-4xl bg-blue-700-imp border-blue-500-imp">
          <div class="aio-inner bg-blue-500-imp">
            <i class="fas fa-language"></i>
          </div>
        </div>

        <div class="w-full mt-4 text-center">
          <div class="ribbon">
            <div class="ribbon-inner"></div>
            <h3 class="text-base font-bold ribbon-text">ICT Learning</h3>
          </div>

          <p class="text-gray-700 pt-4 font-thin">
            KBM menggunakan media <i>giant screen</i> disertai fasilitas lengkap di dalamnya dan pembiasaan penggunaan teknologi informasi.
          </p>
        </div>
      </div>
      <div class="w-full flex flex-col p-4 sm:w-1/3">
        <div class="aio-icon h-32 w-32 md:h-32 md:w-32 text-4xl bg-blue-700-imp border-blue-500-imp">
          <div class="aio-inner bg-blue-500-imp">
            <i class="fas fa-language"></i>
          </div>
        </div>

        <div class="w-full mt-4 text-center">
          <div class="ribbon">
            <div class="ribbon-inner"></div>
            <h3 class="text-base font-bold ribbon-text">Karakter Positif</h3>
          </div>

          <p class="text-gray-700 pt-4 font-thin">
            Pembentukan nilai kejujuran, kedisiplinan, tanggung jawab, kemandirian, dan toleransi melalui pelatihan dan pembiasaan.
          </p>
        </div>
      </div>
    </div>
  </div>

  <div class="mt-10">
    <div class="flex flex-col items-center px-8 lg:px-16 xl:px-40 2xl:px-64">
      <h3 class="text-3xl font-bold font-exo">
        <span class="text-blue-600">Informasi</span>
        <span class="text-blue-800">Terbaru</span>
      </h3>

      <div class="flex justify-center border-b border-gray-200 mt-4 text-center w-full">
        <div class="w-16 h-2 bg-maincolor"></div>
      </div>
    </div>

    <div class="w-full flex justify-end mt-4 px-8 lg:px-16 xl:px-40 2xl:px-64">
      <div class="flex flex-col mr-4">
        <a href="#" class="font-muli font-bold hover:text-blue-600">
          Informasi lainnya
        </a>
        <div class="w-16 h-1 bg-orange-500"></div>
      </div>
    </div>

    <div class="flex flex-wrap flex-start justify-center mt-4 px-4 lg:px-12 xl:px-36 2xl:px-60">
      @foreach($articles as $article)
        <div class="w-full md:w-1/3 p-4">
          <div class="post-card">
            <div class="post-card-inner">
              <a href="#" class="thumbnail">
                <img src="{{ $article['thumbnail'] }}">
              </a>
              <div class="categories btw">
                @foreach($article['categories'] as $category)
                  <a href="{{ $category['link'] }}">{{ $category['title'] }}</a>
                @endforeach
              </div>
              <a href="#">
                <h1 class="title btw">{{ $article['title'] }}</h1>
              </a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection
