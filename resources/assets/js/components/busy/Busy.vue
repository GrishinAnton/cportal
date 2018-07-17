<template>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                Загрузка
            </h3>
        </div>
        <div class="box-body">      
            <div id="chart1"></div>
        </div>
    </div>
</template>


<script>
    import {GoogleCharts} from 'google-charts';

export default {
    data: () => ({
    }),
    methods: {
        drawChart() {

            var container = document.getElementById('chart1');
            var chart = new google.visualization.Timeline(container);
            var dataTable = new google.visualization.DataTable();

            dataTable.addColumn({ type: 'string', id: 'Name' });
            dataTable.addColumn({ type: 'string', id: 'Task' });
            dataTable.addColumn({ type: 'date', id: 'Start' });
            dataTable.addColumn({ type: 'date', id: 'End' });

            dataTable.addRows([
                [ 'George Washington', 'President1', new Date(2018, 7, 16), new Date(2018, 7, 17) ],
                [ 'George Washington', 'President2', new Date(2018, 7, 17), new Date(2018, 7, 19) ],
                [ 'George Washington', 'President3', new Date(2018, 7, 21), new Date(2018, 7, 22) ],
                [ 'Vice President', 'John Adams', new Date(2018, 7, 16), new Date(2018, 7, 17)],
                [ 'Vice President', 'Thomas Jefferson', new Date(2018, 7, 18), new Date(2018, 7, 20)],
                [ 'Secretary of State', 'Thomas Jefferson', new Date(2018, 7, 16), new Date(2018, 7, 19)],
                [ 'Secretary of State', 'Edmund Randolph', new Date(2018, 7, 22), new Date(2018, 7, 28)],
            ]);

            var options = {
                hAxis: {
                    format: 'd/M/yy',
                }            
            };

            chart.draw(dataTable, options);
        }
    },
    mounted(){
        GoogleCharts.load(this.drawChart, {
            'packages': ['timeline'],
        }); 

        axios.get('/api/busy', {
            params: {
                month: 7,
                year: 2018
            }
        })
        .then(response => {
            console.log(response, '111');
            
        })
        .catch( e => console.log(e))
    }
}
</script>
