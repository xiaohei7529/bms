// const { defineConfig } = require('@vue/cli-service')
// module.exports = defineConfig({
//   transpileDependencies: true
// })


const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  transpileDependencies: true,
  devServer: {
    proxy: {
      '/api': {
        target: 'http://bms.test:3333/', // 你的目标服务器地址
        changeOrigin: true,  // 是否跨域
        secure: false, // 如果是https接口，需要配置这个参数
        pathRewrite: {
          '^/api': ''   // 路径重写
        },
        headers: {
          'Access-Control-Allow-Origin': '*', // 允许所有源
          'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE, OPTIONS', // 允许的请求方法
          'Access-Control-Allow-Headers': 'Content-Type, Authorization' // 允许的请求头
        }
      }
    }
  }
})


// module.exports = {
//   decServer:{
//     proxy: {
//       '/api': {
//         target: 'http://bms.test:3333/',
//         changeOrigin: true,  //是否跨域
//         pathRewrite: {
//           '^/api': ''   //需要rewrite重写的,
//         }
//       },
//     },
//   }
// }

// import {defineConfig} from 'vite'
// import vue from '@vitejs/plugin-vue'

// export default defineConfig({
//   plugins: [vue()],
//     server: {
//     proxy: {
//       '/api': { // 代理前缀（自定义）
//         target: 'http://your-api-domain.com', // 目标服务器地址
//         changeOrigin: true, // 允许跨域
//         rewrite: (path) => path.replace(/^\/api/, '') // 路径重写
//       }
//     }
//   }
// })


// import { defineConfig } from 'vite'

// module.exports =  defineConfig({
//   transpileDependencies: true,
//   server: {
//     proxy: {
//       '/api': { // 代理前缀（自定义）
//         target: 'http://your-api-domain.com', // 目标服务器地址
//         changeOrigin: true, // 允许跨域
//         rewrite: (path) => path.replace(/^\/api/, '') // 路径重写
//       }
//     }
//   }
// })
