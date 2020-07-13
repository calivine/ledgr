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

    let ltx = document.getElementById('lineChart').getContext('2d');

    let lineChart = new Chart(ltx, {
        type: 'line',
        data: {
            labels: label_array,
            datasets: [{
                data: line_data_array
            }]
        }
    });

</script>