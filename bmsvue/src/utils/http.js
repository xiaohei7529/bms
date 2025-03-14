import axios from 'axios';


// 创建 Axios 实例
const http = axios.create({
  // baseURL: 'http://bms.test:3333/', // 替换为你的 API 基础路径
  // baseURL: '/api', // 替换为你的 API 基础路径
  baseURL: process.env.BASE_API, // 替换为你的 API 基础路径
  timeout: 10000, // 请求超时时间
});

// 添加请求拦截器，设置 Authorization 头
http.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token'); // 从本地存储中获取 Token
    if (token) {
      config.headers.Authorization = `Bearer `+token; // 设置 Bearer Token
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// 添加响应拦截器
http.interceptors.response.use(
  
  (response) => {
    console.log(response)
    if (response && (response.data.code === 401 || response.data.code === 422)) {
      // 可以在此添加跳转逻辑
      toLogin();
      return false;
    }
    return response.data; // 简化响应数据
  },
  (error) => {
    if (error.response && (error.response.status === 401 || error.response.status === 422)) {
      // 可以在此添加跳转逻辑
      toLogin();
    }
    return Promise.reject(error);
  }
);

function toLogin() {
  localStorage.removeItem('token');
  this.$router.push({ path: '/login', params: { r: Math.random() } });
}

export default http;
