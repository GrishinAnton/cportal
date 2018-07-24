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
            <div class="table-busy">
                <div class="table-busy-row">
                    <div class="table-busy-header" v-for="(item, index) in dataTableHeader" :key="index">{{ item }}</div>
                </div>
                <div class="table-busy-row" v-for="(items, index) in dateTableBody" :key="index">
                    <div class="table-busy-cell" v-for="(item, index) in items" :key="index"><p>{{ item }}</p></div>
                </div>
            </div>
        </div>
    </div>
</template>


[1,2,3,4,5,67,7]


[1,[2,22],[3,33],4,5,67,7]
'<p>22</p> <p>22</p>'

<script>
    import moment from 'moment';

export default {
    data: () => ({
        dataTable: '',
        dataTableHeader: [],
        dateTableBody: [],
        data: {
            currentDate: `0${new Date().getMonth() + 1}`.slice(-2),
            dates: ''
        },
        startDay: 10,
        endDay: 17,
        dayWork: 7,
        roundDay: ''
        
    }),
    methods: {
        drawTableHeader() {
            var dayInMounth = moment().daysInMonth()
            var currentDay = moment().get('date');
            this.roundDay = dayInMounth - currentDay;

            this.dataTableHeader.push('ФИО');

            for (var i = currentDay; i <= dayInMounth; i++) {
                this.dataTableHeader.push(moment().set('date', i).format("DD/MM"))
            }
            
        },
        drawChart() {
            console.log('тетя мотя');    
            var dayHourEnd = this.endDay - moment().hour();

            for (var item of this.dataTable) { 
                var arr = []
                var time; //Переменная для подсчета либо оценочного времени, либо остатка вермени
                var arrTasks = [];// Тут собираеп все таски одого пользователя
                var arrTask = [];// тут собираем таски в течении одного дня пользователя   
                
                var day = [];
                var dayCounter = 1;

                item.tasks.sort(this.sortTasks) //сортируем таски, чтобы In Progress всегда были первыми тасками.  
                
                // console.log(item,'item');

                for (var task of item.tasks) {
                    console.log(arrTasks);
                    console.log(time, 'time');
                    

                    var arrName = `${item.firstName} ${item.lastName}`;
                    
                    if (task.different) {                          
                        time = task.different
                    }
                    time = task.estimated_time;                    


                    if (time > dayHourEnd) {
                        // console.log(time, 'top');
                        time = time - dayHourEnd;                        
                    } else {
                        // console.log(time, 'bottom');
                        time = time;
                    }

                    arrTasks.push(`${task.name} - ${time}`);

                    for (;time > 0;) {
                        time = time - this.dayWork;
                        arrTasks.push(`${task.name} - ${time}`);
                    }                                        
                }
                
                // arrTasks.push(arrTask)
                arr.push(arrName, arrTasks);                
                this.dateTableBody.push(arr);

                // console.log(this.dateTableBody);
            }
        },
        sortTasks(a,b){            
            if (a.task_list === 'In progress' && b.task_list === 'In progress') {                
                return 0
            } else if (b.task_list === 'In progress') {
                return 1
            } else if (a.task_list === 'In progress') {
                return -1
            }
            return 0
        }    
    },
    mounted(){

        axios.get('/api/busy', {
            params: {
                month: 7,
                year: 2018
            }
        })
        .then(response => {
            this.dataTable = response.data.data;
            this.data.dates = response.data.dates;

            this.drawTableHeader()
            this.drawChart()            
        })
        .catch( e => console.log(e))
    }
}
</script>


<style>

.box-body {
    overflow-x: auto;
}

.table-busy {
    display: table;
    border-collapse: collapse;

}

.table-busy-row {
    display: table-row;
    
}

.table-busy-header,
.table-busy-cell {
    display: table-cell;
    border: 1px solid #000;
}

.table-busy-header p {
    white-space: nowrap;
    word-break: break-all;
}
</style>
