<template>
  <el-container class="admin-container">
    <!-- 顶栏 -->
    <el-header class="header">
      <el-row>
        <el-col :span="4">
          <div class="logo">图书管理系统</div>
        </el-col>
        <el-col :span="20">
          
          <div class="user-info">
            <el-dropdown @command="handleCommand">
              <span class="el-dropdown-link">
                <span class="username">{{ user.name }}</span>
              </span>
              <el-dropdown-menu slot="dropdown">
                <el-dropdown-item command="profile">个人中心</el-dropdown-item>
                <el-dropdown-item command="logout">退出登录</el-dropdown-item>
              </el-dropdown-menu>
            </el-dropdown>
          </div>
        </el-col>
      </el-row>
    </el-header>

    <!-- 主界面 -->
    <el-container>
      <!-- 左侧菜单栏 -->
      <el-aside width="200px">
        <el-menu
          default-active="dashboard"
          class="side-menu"
          @select="handleMenuSelect"
        >
          <el-menu-item index="dashboard">
            <i class="el-icon-s-home"></i>
            <span>仪表盘</span>
          </el-menu-item>
          <el-submenu index="book">
            <template slot="title">
              <i class="el-icon-notebook-2"></i>
              <span>图书管理</span>
            </template>
            <el-menu-item index="add-book">添加图书</el-menu-item>
            <el-menu-item index="admin/booklist">图书列表</el-menu-item>
            <el-menu-item index="admin/bookcategory">图书分类</el-menu-item>
            <el-menu-item index="admin/bookaudit">审批借阅图书</el-menu-item>
          </el-submenu>
          <el-submenu index="user">
            <template slot="title">
              <i class="el-icon-user"></i>
              <span>用户管理</span>
            </template>
            <el-menu-item index="user-list">用户列表</el-menu-item>
            <el-menu-item index="add-user">添加用户</el-menu-item>
          </el-submenu>
        </el-menu>
      </el-aside>

      <!-- 右侧内容 -->
      <el-main>
        <router-view></router-view>
      </el-main>
    </el-container>
  </el-container>
</template>

<script>
export default {
  data() {
    return {
      user: {
        name: '管理员',
        avatar: 'https://dummyimage.com/40x40/409EFF/fff' // 头像图片
      }
    };
  },
  methods: {
    // 处理菜单项选择
    handleMenuSelect(index) {
      console.log(index)
      this.$router.push(`/${index}`);
    },
    // 处理用户操作
    handleCommand(command) {
      if (command === 'logout') {
        this.$confirm('确定要退出登录吗？', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          this.$message.success('退出登录成功');
          this.$router.push('/login');
        });
      } else if (command === 'profile') {
        this.$router.push('/profile');
      }
    }
  }
};
</script>

<style scoped>
.admin-container {
  height: 100vh;
}

.header {
  background-color: #00a0e9;
  color: #fff;
  line-height: 60px;
  padding: 2px;
}

.logo {
  font-size: 20px;
  font-weight: bold;
  margin-left:20px;
}

.top-menu {
  float: left;
}

.user-info {
  float: right;
  margin-right: 20px;
  color: #fff;
}

.username {
  margin-left: 10px;
  font-size: 14px;
  color: #fff;
}

.side-menu {
  height: 100%;
}

.el-main {
  padding: 20px;
}

</style>