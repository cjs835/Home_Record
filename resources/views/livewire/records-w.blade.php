<div>

    <div class="card bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <div class="flex flex-row flex-wrap justify-between items-center">
            <h2 class="font-bold text-lg">溫度</h2>
        </div>
        <div id="tempchart">
        </div>
    </div>

    <div class="mt-10 card bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <div class="flex flex-row flex-wrap justify-between items-center">
            <h2 class="font-bold text-lg">濕度</h2>
        </div>
        <div id="humchart">
        </div>
    </div>

    <script>
        var tempchartoptions = {
                chart: {
                type: 'area',
                height: 325,
                animations: {
                    enabled: false,
                }
            },
            stroke: {
                curve: 'smooth'
            },
            dataLabels: {
                enabled: false
            },
            markers: {
                size: 4,
            },
            series: [{
                name: 'temperature',
                data: @json($temperature)
            }],
            xaxis: {
                type: 'datetime',
                labels: {
                    format: 'yyyy-MM-dd HH',
                    datetimeUTC:false,
                }
            },
            tooltip: {
                x: {
                    format: 'yyyy-MM-dd HH',
                }
            }
        }

        var tempchart = new ApexCharts(document.querySelector("#tempchart"), tempchartoptions);

        tempchart.render();
    </script>

    <script>

        var humchartoptions = {
                chart: {
                type: 'area',
                height: 325,
                animations: {
                    enabled: false,
                }
            },
            stroke: {
                curve: 'smooth'
            },
            dataLabels: {
                enabled: false
            },
            markers: {
                size: 4,
            },
            series: [{
                name: 'humidity',
                data: @json($humidity)
            }],
            xaxis: {
                type: 'datetime',
                labels: {
                    format: 'yyyy-MM-dd HH',
                    datetimeUTC:false,
                }
            },
            tooltip: {
                x: {
                    format: 'yyyy-MM-dd HH',
                }
            }
        }

        var humchart = new ApexCharts(document.querySelector("#humchart"), humchartoptions);

        humchart.render();
    </script>
</div>
