<template>
  <div>
    <el-container>

      <!-- 菜单栏 -->
      <el-header>
        <el-menu mode="horizontal" background-color="#264347" text-color="#fff" active-text-color="#ffd04b"
          class="custom-menu">
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

          <!-- 右侧登录按钮或用户头像 -->
          <el-menu-item index="6" class="login-button">
            <div v-if="!isLoggedIn">
              <el-button type="primary">
                <router-link to="/register" class="register-link">注册</router-link>
              </el-button>
              <el-button type="primary">
                <router-link to="/login" class="register-link"> 登录</router-link>
              </el-button>
            </div>
            <div v-else>
              <el-dropdown @command="handleCommand">
                <div class="user-avatar">
                  <el-avatar :size="40" :src="userAvatar"></el-avatar>
                </div>
                <el-dropdown-menu slot="dropdown">
                  <el-dropdown-item command="profile">个人信息</el-dropdown-item>
                  <el-dropdown-item command="borrow">借阅图书</el-dropdown-item>
                  <el-dropdown-item command="logout">退出登录</el-dropdown-item>
                </el-dropdown-menu>
              </el-dropdown>
            </div>
          </el-menu-item>
        </el-menu>
      </el-header>


      <el-main>
        <div class="search-module">
          <!-- 背景图 -->
          <img class="search-background">

          <!-- 透明阴影区域 -->
          <div class="search-shadow">
            <div class="search-shadow1">
              <div class="search-shadow2">
                <!-- 输入框 -->
                <el-input placeholder="请输入书名或作者" v-model="searchQuery" @keyup.enter="handleSearch">

                  <el-select v-model="searchType" slot="prepend" placeholder="全部检索">
                    <el-option label="全部检索" value="all"></el-option>
                    <el-option label="书名检索" value="title"></el-option>
                    <el-option label="作者检索" value="author"></el-option>
                  </el-select>

                  <el-select v-model="matchType" slot="prepend" placeholder="任意匹配">
                    <el-option label="任意匹配" value="any"></el-option>
                    <el-option label="精确匹配" value="exact"></el-option>
                  </el-select>

                  <el-button slot="append" icon="el-icon-search" @click="handleSearch">检索</el-button>
                </el-input>
              </div>
            </div>
          </div>
        </div>

        <!-- 热门借阅模块 -->
        <div class="hot-borrow">
          <el-card>
            <div class="module-header">
              <!-- 左侧标题 -->
              <div class="title-group">
                <span :class="['title', activeTab === 'borrow' ? 'active' : '']" @click="switchTab('borrow')">
                  热门借阅
                </span>
                <span :class="['title', activeTab === 'collect' ? 'active' : '']" @click="switchTab('collect')">
                  热门收藏
                </span>
                <span :class="['title', activeTab === 'score' ? 'active' : '']" @click="switchTab('score')">
                  高分图书
                </span>
              </div>

              <!-- 右侧查看更多 -->
              <span class="more" @click="handleMore">查看更多</span>
            </div>
            <el-divider></el-divider>


            <!-- 图书列表 -->
            <el-row :gutter="20">
              <el-col :span="6" v-for="(book, index) in currentBooks" :key="index">
                <el-card :body-style="{ padding: '0px' }">
                  <img :src="book.image" class="image" />
                  <div style="padding: 14px;">
                    <span>{{ book.title }}</span>
                    <div class="bottom clearfix">
                      <el-button type="text" class="button">
                        <router-link target="_blank" :to="`/bookDetails/${book.id}`" class="register-link"> 查看详情</router-link>
                      </el-button>
                    </div>
                  </div>
                </el-card>
              </el-col>
            </el-row>
          </el-card>
        </div>

        <!-- 新书推荐模块 -->
        <div class="new-books">
          <el-card>
            <div class="module-header">
              <!-- 左侧标题 -->
              <span class="title">新书推荐</span>

              <!-- 右侧查看更多 -->
              <span class="more" @click="handleMoreNewBooks">查看更多</span>
            </div>
            <el-divider></el-divider>


            <!-- 图书列表 -->
            <el-row :gutter="20">
              <el-col :span="6" v-for="(book, index) in newBooks" :key="index">
                <el-card :body-style="{ padding: '0px' }">
                  <img :src="book.image" class="image" />
                  <div style="padding: 14px;">
                    <span>{{ book.title }}</span>
                    <div class="bottom clearfix">
                      <el-button type="text" class="button">
                        <router-link target="_blank" :to="`/bookDetails/${book.id}`" class="register-link"> 查看详情</router-link>
                      </el-button>                    
                    </div>
                  </div>
                </el-card>
              </el-col>
            </el-row>
          </el-card>
        </div>
      </el-main>

      <router-view />
    </el-container>
  </div>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      isLoggedIn: false, // 登录状态
      userAvatar: "https://via.placeholder.com/150", // 用户头像
      userName: "用户", // 用户名
      userStore: {
        Visiable: false,
        Register: false,
      },
      User: {
        email: '',
        password: '',
      },
      searchQuery: "", // 书籍检索输入框的值
      searchType: "all", // 检索类型
      matchType: "any", // 匹配类型
      activeTab: "borrow", // 当前选中的标签
      hotBooks: [
        // 热门借阅书籍数据
        { id:1, title: "书籍1", image: "https://via.placeholder.com/150" },
        { id:2, title: "书籍2", image: "https://via.placeholder.com/150" },
        { id:3, title: "书籍3", image: "https://via.placeholder.com/150" },
        { id:4, title: "书籍4", image: "https://via.placeholder.com/150" },
      ],
      collectBooks: [
        // 热门收藏书籍数据
        { title: "收藏1", image: "https://via.placeholder.com/150" },
        { title: "收藏2", image: "https://via.placeholder.com/150" },
        { title: "收藏3", image: "https://via.placeholder.com/150" },
        { title: "收藏4", image: "https://via.placeholder.com/150" },
      ],
      scoreBooks: [
        // 高分图书数据
        { title: "高分1", image: "https://via.placeholder.com/150" },
        { title: "高分2", image: "https://via.placeholder.com/150" },
        { title: "高分3", image: "https://via.placeholder.com/150" },
        { title: "高分4", image: "https://via.placeholder.com/150" },
      ],
      newBooks: [
        // 新书推荐书籍数据
        { title: "新书1", image: "https://via.placeholder.com/150" },
        { title: "新书2", image: "https://via.placeholder.com/150" },
        { title: "新书3", image: "https://via.placeholder.com/150" },
        { title: "新书4", image: "https://via.placeholder.com/150" },
      ],
    }
  },
  computed: {
    // 根据当前选中的标签返回对应的图书数据
    currentBooks() {
      if (this.activeTab === "borrow") {
        return this.hotBooks;
      } else if (this.activeTab === "collect") {
        return this.collectBooks;
      } else if (this.activeTab === "score") {
        return this.scoreBooks;
      }
      return [];
    },
  },
  methods: {
    // 处理登录按钮点击事件
    handleLogin() {
      // 模拟登录成功
      this.$http.post('api/auth/userLogin', { email: this.User.email, password: this.User.password })
        .then((response) => {
          localStorage.setItem('token', response.access_token); // 存储 Token
          console.log('Login successful!');
          this.$notify({
            title: '成功',
            message: '登录成功！',
            type: 'success'
          });

          this.isLoggedIn = true;
          // this.$message.success("登录成功");
        })
        .catch((error) => {
          console.error('Login failed:', error);
        });
    },
    handleRegister() {

    },
    // 处理下拉菜单选项
    handleCommand(command) {
      switch (command) {
        case "logout":
          this.handleLogout();
          break;
        case "profile":
          this.handleProfile();
          break;
        case "borrow":
          this.handleBorrow();
          break;
      }
    },
    // 处理退出登录
    handleLogout() {
      localStorage.removeItem('token');
      this.isLoggedIn = false;
      this.$message.success("退出登录成功");
    },
    // 处理个人信息
    handleProfile() {
      this.$message("个人信息功能待实现");
    },
    // 处理借阅图书
    handleBorrow() {
      this.$message("借阅图书功能待实现");
    },
    // 处理书籍检索
    handleSearch() {
      this.$message(`检索关键词: ${this.searchQuery}, 检索类型: ${this.searchType}, 匹配类型: ${this.matchType}`);
    },
    // 切换标签
    switchTab(tab) {
      this.activeTab = tab;
    },
    // 处理查看更多
    handleMore() {
      this.$message("查看更多功能待实现");
    },
    // 处理新书推荐查看更多
    handleMoreNewBooks() {
      this.$message("查看更多新书功能待实现");
    },
  }
}
</script>

<style>
.el-header {
  padding: 0;
  width: 100%;
  position: fixed;
  z-index: 999;
}

.el-main {
  margin: 0;
  padding: 0;
  margin-top: 60px;
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
    width: 100%;
    height: 300px;
    position: relative;
    padding-top:50px;
    margin-bottom:16px;
  }
  
  /* 背景图 */
  .search-background {
    position: absolute;
    top: 0;
    width: 100%;
    height: 100%;
    background-image: url("https://static12.libsp.cn/static/img/new3.0bg.fc712c1.png"); /* 替换为你的背景图 */
    object-fit: cover;
  }
  
  /* 透明阴影区域 */
  .search-shadow {
    margin: auto;
    position: relative;
    width: 1060px;
    height: 126px;
    background: rgba(0,0,0,.25); /* 透明阴影 */
  }

    /* 透明阴影区域 */
  .search-shadow1 {
    width: 100%;
    position: relative;
    left: 0;
    top: 23px;
    z-index: 4;
    border-radius: 0 0 3px 4px;
  }

  
  /* 下拉选择框样式 */
  .search-shadow2 {
    margin: auto;
    width: 936px;
    height: 40px;
    position: relative;
    left: 0;
    top: 23px;
    z-index: 4;
    border-radius: 0 0 3px 4px;
    .el-button {
      background-color: #05a081;
      color: #fff;
    }
  }
  
  /* 输入框样式 */
  .el-input {
    flex: 1;
  }
  
  /* 热门借阅模块样式 */
  .hot-borrow {
    margin: auto;
    margin-top: 20px;
    width: 1240px;;
  }

    /* 新书推荐模块样式 */
  .new-books {
    margin: auto;
    margin-top: 20px;
    width: 1240px;;
  }
  
  .module-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }
  
  .title-group {
    display: flex;
    gap: 20px;
  }
  
  .title {
    font-size: 18px;
    font-weight: bold;
    cursor: pointer;
    color: #333;
  }
  
  .title.active {
    color: #409eff; /* 选中时的颜色 */
  }
  
  .more {
    font-size: 14px;
    color: #999;
    cursor: pointer;
  }
  
  .image {
    width: 100%;
    height: 200px;
    object-fit: cover;
  }
  
  .login-button {
    flex: 1;
    display: flex;
    justify-content: flex-end;
  }
  
  .user-avatar {
    cursor: pointer;
  }
  /* 取消 router-link 的下划线 */
  .register-link {
    text-decoration: none;
  }

  .router-link-active {
    text-decoration: none;
  }
  .el-select .el-input {
    width: 130px;
  }
</style>
