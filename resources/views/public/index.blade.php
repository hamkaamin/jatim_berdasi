@extends('layouts.landing.index')
@section('konten_front')
    <section class="hero-section ptb-120 text-white bg-gradient"
        style="background: url('{{ asset('assets_landing/img/hero-dot-bg.png') }}')no-repeat center right">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-10">
                    <div class="hero-content-wrap mt-5 mt-lg-0 mt-xl-0">
                        <h1 class="fw-bold display-5">Selamat Datang di {{ env('APP_NAME') }}</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-8 mt-5">
                    <div class="hero-img position-relative circle-shape-images">
                        <!--animated shape start-->
                        <ul class="position-absolute animate-element parallax-element circle-shape-list">
                            <li class="layer" data-depth="0.03">
                                <img src="{{ asset('assets_landing/img/shape/circle-1.svg') }}" alt="shape"
                                    class="circle-shape-item type-0 hero-1">
                            </li>
                            <li class="layer" data-depth="0.02">
                                <img src="{{ asset('assets_landing/img/shape/circle-1.svg') }}" alt="shape"
                                    class="circle-shape-item type-1 hero-1">
                            </li>
                            <li class="layer" data-depth="0.04">
                                <img src="{{ asset('assets_landing/img/shape/circle-1.svg') }}" alt="shape"
                                    class="circle-shape-item type-2 hero-1">
                            </li>
                            <li class="layer" data-depth="0.04">
                                <img src="{{ asset('assets_landing/img/shape/circle-1.svg') }}" alt="shape"
                                    class="circle-shape-item type-3 hero-1">
                            </li>
                            <li class="layer" data-depth="0.03">
                                <img src="{{ asset('assets_landing/img/shape/circle-1.svg') }}" alt="shape"
                                    class="circle-shape-item type-4 hero-1">
                            </li>
                            <li class="layer" data-depth="0.03">
                                <img src="{{ asset('assets_landing/img/shape/circle-1.svg') }}" alt="shape"
                                    class="circle-shape-item type-5 hero-1">
                            </li>
                        </ul>
                        <!--animated shape end-->
                        <img src="{{ asset('assets_landing/img/hero-1.png') }}" alt="hero img"
                            class="img-fluid position-relative z-5">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--hero section end-->



    <!--pricing section start-->
    <section class="pricing-section pt-60 pb-120  position-relative z-2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-10">
                    <div class="section-heading text-center">
                        <h4 class="h5 text-primary">Inovasi Daerah</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div
                        class="position-relative single-pricing-wrap rounded-custom bg-white custom-shadow p-5 mb-4 mb-lg-0">
                        <div class="pricing-header mb-32">
                            <h3 class="package-name text-primary d-block">Lomba Inovasi</h3>
                        </div>
                        <center>
                            <img src="{{ asset(env('APP_LOGO' ?? 'login.png')) }}" height="50%" width="50%"
                                style="text-align: center">
                        </center>
                        <a href="request-demo.html" class="btn btn-outline-primary mt-2">Buy Now</a>

                        <!--pattern start-->
                        <div class="dot-shape-bg position-absolute z--1 left--40 bottom--40">
                            <img src="{{ asset('assets_landing/img/shape/dot-big-square.svg') }}" alt="shape">
                        </div>
                        <!--pattern end-->
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div
                        class="position-relative single-pricing-wrap rounded-custom bg-white custom-shadow p-5 mb-4 mb-lg-0">
                        <div class="pricing-header mb-32">
                            <h3 class="package-name text-primary d-block">Data Inovasi Daerah Provinsi Jawa Timur</h3>
                        </div>

                        <center>
                            <img src="{{ asset(env('APP_LOGO' ?? 'login.png')) }}" height="50%" width="50%"
                                style="text-align: center">
                        </center>
                        <a href="request-demo.html" class="btn btn-outline-primary mt-2">Buy Now</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div
                        class="position-relative single-pricing-wrap rounded-custom bg-white custom-shadow p-5 mb-4 mb-lg-0">
                        <div class="pricing-header mb-32">
                            <h3 class="package-name text-primary d-block">LOGIN INOVASI DAERAH PROVINSI JAWA TIMUR</h3>
                        </div>
                        <center>
                            <img src="{{ asset(env('APP_LOGO' ?? 'login.png')) }}" height="50%" width="50%"
                                style="text-align: center">
                        </center>

                        <a href="{{ route('login') }}" class="btn btn-outline-primary mt-2">Buy Now</a>

                        <!--pattern start-->
                        <div class="dot-shape-bg position-absolute z--1 right--40 top--40">
                            <img src="{{ asset('assets_landing/img/shape/dot-big-square.svg') }}" alt="shape">
                        </div>
                        <!--pattern end-->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--pricing section end-->

    <!--faq section start-->
    <section class="faq-section ptb-120 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-6">
                    <div class="section-heading text-center">
                        <h4 class="h5 text-primary">FAQ</h4>
                        <h2>Frequently Asked Questions</h2>
                        <p>Conveniently mesh cooperative services via magnetic outsourcing. Dynamically grow value whereas
                            accurate e-commerce vectors. </p>
                    </div>
                </div>
            </div>
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-5 col-12">
                    <div class="faq-wrapper">
                        <div class="faq-item mb-5">
                            <h5><span class="h3 text-primary me-2">1.</span> How does back pricing work?</h5>
                            <p>Progressively e-enable collaborative inexpensive supply chains. Efficiently maintain
                                economically methods of empowerment for synergistic sound scenarios.</p>
                        </div>
                        <div class="faq-item mb-5">
                            <h5><span class="h3 text-primary me-2">2.</span> How do I calculate how much price?</h5>
                            <p>Globally benchmark customized mindshare before clicks-and-mortar partnerships. Efficiently
                                maintain economically sound scenarios and whereas client-based progressively. </p>
                        </div>
                        <div class="faq-item">
                            <h5><span class="h3 text-primary me-2">3.</span> Can you show me an example?</h5>
                            <p> Dynamically visualize whereas competitive relationships. Progressively benchmark customized
                                partnerships generate interdependent benefits rather sound scenarios and robust alignments.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center mt-4 mt-lg-0 mt-md-0">
                        <img src="{{ asset('assets_landing/img/faq.svg') }}" alt="faq" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--faq section end-->
@endsection
