<div class="chart-container">
    <canvas id='myChart'></canvas>
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
    /*
    function shuffle(array) {
        array.sort(() => Math.random() - 0.5)
    }

     */

    let COLORS = [
        'rgba(220, 20, 60, 1)',
        'rgba(75, 0, 130, 1)',
        'rgba(0, 0, 255, 1)',
        'rgba(0, 128, 128, 1)',
        'rgba(8, 71, 34, 1)',
        'rgba(255, 96, 34, 1)',
        'rgba(0, 255, 255, 1)',
        'rgba(255, 165, 0, 1)',
        'rgba(0, 128, 0, 1)',
        'rgba(127, 255, 0, 1)',
        'rgba(51, 255, 149, 1)',
        'rgba(255, 0, 255, 1)',
        'rgba(0, 191, 255, 1)',
        'rgba(255, 34, 172, 1)',
    ];
    let category_labels_array = toArray('{!! json_encode($category_form_labels) !!}');
    let labels_array = toArray('{!! json_encode($categories) !!}');

    let data_array = toArray('{!! json_encode($actuals) !!}', labels=false);

    console.log(labels_array);
    console.log(data_array);

    let ctx = document.getElementById('myChart').getContext('2d');
    Chart.plugins.register({
        ChartDataLabels
    });

    let myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels_array,
            datasets: [{
                data: data_array,
                backgroundColor: COLORS,
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            cutoutPercentage: 40,
            legend: {
                labels: {
                    boxWidth: 20
                }
            },
            plugins: {
                datalabels: {
                    color: '#FFFFFF',
                    formatter: function(value) {
                        return '$'+value;
                    }
                }
            }
        }
    });
</script>
