<canvas id='myChart' width='75' height='75'></canvas>

<script>
    function toArray(str) {
        str = str.slice(1, str.length-1);
        return str.split(",");
    }

    let COLORS = [
        'rgba(220, 20, 60, 1)',
        'rgba(255, 96, 34, 1)',
        'rgba(255, 165, 0, 1)',
        'rgba(255, 255, 0, 1)',
        'rgba(127, 255, 0, 1)',
        'rgba(51, 255, 82, 1)',
        'rgba(51, 255, 149, 1)',
        'rgba(0, 128, 0, 1)',
        'rgba(0, 255, 255, 1)',
        'rgba(0, 128, 128, 1)',
        'rgba(0, 0, 255, 1)',
        'rgba(0, 191, 255, 1)',
        'rgba(255, 0, 255, 1)',
        'rgba(255, 34, 172, 1)',
        'rgba(75, 0, 130, 1)'
    ];

    let labels_array = toArray('{!! json_encode($categories) !!}');

    let data_array = toArray('{!! json_encode($actuals) !!}');

    let ctx = document.getElementById('myChart').getContext('2d');
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
            }
        }
    });
</script>