import axios from 'axios';


// 创建 Axios 实例
const http = axios.create({
  // baseURL: '/api', // 替换为你的 API 基础路径
  // baseURL: process.env.BASE_API, // 替换为你的 API 基础路径
  baseURL: 'http://bms.test:3333/api', // 替换为你的 API 基础路径
  timeout: 10000, // 请求超时时间
  headers:{//请求头，可以加上toekn等内容
    'Content-Type': 'application/json;charset=utf-8'
  },
});

export default http;
