<template>
    <div>
        <ul class="nav flex-column">
            <li v-for="item in navItems" :key="item.id" class="nav-item" :class="{'active': item.href == url}">
                <a @click.prevent="menuClick($event)" :href="item.href" class="nav-link">
                    <i :class="item.icon"></i>
                    <span>{{ item.name }}</span>
                </a>
                <i class="fa fa-plus submenu-toggle" v-if="item.subMenu" @click="openMnu($event)"></i>
                <ul class="nav flex-column nav-submenu" v-if="item.subMenu" ref="submenu">
                    <li class="nav-item" v-for="subItem in item.subMenu" :key="subItem.id" :class="{'active': subItem.href == url}">
                        <a :href="subItem.href" class="nav-link">
                            <i :class="subItem.icon"></i>
                            <span>{{ subItem.name }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
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
                    name: "Отчет",
                    href: '#',
                    subMenu: [
                        {
                            icon: "fa fa-fw fa-money",
                            name: "Финансы",
                            href: '/report/costs',
                            id: 3.1
                        },
                        {
                            icon: "fa fa-fw fa-folder",
                            name: "Проекты",
                            href: '/projects',
                            id: 3.2
                        },
                        {
                            icon: "fa fa-fw fa-user-md",
                            name: "Выработка",
                            href: '/productivity',
                            id: 3.3
                        },
                        {
                            icon: "fa fa-fw fa-user-md",
                            name: "Сводный",
                            href: '/report',
                            id: 3.4
                        },
                        {
                            icon: "fa fa-fw fa-user-md",
                            name: "Виджет",
                            href: '/report/widget-time',
                            id: 3.5
                        }
                    ],
                    id: 3
                },
                {
                    icon: "fa fa-fw fa-user",
                    name: "Сотрудники",
                    href: '/employees',
                    id: 4
                },
                {
                    icon: "fa fa-fw fa-file",
                    name: "ActiveCollab",
                    href: '/activecollab',
                    id: 5,
                }
            ]
        }),
        methods: {
            openMnu(e){               
                e.srcElement.nextElementSibling.classList.toggle('nav-submenu-show');                
            },
            menuClick(e){
                var elemLink;                

                if(e.srcElement.tagName === 'A'){
                    elemLink = e.srcElement;
                } else {
                    var elem = e.srcElement;

                    while (elem.tagName !== 'A'){                        
                        elem = e.srcElement.parentNode;
                    }
                    elemLink = elem;
                }

                if(elemLink.attributes.href.value !== '#'){
                    window.location.href =  elemLink.attributes.href.value;        
                } else {
                    elemLink.nextElementSibling.nextElementSibling.classList.toggle('nav-submenu-show'); 
                }
            }
            
        },
        mounted(){            
            this.$refs.submenu[0].childNodes.forEach((item)=>{
                item.classList.forEach((item) => {
                    if(item === 'active') {  
                          this.$refs.submenu[0].classList.add('nav-submenu-show');
                        return                        
                    }

                    return;
                });
            });
        }
    }
</script>
