<div class="col-xl-3 col-lg-4 mb-4">
    <div class="card h-100">
        <div class="card-body">
            <div class="card-icon mb-3">
                <span class="badge bg-label-primary p-2">
                    <i class='ti ti-currency-dollar ti-sm'></i>
                </span>
            </div>
            <div class="mb-4">
                <h5 class="mb-0 me-2">
                    Transaksi Tabungan
                </h5>
            </div>
            <div class="mb-0">
                <h5 class="mb-0 me-2">
                    Rp. {{ number_format($transactionDaily['total_setoran'], 0, '.', ',') }}
                </h5>
                <small>Informasi ini berdasarkan harian</small>
            </div>
        </div>
    </div>
</div>
<div class="col-xl-3 col-lg-4 mb-4">
    <div class="card h-100">
        <div class="card-body">
            <div class="card-icon mb-3">
                <span class="badge bg-label-primary p-2">
                    <i class='ti ti-currency-dollar ti-sm'></i>
                </span>
            </div>
            <div class="mb-4">
                <h5 class="mb-0 me-2">
                    Transaksi Angsuran
                </h5>
            </div>
            <div class="mb-0">
                <h5 class="mb-0 me-2">
                    Rp. {{ number_format($transactionDaily['total_pembiayaan'], 0, '.', ',') }}
                </h5>
                <small>Informasi ini berdasarkan harian</small>
            </div>
        </div>
    </div>
</div>
