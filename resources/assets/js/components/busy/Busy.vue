<template>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                Загрузка
            </h3>
        </div>
        <div class="box-header with-border">
            <div class="input-group mr-4" v-if="data.dates.length">
                <form>
                    <label for="company">Дата</label>
                    <select class="custom-select" id="company"
                        v-model="data.currentDate"
                        >
                        <option 
                            :value="item.month"
                            v-for="item in data.dates" :key="item.id"
                        >{{ item.month }}</option>
                    </select>
                </form>
            </div> 
        </div>
        <div class="box-body">      
            <div id="chart1"></div>
        </div>
    </div>
</template>


<script>
    import {GoogleCharts} from 'google-charts';
    import moment from 'moment';

export default {
    data: () => ({
        dataTable: '',
        data: {
            currentDate: `0${new Date().getMonth() + 1}`.slice(-2),
            dates: ''
        },
        startDay: 10,
        endDay: 17
        
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

            //Первый этам найти все таски пользователя со статусом in progress
            //Оценка - estimated_time
            //Остаток времени - different
            //Если есть остаток времени, значит оценка уже не важн. Если его нет, значит ориентируемся на оценку

            
            for (var item of this.dataTable) {                

                for (var task of item.tasks) {

                    if (task.task_list === 'In progress') {

                        var currentTime = new Date();
                        var currentDate = new Date();

                        if (task.different) {
                            var dayHourEnd = this.endDay - moment().hour()
                            // console.log(dayHourEnd, 'dayEnd');
                            // console.log(task.different, 'taskDiffererbnt');
                            
                            
                            if (dayHourEnd > task.different) {
                                console.log("+++");                                
                            } else {
                                // console.log(task.different, 'start');
                                
                                task.different = task.different - dayHourEnd
                                currentTime.setHours(currentTime.getHours() + task.different)
                                dataTable.addRows([[`${item.firstName} ${item.lastName}`, task.name, new Date(), new Date(currentTime)]])
                                // console.log(task.different, 'end');


                                for(;task.different >= dayHourEnd;){

                                    currentDate.setDate(currentDate.getDate() + 1)
                                    var currentStartTime = currentDate.setHours(10)                                    
                                    var currentEndTime = currentDate.setHours(10 + task.different)
                                    

                                    dataTable.addRows([[`${item.firstName} ${item.lastName}`, task.name, new Date(currentStartTime), new Date(currentEndTime)]])
                                    task.different = task.different - dayHourEnd
                                }                               

                                
                            }

                            // currentTime.setHours(currentTime.getHours() + task.different)

                            // console.log(moment.duration(task.different, "hours").humanize());
                            // var dddd = Date.parse(moment().format("YYYY, M, D, h"))
                            // console.log(dddd);

                            // dataTable.addRows([[`${item.firstName} ${item.lastName}`, task.name, new Date(), new Date(currentTime)]])
                        }                        
                    }                    
                }
            }            

            // dataTable.addRows([
            //     
            //     [ 'George Washington', 'President2', new Date(2018, 6, 17), new Date(2018, 6, 19) ],
            //     [ 'George Washington', 'President3', new Date(2018, 6, 21), new Date(2018, 6, 22) ],
            //     [ 'Vice President', 'John Adams', new Date(2018, 6, 16), new Date(2018, 6, 17)],
            //     [ 'Vice President', 'Thomas Jefferson', new Date(2018, 6, 18), new Date(2018, 6, 20)],
            //     [ 'Secretary of State', 'Thomas Jefferson', new Date(2018, 6, 16), new Date(2018, 6, 19)],
            //     [ 'Secretary of State', 'Edmund Randolph', new Date(2018, 6, 22), new Date(2018, 7, 28)],
            // ]);

            var options = {
                hAxis: {
                    // format: 'd/M/yy',
                    // viewWindow: {
                    //     min: new Date(2018, 6, 1),
                    //     max: new Date(2018, 6, 15)
                    // }
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
            this.dataTable = response.data.data;
            this.data.dates = response.data.dates; 
            
        })
        .catch( e => console.log(e))
    }
}
</script>
