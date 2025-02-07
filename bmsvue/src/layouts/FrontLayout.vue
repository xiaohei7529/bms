<template>
  <div class="front-layout">
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
    <router-view></router-view>
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
        { id: 1, title: "书籍1", image: "https://via.placeholder.com/150" },
        { id: 2, title: "书籍2", image: "https://via.placeholder.com/150" },
        { id: 3, title: "书籍3", image: "https://via.placeholder.com/150" },
        { id: 4, title: "书籍4", image: "https://via.placeholder.com/150" },
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

<style scoped>
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

  /* .front-layout {
    text-align: center;
  } */
</style>