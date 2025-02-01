 <div class="col-lg-6 mb-4">
     <div class="swiper-container swiper-container-horizontal swiper swiper-card-advance-bg" id="transaction-sliders">
         <div class="swiper-wrapper">
             {{-- Slide 1 --}}
             <div class="swiper-slide">
                 <div class="row">
                     <div class="col-12">
                         <h5 class="text-white mb-0 mt-2">Transaksi Analisis</h5>
                         <small>Informasi bedasarkan tahun ini</small>
                     </div>
                     <div class="row">
                         <div class="col-lg-7 col-md-9 col-12 order-2 order-md-1">
                             <h6 class="text-white mt-0 mt-md-3 mb-3">Transaksi Setoran</h6>
                             <div class="row">
                                 <div class="col-12">
                                     <ul class="list-unstyled mb-0">
                                         <li class="d-flex mb-4 align-items-center">
                                             <p class="mb-0 fw-medium me-2 website-analytics-text-bg">
                                                 Rp.
                                                 {{ number_format($transactionYearly['total_setoran'], 0, '.', ',') }}
                                             </p>
                                         </li>
                                     </ul>
                                 </div>
                             </div>
                         </div>
                         <div class="col-lg-5 col-md-3 col-12 order-1 order-md-2 my-4 my-md-0 text-center">
                             <img src="{{ asset('assets/img/illustrations/card-website-analytics-1.png') }}"
                                 alt="Website Analytics" width="170" class="card-website-analytics-img">
                         </div>
                     </div>
                 </div>
             </div>
             {{-- Slide 2 Setoran --}}
             <div class="swiper-slide">
                 <div class="row">
                     <div class="col-12">
                         <h5 class="text-white mb-0 mt-2">Transaksi Analisis</h5>
                         <small>Informasi bedasarkan tahun ini</small>
                     </div>
                     <div class="row">
                         <div class="col-lg-7 col-md-9 col-12 order-2 order-md-1">
                             <h6 class="text-white mt-0 mt-md-3 mb-3">Transaksi Penarikan</h6>
                             <div class="row">
                                 <div class="col-12">
                                     <ul class="list-unstyled mb-0">
                                         <li class="d-flex mb-4 align-items-center">
                                             <p class="mb-0 fw-medium me-2 website-analytics-text-bg">
                                                 Rp.
                                                 {{ number_format($transactionYearly['total_penarikan'], 0, '.', ',') }}
                                             </p>
                                         </li>
                                     </ul>
                                 </div>
                             </div>
                         </div>
                         <div class="col-lg-5 col-md-3 col-12 order-1 order-md-2 my-4 my-md-0 text-center">
                             <img src="{{ asset('assets/img/illustrations/card-website-analytics-1.png') }}"
                                 alt="Website Analytics" width="170" class="card-website-analytics-img">
                         </div>
                     </div>
                 </div>
             </div>
             {{-- Slide 3 Penarikan --}}
             <div class="swiper-slide">
                 <div class="row">
                     <div class="col-12">
                         <h5 class="text-white mb-0 mt-2">Transaksi Analisis</h5>
                         <small>Informasi bedasarkan tahun ini</small>
                     </div>
                     <div class="row">
                         <div class="col-lg-7 col-md-9 col-12 order-2 order-md-1">
                             <h6 class="text-white mt-0 mt-md-3 mb-3">Transaksi Pembiayaan</h6>
                             <div class="row">
                                 <div class="col-12">
                                     <ul class="list-unstyled mb-0">
                                         <li class="d-flex mb-4 align-items-center">
                                             <p class="mb-0 fw-medium me-2 website-analytics-text-bg">
                                                 Rp.
                                                 {{ number_format($transactionYearly['total_pembiayaan'], 0, '.', ',') }}
                                             </p>
                                         </li>
                                     </ul>
                                 </div>
                             </div>
                         </div>
                         <div class="col-lg-5 col-md-3 col-12 order-1 order-md-2 my-4 my-md-0 text-center">
                             <img src="{{ asset('assets/img/illustrations/card-website-analytics-1.png') }}"
                                 alt="Website Analytics" width="170" class="card-website-analytics-img">
                         </div>
                     </div>
                 </div>
             </div>
             {{-- Slide 4 Baitul Mal --}}
             <div class="swiper-slide">
                 <div class="row">
                     <div class="col-12">
                         <h5 class="text-white mb-0 mt-2">Transaksi Analisis</h5>
                         <small>Informasi bedasarkan tahun ini</small>
                     </div>
                     <div class="row">
                         <div class="col-lg-7 col-md-9 col-12 order-2 order-md-1">
                             <h6 class="text-white mt-0 mt-md-3 mb-3">Transaksi Baitul Mal</h6>
                             <div class="row">
                                 <div class="col-12">
                                     <ul class="list-unstyled mb-0">
                                         <li class="d-flex mb-4 align-items-center">
                                             <p class="mb-0 fw-medium me-2 website-analytics-text-bg">
                                                 Rp.
                                                 {{ number_format($transactionYearly['total_baitulmal'], 0, '.', ',') }}
                                             </p>
                                         </li>
                                     </ul>
                                 </div>
                             </div>
                         </div>
                         <div class="col-lg-5 col-md-3 col-12 order-1 order-md-2 my-4 my-md-0 text-center">
                             <img src="{{ asset('assets/img/illustrations/card-website-analytics-1.png') }}"
                                 alt="Website Analytics" width="170" class="card-website-analytics-img">
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <div class="swiper-pagination"></div>
     </div>
 </div>
