import Vue from 'vue'
import Router from 'vue-router'
import Index from '@/views/Index'
import Main from '@/views/layout/Main'
import AddArticle from '@/views/article/AddArticle'
import ArticleList from '@/views/article/ArticleList'
import CategoryList from '@/views/article/CategoryList'

Vue.use(Router);

export default new Router({
    routes: [
        {
            path: '/',
            name: 'Index',
            component: Index
        },
        {
            path : '/',
            name : 'Main',
            component : Index,
            children : [
                { path : 'article/add' ,component : AddArticle , name : 'AddArticle'},
                { path : 'article/list' ,component : ArticleList , name : 'ArticleList'},
                { path : 'category/list' ,component : CategoryList , name : 'CategoryList'},
                { path : 'category/list/:parentid' ,component : CategoryList , name : 'CategoryList'}
            ]
        }
    ]
})
