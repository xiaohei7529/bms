<template>
    <div id="app">
      <!-- 菜单栏 -->
      <el-header>
        <el-menu
          mode="horizontal"
          background-color="#545c64"
          text-color="#fff"
          active-text-color="#ffd04b"
          class="custom-menu"
        >
          <!-- 左侧项目名 -->
          <el-menu-item index="1" class="project-name">
            图书管理
          </el-menu-item>
  
          <!-- 中间菜单项 -->
          <div class="menu-center">
            <el-menu-item index="2">资源检索</el-menu-item>
            <el-menu-item index="3">资源推荐</el-menu-item>
            <el-menu-item index="4">资源导航</el-menu-item>
            <el-menu-item index="5">资源浏览</el-menu-item>
          </div>
  
          <!-- 右侧登录按钮 -->
          <el-menu-item index="6" class="login-button">
            <el-button type="primary" @click="handleLogin">登录</el-button>
          </el-menu-item>
        </el-menu>
      </el-header>
  
      <!-- 书籍检索模块 -->
      <el-main>
        <div class="search-module">
          <!-- 背景图 -->
          <div class="search-background"></div>
  
          <!-- 透明阴影区域 -->
          <div class="search-shadow">
            <!-- 下拉选择框 -->
            <div class="search-options">
              <el-select v-model="searchType" placeholder="全部检索">
                <el-option label="全部检索" value="all"></el-option>
                <el-option label="书名检索" value="title"></el-option>
                <el-option label="作者检索" value="author"></el-option>
              </el-select>
              <el-select v-model="matchType" placeholder="任意匹配">
                <el-option label="任意匹配" value="any"></el-option>
                <el-option label="精确匹配" value="exact"></el-option>
              </el-select>
            </div>
  
            <!-- 输入框 -->
            <el-input
              placeholder="请输入书名或作者"
              v-model="searchQuery"
              @keyup.enter="handleSearch"
            >
              <el-button slot="append" icon="el-icon-search" @click="handleSearch"></el-button>
            </el-input>
          </div>
        </div>
  
        <!-- 热门借阅模块 -->
        <el-card class="hot-borrow">
          <h3>热门借阅</h3>
          <el-row :gutter="20">
            <el-col :span="6" v-for="(book, index) in hotBooks" :key="index">
              <el-card :body-style="{ padding: '0px' }">
                <img :src="book.image" class="image" />
                <div style="padding: 14px;">
                  <span>{{ book.title }}</span>
                  <div class="bottom clearfix">
                    <el-button type="text" class="button">查看详情</el-button>
                  </div>
                </div>
              </el-card>
            </el-col>
          </el-row>
        </el-card>
  
        <!-- 新书推荐模块 -->
        <el-card class="new-books">
          <h3>新书推荐</h3>
          <el-row :gutter="20">
            <el-col :span="6" v-for="(book, index) in newBooks" :key="index">
              <el-card :body-style="{ padding: '0px' }">
                <img :src="book.image" class="image" />
                <div style="padding: 14px;">
                  <span>{{ book.title }}</span>
                  <div class="bottom clearfix">
                    <el-button type="text" class="button">查看详情</el-button>
                  </div>
                </div>
              </el-card>
            </el-col>
          </el-row>
        </el-card>
      </el-main>
    </div>
  </template>
  
  <script>
  export default {
    name: "App",
    data() {
      return {
        searchQuery: "", // 书籍检索输入框的值
        searchType: "all", // 检索类型
        matchType: "any", // 匹配类型
        hotBooks: [
          // 热门借阅书籍数据
          { title: "书籍1", image: "https://via.placeholder.com/150" },
          { title: "书籍2", image: "https://via.placeholder.com/150" },
          { title: "书籍3", image: "https://via.placeholder.com/150" },
          { title: "书籍4", image: "https://via.placeholder.com/150" },
        ],
        newBooks: [
          // 新书推荐书籍数据
          { title: "新书1", image: "https://via.placeholder.com/150" },
          { title: "新书2", image: "https://via.placeholder.com/150" },
          { title: "新书3", image: "https://via.placeholder.com/150" },
          { title: "新书4", image: "https://via.placeholder.com/150" },
        ],
      };
    },
    methods: {
      // 处理登录按钮点击事件
      handleLogin() {
        this.$message("登录功能待实现");
      },
      // 处理书籍检索
      handleSearch() {
        this.$message(`检索关键词: ${this.searchQuery}, 检索类型: ${this.searchType}, 匹配类型: ${this.matchType}`);
      },
    },
  };
  </script>
  
  <style>
  #app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
  }
  
  .el-header {
    padding: 0;
  }
  
  .custom-menu {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
  }
  
  .project-name {
    font-size: 18px;
    font-weight: bold;
    flex: 1;
  }
  
  .menu-center {
    display: flex;
    justify-content: center;
    flex: 2;
  }
  
  .login-button {
    flex: 1;
    display: flex;
    justify-content: flex-end;
  }
  
  /* 书籍检索模块样式 */
  .search-module {
    height: 300px;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
  }
  
  /* 背景图 */
  .search-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url("https://via.placeholder.com/1920x300"); /* 替换为你的背景图 */
    background-size: cover;
    background-position: center;
    z-index: 1;
  }
  
  /* 透明阴影区域 */
  .search-shadow {
    width: 1140px;
    height: 126px;
    background: rgba(255, 255, 255, 0.8); /* 透明阴影 */
    border-radius: 8px;
    display: flex;
    align-items: center;
    padding: 0 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    z-index: 2;
    position: relative;
  }
  
  /* 下拉选择框样式 */
  .search-options {
    display: flex;
    gap: 10px;
    margin-right: 20px;
  }
  
  /* 输入框样式 */
  .el-input {
    flex: 1;
  }
  
  .hot-borrow,
  .new-books {
    margin-top: 20px;
  }
  
  .image {
    width: 100%;
    height: 200px;
    object-fit: cover;
  }
  </style>