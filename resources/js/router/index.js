import {createRouter, createWebHistory} from  'vue-router'
import admin from './admin.js'
import home from './home.js'

const routes = [...admin, ...home]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router