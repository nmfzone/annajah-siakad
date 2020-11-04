@extends('layouts.sub')

@section('content-lv2')
  <div class="w-full">
    <carousel
      autoplay
      loop
      slide-class="h-40 md:h-2/4vh lg:h-3/4vh"
      :slides='@json($slides)'
      :autoplay-hover-pause="false"
      :autoplay-timeout="5000"></carousel>
  </div>

  @if(!$ppdb->is_open)
    <div class="w-full py-10 px-8 bg-red-600 font-bold text-white text-xl text-center">
      Pendaftaran Telah Ditutup
    </div>
  @endif

  <div class="flex flex-wrap items-center justify-center px-4 lg:px-12 xl:px-36 2xl:px-60 mt-10 font-muli">
    <div class="w-full p-4 text-2xl md:text-3xl lg:text-4xl text-center">
      <p>Penjaringan Peserta Didik Baru</p>
      <p>Tahun Pelajaran {{ $ppdb->academicYear->name }}</p>
    </div>

    <div class="w-full p-4 text-xl text-center">
      {{ $ppdb->started_at->translatedFormat('F Y') }} - {{ $ppdb->ended_at->translatedFormat('F Y') }}
    </div>
  </div>

  @if(session('registered'))
    <div class="flex flex-col items-center justify-center mt-20 px-8 lg:px-16 xl:px-40 2xl:px-64 font-muli">
      <div class="bg-gray-100 rounded-sm w-full py-16 px-10 text-center">
        <div class="text-xl">
          Selamat, Anda telah masuk ke daftar inden santri {{ Site::title() }}.
        </div>

        <div class="w-fit-content m-auto mt-8 md:w-1/2">
          <div class="flex justify-center bg-black text-white p-8">
            <div class="text-left">
              <p>Username: <b>{{ auth()->user()->username }}</b></p>
              <p>Password: <b>{{ session('password') }}</b></p>
            </div>
          </div>

          <div class="mt-4">
            Halaman ini hanya bisa diakses satu kali, anda tidak akan bisa mengaksesnya di lain waktu.
            Mohon catat baik-baik informasi ini, dan jangan bagikan ke siapapun.
            Kami menyarankan Anda untuk mengganti password <a href="{{ sub_route('dashboard.profile') }}"><b>disini</b></a>.
          </div>
        </div>

        <div class="text-lg mt-8">
          Mohon selesaikan pendaftaran Anda dengan cara melakukan pembayaran biaya pendaftaran sebesar <b>{{ $ppdb->paymentAmountFormatted() }}</b>.
        </div>

        <div class="flex flex-wrap justify-center items-start mt-10 text-lg">
          <div class="w-full md:w-1/3 text-left p-4 leading-relaxed">
            <p><b>Jenis</b>: {{ PaymentType::getDescription($ppdb->paymentDetails()['payment_type']) }}</p>
            <p><b>Provider</b>: {{ Str::upper($ppdb->paymentDetails()['provider']) }}</p>
            <p><b>Nomor</b>: {{ $ppdb->paymentDetails()['provider_number'] }}</p>
            <p><b>Atas Nama</b>: {{ $ppdb->paymentDetails()['provider_holder_name'] }}</p>
          </div>
        </div>
      </div>
    </div>
  @else
    <ppdb @if(!empty(old('name'))) open-form @endif>
      <template v-slot:header="data">
        <div class="flex flex-col items-center justify-center mt-20 px-8 lg:px-16 xl:px-40 2xl:px-64 font-muli">
          <div class="w-full flex flex-col items-center">
            <h3 class="text-3xl mb-8">Alur Pendaftaran Daring</h3>
            <img src="{{ asset('images/alur-ppdb-daring.png') }}" class="w-2/3">
          </div>

          <div class="w-full flex flex-col items-center mt-16">
            <h3 class="text-3xl mb-8">Alur Pendaftaran Luring</h3>
            <img src="{{ asset('images/alur-ppdb-luring.png') }}" class="w-2/3">
          </div>
        </div>

        <div class="flex flex-wrap items-start mt-20 px-4 lg:px-12 xl:px-36 2xl:px-60">
          <div class="w-full md:w-1/2 flex flex-col p-4 md:pr-8">
            <div class="">
              <h3 class="text-xl font-bold">Jalur Pendaftaran</h3>
              <div class="w-20 h-1 bg-orange-500"></div>
            </div>

            <div class="table pt-6 text-lg leading-7">
              <div class="table-row">
                <div class="table-cell pr-5 text-teal-400">
                  <i class="fas fa-check-circle"></i>
                </div>
                <div class="table-cell">
                  <p class="font-bold">Jalur Prestasi</p>
                  <p class="pt-2 pb-6 font-light">
                    Mempunyai piagam minimal tingkat Kabupaten (menyertakan piagam)
                  </p>
                </div>
              </div>
              <div class="table-row">
                <div class="table-cell pr-5 text-teal-400">
                  <i class="fas fa-check-circle"></i>
                </div>
                <div class="table-cell">
                  <p class="font-bold">Jalur Rapot</p>
                  <p class="pt-2 pb-6 font-light">
                    Mempunyai nilai rata-rata kumulatif rapot kelas IV, V dan VI semester 1 minimal 85 (menyertakan rapot)
                  </p>
                </div>
              </div>
              <div class="table-row">
                <div class="table-cell pr-5 text-teal-400">
                  <i class="fas fa-check-circle"></i>
                </div>
                <div class="table-cell">
                  <p class="font-bold">Jalur Tahfidz</p>
                  <p class="pt-2 pb-6 font-light">
                    Mempunyai hafalan juz 30 dan juz 29 (menyertakan sertifikat hafalan jika ada)
                  </p>
                </div>
              </div>
              <div class="table-row">
                <div class="table-cell pr-5 text-teal-400">
                  <i class="fas fa-check-circle"></i>
                </div>
                <div class="table-cell">
                  <p class="font-bold">Jalur Mandiri</p>
                </div>
              </div>
            </div>
          </div>

          <div class="w-full md:w-1/2 flex flex-col p-4 md:pl-8">
            <div class="">
              <h3 class="text-xl font-bold">Syarat Pendaftaran</h3>
              <div class="w-20 h-1 bg-orange-500"></div>
            </div>

            <div class="table pt-6 text-lg leading-7">
              <div class="table-row">
                <div class="table-cell text-teal-400 w-10">
                  <i class="fas fa-check-circle"></i>
                </div>
                <div class="table-cell">
                  <p class="pb-2">Mengisi Formulir Pendaftaran</p>
                </div>
              </div>
              <div class="table-row">
                <div class="table-cell text-teal-400 w-10">
                  <i class="fas fa-check-circle"></i>
                </div>
                <div class="table-cell">
                  <p class="pb-2">Fotocopy Ijazah (2 Lembar)</p>
                </div>
              </div>
              <div class="table-row">
                <div class="table-cell text-teal-400 w-10">
                  <i class="fas fa-check-circle"></i>
                </div>
                <div class="table-cell">
                  <p class="pb-2">Surat Keterangan Lulus Asli</p>
                </div>
              </div>
              <div class="table-row">
                <div class="table-cell text-teal-400 w-10">
                  <i class="fas fa-check-circle"></i>
                </div>
                <div class="table-cell">
                  <p class="pb-2">Pas foto 3x4 berwarna biru (2 Lembar)</p>
                </div>
              </div>
              <div class="table-row">
                <div class="table-cell text-teal-400 w-10">
                  <i class="fas fa-check-circle"></i>
                </div>
                <div class="table-cell">
                  <p class="pb-2">Foto copy kartu NISN</p>
                </div>
              </div>
              <div class="table-row">
                <div class="table-cell text-teal-400 w-10">
                  <i class="fas fa-check-circle"></i>
                </div>
                <div class="table-cell">
                  <p class="pb-2">SKHUS asli / sementara</p>
                </div>
              </div>
              <div class="table-row">
                <div class="table-cell text-teal-400 w-10">
                  <i class="fas fa-check-circle"></i>
                </div>
                <div class="table-cell">
                  <p class="pb-2">Fotocopy Kartu Keluarga (1 Lembar)</p>
                </div>
              </div>
              <div class="table-row">
                <div class="table-cell text-teal-400 w-10">
                  <i class="fas fa-check-circle"></i>
                </div>
                <div class="table-cell">
                  <p class="pb-2">Fotocopy Akta Kelahiran (1 Lembar)</p>
                </div>
              </div>
              <div class="table-row">
                <div class="table-cell text-teal-400 w-10">
                  <i class="fas fa-check-circle"></i>
                </div>
                <div class="table-cell">
                  <p class="pb-2">Fotocopy Kartu Indonesia Pintar (KIP) / Surat Keterangan PKH bagi yang memiliki</p>
                </div>
              </div>
              <div class="table-row">
                <div class="table-cell text-teal-400 w-10">
                  <i class="fas fa-check-circle"></i>
                </div>
                <div class="table-cell">
                  <p class="pb-2">Fotocopy rapot kelas VI semester 1</p>
                </div>
              </div>
            </div>

            <div class="mt-4">
              <b>NB: Kelengkapan berkas dapat menyusul</b>
            </div>
          </div>
        </div>

        @if($ppdb->is_open)
          <div class="flex items-center justify-center mt-20 px-8 lg:px-16 xl:px-40 2xl:px-64">
            <button class="bg-maincolor hover:bg-green-600 shadow-md text-white text-2xl px-6 py-2 rounded-lg" @click="data.displayForm">
              Daftar Sekarang
            </button>
          </div>
        @endif
      </template>

      @if($ppdb->is_open)
        <template v-slot:form="data">
          <div class="mt-20 px-8 lg:px-16 xl:px-40 2xl:px-64 px-4 font-muli">
            <form action="{{ sub_route('ppdb.store') }}" method="post">
              @csrf

              <div class="w-full flex flex-wrap items-start">
                <div class="flex flex-col w-full md:w-1/2 p-4 md:pr-6">
                  <div class="border-orange-600 border-l-4 pl-6 text-lg mb-6">
                    Identitas Calon Santri
                  </div>

                  <div class="w-full">
                    <div class="form-stack mb-3">
                      <label for="name" class="mb-2 font-bold w-full">
                        Nama Lengkap <span class="required">*</span>
                      </label>

                      <form-input
                        id="name"
                        type="text"
                        initial-value="{{ old('name') }}"
                        @error('name')
                        :state="false"
                        error-message="{{ $message }}"
                        @enderror
                        name="name"
                        note="Nama harus sesuai dengan Ijazah / Akta Kelahiran"
                        autocomplete="name"
                        required></form-input>
                    </div>
                  </div>

                  <div class="w-full">
                    <div class="form-stack mb-3">
                      <label for="nickname" class="mb-2 font-bold w-full">
                        Nama Panggilan <span class="required">*</span>
                      </label>

                      <form-input
                        id="nickname"
                        type="text"
                        initial-value="{{ old('nickname') }}"
                        @error('nickname')
                        :state="false"
                        error-message="{{ $message }}"
                        @enderror
                        name="nickname"
                        required></form-input>
                    </div>
                  </div>

                  <div class="w-full">
                    <div class="form-stack mb-3">
                      <label for="no_kk" class="mb-2 font-bold w-full">
                        Nomor Kartu Keluarga <span class="required">*</span>
                      </label>

                      <form-input
                        id="no_kk"
                        type="text"
                        initial-value="{{ old('no_kk') }}"
                        @error('no_kk')
                        :state="false"
                        error-message="{{ $message }}"
                        @enderror
                        name="no_kk"
                        required></form-input>
                    </div>
                  </div>

                  <div class="w-full">
                    <div class="form-stack mb-3">
                      <label for="birth_place" class="mb-2 font-bold w-full">
                        Tempat Lahir <span class="required">*</span>
                      </label>

                      <form-input
                        id="birth_place"
                        type="text"
                        initial-value="{{ old('birth_place') }}"
                        @error('birth_place')
                        :state="false"
                        error-message="{{ $message }}"
                        @enderror
                        name="birth_place"
                        required></form-input>
                    </div>
                  </div>

                  <div class="w-full">
                    <div class="form-stack mb-3">
                      <label for="birth_date" class="mb-2 font-bold w-full">
                        Tanggal Lahir <span class="required">*</span>
                      </label>

                      <form-input
                        id="birth_date"
                        date-picker
                        type="text"
                        initial-value="{{ old('birth_date') }}"
                        end-date="{{ now()->format('Y-m-d') }}"
                        @error('birth_date')
                        :state="false"
                        error-message="{{ $message }}"
                        @enderror
                        with-add-on
                        add-on-class="fas fa-calendar"
                        name="birth_date"
                        required></form-input>
                    </div>
                  </div>

                  <div class="w-full">
                    <div class="form-stack mb-3">
                      <label for="gender" class="mb-2 font-bold w-full">
                        Jenis Kelamin <span class="required">*</span>
                      </label>

                      @php($gender = [['value' => 0, 'text' => 'Laki-Laki'], ['value' => 1, 'text' => 'Perempuan']])

                      <form-input
                        inline
                        :data='@json($gender)'
                        initial-type="int"
                        initial-value="{{ old('gender', 0) }}"
                        type="radio"
                        @error('gender')
                        :state="false"
                        error-message="{{ $message }}"
                        @enderror
                        name="gender"
                        required></form-input>
                    </div>
                  </div>
                </div>

                <div class="w-full md:w-1/2 flex flex-col p-4 md:pl-6">
                  <div class="border-orange-600 border-l-4 pl-6 text-lg mb-6">
                    Identitas Asal Sekolah
                  </div>

                  <div class="w-full">
                    <div class="form-stack mb-3">
                      <label for="previous_school" class="mb-2 font-bold w-full">
                        Nama Sekolah <span class="required">*</span>
                      </label>

                      <form-input
                        id="previous_school"
                        type="text"
                        initial-value="{{ old('previous_school') }}"
                        @error('previous_school')
                        :state="false"
                        error-message="{{ $message }}"
                        @enderror
                        name="previous_school"
                        required></form-input>
                    </div>
                  </div>

                  <div class="border-orange-600 border-l-4 pl-6 text-lg my-6">
                    Identitas Wali Santri
                  </div>

                  <div class="w-full">
                    <div class="form-stack mb-3">
                      <label for="wali_name" class="mb-2 font-bold w-full">
                        Nama Wali
                      </label>

                      <form-input
                        id="wali_name"
                        type="text"
                        initial-value="{{ old('wali_name') }}"
                        @error('wali_name')
                        :state="false"
                        error-message="{{ $message }}"
                        @enderror
                        name="wali_name"
                        required></form-input>
                    </div>
                  </div>

                  <div class="w-full">
                    <div class="form-stack mb-3">
                      <label for="wali_phone" class="mb-2 font-bold w-full">
                        Nomor Telefon Wali
                      </label>

                      <form-input
                        id="wali_phone"
                        type="text"
                        initial-value="{{ old('wali_phone') }}"
                        @error('wali_phone')
                        :state="false"
                        error-message="{{ $message }}"
                        @enderror
                        name="wali_phone"
                        note="Mohon pastikan nomor telefon aktif"
                        required></form-input>
                    </div>
                  </div>

                  <div class="border-orange-600 border-l-4 pl-6 text-lg my-6">
                    Kelengkapan
                  </div>

                  <div class="w-full">
                    <div class="form-stack mb-3">
                      <label for="selection_method" class="mb-2 font-bold w-full">
                        Jalur Pendaftaran
                      </label>

                      @php($selectionMethod = App\Enums\SelectionMethod::asTextValueArray())

                      <form-input
                        id="selection_method"
                        :data='@json($selectionMethod)'
                        initial-value="{{ old('selection_method') }}"
                        type="select"
                        @error('selection_method')
                        :state="false"
                        error-message="{{ $message }}"
                        @enderror
                        name="selection_method"
                        required></form-input>
                    </div>
                  </div>

                  <div class="w-full">
                    @php($approval = [['value' => 1, 'text' => 'Saya menyatakan jika data yang saya isi adalah benar dan saya bersedia mentaati kebijakan sekolah.']])

                    <form-input
                      id="approval"
                      :data='@json($approval)'
                      type="checkbox"
                      @error('approval')
                      :state="false"
                      error-message="{{ $message }}"
                      @enderror
                      name="approval"
                      required></form-input>
                  </div>
                </div>
              </div>

              <div class="w-full mt-8 p-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                  Daftar
                </button>
              </div>
            </form>
          </div>
        </template>
      @endif
    </ppdb>
  @endif
@endsection
