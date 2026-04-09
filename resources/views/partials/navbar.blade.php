<div class="app-header header-shadow flex-column">
    <div class="d-flex flex-row w-100">
        <div class="app-header__logo">
            <div class="logo-src"></div>
        </div>

        <div class="app-header__mobile-menu" style="gap: 4px;">
            <div>
                <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
            <div class="app-header__logo" style="width: 230px !important;">
                <div class="logo-src afu" style="background-position: center"></div>
            </div>
        </div>
        <div class="app-header__content">
            <div class="app-header-left">
                <div class="afu menu-container">
                    @include('layouts.menu-container')
                </div>
            </div>
            <div class="app-header-right">
                <div class="header-btn-lg pr-0">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            @php
                                $fase_aktif = App\Models\Fase::where('timer', 1)->first();
                            @endphp
                            @if ($fase_aktif)
                                <div class="timer">
                                    <span class="timer-title">Fase {{ $fase_aktif->nama ?? 'saleh' }} Berakhir
                                        Dalam</span>
                                    <br>
                                    <div class="timer-inner">
                                        <span class="timer-time timer-day">0</span>:<span
                                            class="timer-time timer-hour">0</span>:<span
                                            class="timer-time timer-minutes">0</span>:<span
                                            class="timer-time timer-seconds">0</span>
                                    </div>

                                    <script>
                                        // Set the date we're counting down to
                                        var countDownDate = new Date("{{ $fase_aktif->tgl_berakhir }}").getTime();

                                        // Update the count down every 1 second
                                        var x = setInterval(function() {
                                            // Get today's date and time
                                            var now = new Date().getTime();

                                            // Find the distance between now and the count down date
                                            var distance = countDownDate - now;

                                            // Time calculations for days, hours, minutes and seconds
                                            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                            // Output the result in an element with id="demo"
                                            // document.getElementById("demo").innerHTML = days + "d " + hours + "h "
                                            // + minutes + "m " + seconds + "s ";
                                            $('.timer-day').html(days + 'hari');
                                            $('.timer-hour').html(hours + 'jam');
                                            $('.timer-minutes').html(minutes + 'menit');
                                            $('.timer-seconds').html(seconds + 'detik');

                                            // If the count down is over, write some text
                                            if (distance < 0) {
                                                clearInterval(x);
                                                $('.timer-inner').html('WAKTU HABIS');
                                                document.getElementById("demo").innerHTML = "EXPIRED";
                                            }
                                        }, 1000);
                                    </script>
                                </div>
                            @endif
                            <div class="top-menu ms-auto">
                                &nbsp;
                                &nbsp;
                                <a href="javascript:;" data-toggle="modal" data-target="#modalPopup"
                                    onclick="modal(0,'setting')">
                                    <span class="badge bg-primary badge-sm text-light  me-1 mb-1 mt-1">
                                        Tahun {{ @Auth::user()->tahun }}
                                    </span>
                                </a>
                            </div>

                            <div class="widget-content-left ml-3 header-user-info">
                                <div class="widget-heading">
                                    {{ ucwords(Auth::user()->name) }}
                                </div>
                                <div class="widget-subheading">
                                    {{ Helper::getRole(Auth::user()->role) }}
                                </div>
                            </div>
                            <div class="widget-content-right header-user-info ml-3">
                                <a href="{{ route('profil.index') }}" class="btn-shadow p-1 btn btn-secondary btn-sm"><i
                                        class="fas fa-user-cog pr-1 pl-1"></i></a>
                                <form action="{{ route('logout') }}" method="post" style="all: unset">
                                    @csrf
                                    <button type="submit" class="btn-shadow p-1 btn btn-danger btn-sm"
                                        onclick="if(!confirm('Apakah Anda yakin akan logout?')){return false;}">
                                        <i class="fas fa-power-off text-white pr-1 pl-1"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
