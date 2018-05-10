<template>
    <div>
        <b-nav vertical>
            <b-nav-item v-for="item in navItems" :key="item.id" :href="item.href">
                <i :class="item.icon"></i>
                <span>{{ item.name }}</span>
            </b-nav-item>
        </b-nav>
    </div>
</template>

<script>
    export default {
        props: {
            url: {
                type: String
            }
        },
        data: () => ({
            navItems: [
                {
                    icon: "fa fa-fw fa-file",
                    name: "Главная",
                    href: '/dashboard',
                    id: 1
                },
                {
                    icon: "fa fa-fw fa-user",
                    name: "Персонал",
                    href: '/personal',
                    id: 2
                },
                {
                    icon: "fa fa-fw fa-file",
                    name: "Проекты",
                    href: '/projects',
                    id: 3
                },
                {
                    icon: "fa fa-fw fa-file",
                    name: "Финансы",
                    href: '/finance/costs',
                    id: 4
                },
                {
                    icon: "fa fa-fw fa-file",
                    name: "Отчет",
                    href: '/report',
                    id: 5
                },
                {
                    icon: "fa fa-fw fa-user",
                    name: "Сотрудники",
                    href: '/employees',
                    id: 6
                }
            ]
        }),
        mounted(){
            console.log(this.url);
            
        }
    }
</script>
