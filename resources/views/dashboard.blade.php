@extends('layout.template')

@section('title')
Dashboard
@endsection

@section('content')
<div class="row pt-4">
    <div class="col-md-12">
        <div class="input-group mb-3">
            <select data-time="year" class="form-select filter-select" id="year">
                <option value="0">Semua Tahun</option>
                <option value="2023">2023</option>
                <option value="2022">2022</option>
            </select>
            <select data-time="month" class="form-select filter-select ms-2" id="month">
                <option value="0">Semua Bulan</option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
            <div class="input-group-append ms-2">
                <a href="#" data-bs-toggle="modal" data-bs-target="#modal-add-income" class="btn btn-info d-inline-flex align-items-center">
                    <i class="fa fa-refresh me-2"></i> Reload Data
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row pt-2">
    <div class="col-12 col-sm-6 col-xl-4 mb-4">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row d-block d-xl-flex align-items-center">
                    <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                        <div class="icon-shape icon-shape-primary rounded me-4 me-sm-0">
                            <svg class="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                            </svg>
                        </div>
                        <div class="d-sm-none">
                            <h2 class="h5">Customers</h2>
                            <h3 class="fw-extrabold mb-1">345,678</h3>
                        </div>
                    </div>
                    <div class="col-12 col-xl-7 px-xl-0">
                        <div class="d-none d-sm-block">
                            <h2 class="h6 text-gray-400 mb-0">Customers</h2>
                            <h3 class="fw-extrabold mb-2">345k</h3>
                        </div>
                        <small class="d-flex align-items-center text-gray-500">
                            Feb 1 - Apr 1,
                            <svg class="icon icon-xxs text-gray-500 ms-2 me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z" clip-rule="evenodd"></path>
                            </svg>
                            USA
                        </small>
                        <div class="small d-flex mt-1">
                            <div>Since last month <svg class="icon icon-xs text-success" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                </svg><span class="text-success fw-bolder">22%</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-4 mb-4">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row d-block d-xl-flex align-items-center">
                    <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                        <div class="icon-shape icon-shape-secondary rounded me-4 me-sm-0">
                            <svg class="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="d-sm-none">
                            <h2 class="fw-extrabold h5">Revenue</h2>
                            <h3 class="mb-1">$43,594</h3>
                        </div>
                    </div>
                    <div class="col-12 col-xl-7 px-xl-0">
                        <div class="d-none d-sm-block">
                            <h2 class="h6 text-gray-400 mb-0">Revenue</h2>
                            <h3 class="fw-extrabold mb-2">$43,594</h3>
                        </div>
                        <small class="d-flex align-items-center text-gray-500">
                            Feb 1 - Apr 1,
                            <svg class="icon icon-xxs text-gray-500 ms-2 me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z" clip-rule="evenodd"></path>
                            </svg>
                            GER
                        </small>
                        <div class="small d-flex mt-1">
                            <div>Since last month <svg class="icon icon-xs text-danger" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg><span class="text-danger fw-bolder">2%</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-4 mb-4">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row d-block d-xl-flex align-items-center">
                    <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                        <div class="icon-shape icon-shape-tertiary rounded me-4 me-sm-0">
                            <svg class="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="d-sm-none">
                            <h2 class="fw-extrabold h5"> Bounce Rate</h2>
                            <h3 class="mb-1">50.88%</h3>
                        </div>
                    </div>
                    <div class="col-12 col-xl-7 px-xl-0">
                        <div class="d-none d-sm-block">
                            <h2 class="h6 text-gray-400 mb-0"> Bounce Rate</h2>
                            <h3 class="fw-extrabold mb-2">50.88%</h3>
                        </div>
                        <small class="text-gray-500">
                            Feb 1 - Apr 1
                        </small>
                        <div class="small d-flex mt-1">
                            <div>Since last month <svg class="icon icon-xs text-success" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                </svg><span class="text-success fw-bolder">4%</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-xl-6 mb-4">
        <div class="card border-0 shadow">
            <div class="card-header d-flex flex-row align-items-center flex-0 border-bottom">
                <div class="d-block">
                    <div class="h6 fw-normal text-gray mb-2">Total pemasukan</div>
                    <h2 class="h3 fw-extrabold">452</h2>
                </div>
            </div>
            <div class="card-body p-2">
                <canvas id="incomeXExpenditureCanvas"></canvas>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-6 mb-4">
        <div class="card border-0 shadow">
            <div class="card-header d-flex flex-row align-items-center flex-0 border-bottom">
                <div class="d-block">
                    <div class="h6 fw-normal text-gray mb-2">Total pengeluaran</div>
                    <h2 class="h3 fw-extrabold">452</h2>
                </div>
            </div>
            <div class="card-body p-2">
                <canvas id="expenditureCanvas"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom-scripts')
<script>
    const incomeXExpenditureCanvas = document.getElementById('incomeXExpenditureCanvas');
    const expenditureCanvas = document.getElementById('expenditureCanvas');

    let generateChart = (canvas, type, data, options) => new Chart(canvas, {type, data, options})

    let incomeXExpenditureChart = generateChart(incomeXExpenditureCanvas, 'line', 
        {
            datasets: [{
                label: 'Pemasukan',
                borderWidth: 2,
            }, {
                label: 'Pengeluaran',
                borderWidth: 2,
            }]
        }, 
        {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    )

    let expenditureChart = generateChart(expenditureCanvas, 'line', 
        {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                borderWidth: 2
            }, {
                label: '# of Cool',
                data: [120, 190, 30, 50, 20, 30],
                borderWidth: 2
            }],
        }, 
        {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    )

    async function getIncomeReport() {
        const params = new URLSearchParams()
        params.append('year', $('#year').val() ?? "")
        params.append('month', $('#month').val() ?? "")

        const url = "{{ route('statistic.income') }}?" + params.toString()
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
        })
        .then(response => response.json())
        .then(data => {
            setIncomeReport(data)
        })
        .catch(error => console.error(error))
    }

    let setIncomeReport = (data) => {
        incomeXExpenditureChart.config.data.labels = data.labels
        incomeXExpenditureChart.config.data.datasets[0].data = data.data
        incomeXExpenditureChart.update()
    }

    getIncomeReport()

    // Reload data
    $('.filter-select').change(function() {
        getIncomeReport()
    })
</script>
@endpush