<x-admin.layout.layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    {{-- Highcharts Map CDN --}}
    @push('scripts')
    <script src="https://code.highcharts.com/maps/highmaps.js"></script>
    <script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/maps/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/mapdata/countries/id/id-all.js"></script>
    @endpush

    {{-- ApexCharts --}}
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @endpush

    {{-- STATS CARD --}}
    {{-- STATS CARD --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mt-4">
        <x-admin.dashbaord.stats label="Total Revenue" value="$612,839" change="16%" color="green" icon="up" />
        <x-admin.dashbaord.stats label="New Users" value="12,421" change="4%" color="green" icon="up" />
        <x-admin.dashbaord.stats label="Pending Orders" value="1,839" change="6%" color="red" icon="down" />
        <x-admin.dashbaord.stats label="Cart Abandoned" value="3,904" change="12%" color="red" icon="down" />
        <x-admin.dashbaord.stats label="Repeat Customers" value="76%" change="3%" color="green" icon="up" />
        <x-admin.dashbaord.stats label="Avg. Order Value" value="$89.50" change="1.5%" color="green" icon="up" />
    </div>



    {{-- Revenue & Customer Growth --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="font-bold text-lg text-gray-800">Revenue Growth</h3>
                    <p class="text-sm text-gray-500">of the week on website and compared with e-commerce</p>
                </div>
                <a href="#" class="text-blue-600 font-semibold text-sm">View detail</a>
            </div>
            <div id="revenue-growth-chart"></div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="font-bold text-lg text-gray-800">Customer Growth</h3>
            <p class="text-sm text-gray-500 mb-4">of the week based on Indonesia provinces</p>
            <div id="map" class="w-full h-[400px] rounded-md"></div>
        </div>

    </div>

    {{-- Top Transaction & Top Product --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-lg text-gray-800">Top Transaction</h3>
                <a href="#" class="text-blue-600 font-semibold text-sm">View detail</a>
            </div>

            <x-admin.table.table :headers="['Customer Name', 'Status', 'Total', 'Action']">
                @for ($i = 1; $i <= 5; $i++) @php $names=['John Doe', 'Jane Smith' , 'Michael Jordan' , 'Tony Stark'
                    , 'Bruce Wayne' ]; $statuses=['new', 'quotation' , 'invoice' ]; $status=$statuses[$i % 3];
                    $statusColor=match($status) { 'new'=> 'bg-blue-400 text-blue-950',
                    'quotation' => 'bg-yellow-400 text-yellow-950',
                    'invoice' => 'bg-green-400 text-green-950',
                    };
                    @endphp
                    <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $names[$i - 1] }}</td>
                        <td class="px-6 py-4">
                            <span class="p-2 rounded-md {{ $statusColor }} bg-opacity-60">
                                {{ $status }}
                            </span>
                        </td>
                        <td class="px-6 py-4">Rp{{ number_format($i * 100000, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 flex gap-2">
                            <a href="#" class="button-mini-show"><i class="fas fa-eye"></i></a>
                            <a href="#" class="button-mini-edit"><i class="fas fa-pencil"></i></a>
                        </td>
                    </tr>
                    @endfor
            </x-admin.table.table>
        </div>

        <div class="space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-lg text-gray-800">Top Product</h3>
                    <a href="#" class="text-blue-600 font-semibold text-sm">View more</a>
                </div>
                <div class="flex gap-4">
                    <img src="https://i.imgur.com/Gj4gq2D.png" alt="White T-shirt"
                        class="rounded-lg w-1/2 object-cover">
                    <div class="relative w-1/2">
                        <img src="https://i.imgur.com/qE4J3fU.png" alt="Black Jacket"
                            class="rounded-lg h-full object-cover">
                        <div
                            class="absolute inset-0 bg-black bg-opacity-50 rounded-lg flex flex-col items-center justify-center text-white p-2 text-center">
                            <p class="font-bold">Denim Jacket with White Feathers</p>
                            <p class="text-3xl font-bold mt-2">240+</p>
                            <p class="text-xs">item sold out</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- JAVASCRIPT SECTION --}}
    @push('scripts')

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // --- Highcharts Indonesia Map ---
            const salesData = [
                ['id-ac', 120],
                ['id-jk', 300],
                ['id-jr', 240],
                ['id-ji', 180],
                ['id-yo', 90],
                ['id-bt', 60],
                ['id-bb', 30],
                ['id-nt', 50],
                ['id-ks', 70],
                ['id-su', 200],
                // Tambahkan kode provinsi lain jika ada
            ];

            Highcharts.mapChart('map', {
                chart: {
                    map: 'countries/id/id-all'
                },
                title: { text: '' },
                exporting: { enabled: false },
                colorAxis: {
                    min: 0,
                    minColor: '#DBEAFE', // tw blue-100
                    maxColor: '#1D4ED8'  // tw blue-700
                },
                tooltip: {
                    pointFormat: '{point.name}: <b>{point.value} Sales</b>'
                },
                series: [{
                    data: salesData,
                    name: 'Total Sales',
                    states: {
                        hover: {
                            color: '#2563EB'
                        }
                    },
                    dataLabels: {
                        enabled: false
                    }
                }]
            });

            // --- ApexCharts Revenue Chart ---
            const revenueChartOptions = {
                series: [
                    { name: 'Total revenue', data: [450, 620, 780, 827.29, 600, 950, 700] },
                    { name: 'Website', type: 'bar', data: [450, 620, 780, 827.29, 600, 950, 700] },
                ],
                chart: {
                    type: 'bar',
                    height: 320,
                    toolbar: { show: false },
                    stacked: true
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '45%',
                        borderRadius: 6
                    }
                },
                dataLabels: { enabled: false },
                stroke: { show: true, width: 2, colors: ['transparent'] },
                xaxis: {
                    categories: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                    labels: { style: { colors: '#6B7280' } },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    labels: { style: { colors: '#6B7280' } }
                },
                fill: { opacity: 1 },
                tooltip: {
                    y: {
                        formatter: val => "$ " + val
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    markers: { radius: 12 },
                    labels: { colors: '#6B7280' }
                },
                colors: ['#3B82F6', '#BFDBFE'],
                grid: {
                    borderColor: '#f1f1f1',
                    strokeDashArray: 3
                }
            };

            const revenueChart = new ApexCharts(document.querySelector("#revenue-growth-chart"), revenueChartOptions);
            revenueChart.render();
        });
    </script>
    @endpush
</x-admin.layout.layout>
