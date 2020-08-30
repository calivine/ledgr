<div class="chart-container">
    <canvas id="lineChart"></canvas>
</div>

<script>
    function toArray(str, labels=true) {
        str = str.slice(1, str.length-1);
        str = str.split(",");
        if (labels) {
            for (let i = 0; i < str.length; i++) {
                str[i] = str[i].replace(str[i].charAt(0), '');
                str[i] = str[i].replace(str[i].charAt(str[i].length-1), '');
            }
        }
        return str;
    }
    let label_array = toArray('{!! json_encode($line_chart_labels) !!}');

    let line_data_array = toArray('{!! json_encode($line_chart_data) !!}', labels=false);

    console.log(label_array);
    console.log(line_data_array);

    let ltx = document.getElementById('lineChart').getContext('2d');
    Chart.plugins.register({
        ChartDataLabels
    });

    let lineChart = new Chart(ltx, {
        type: 'line',
        data: {
            labels: label_array,
            datasets: [{
                backgroundColor: '#38C172',
                borderColor: '#38C172',
                data: line_data_array
            }]
        },
        options: {
            legend: {
                display: false,
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        let label = tooltipItem.value || '';
                        console.log(data.datasets);
                        console.log(tooltipItem);
                        if (label) {
                            label = '$'+label;
                        }
                        return label;
                    }
                }
            },
            plugins: {
                datalabels: {
                    anchor: 'start',
                    color: 'black',
                    formatter: function(value) {
                        return '$'+value;
                    }
                }
            }
        }
    });
</script>
