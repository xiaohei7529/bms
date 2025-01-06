<template>
  <div id="app">
    <!-- 菜单栏 -->
    <el-header>
      <el-menu mode="horizontal" background-color="#545c64" text-color="#fff" active-text-color="#ffd04b"
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
            <el-button type="primary" @click="userStore.Register=true">注册</el-button>
            <el-button type="primary" @click="userStore.Visiable=true">登录</el-button>
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
    <router-view />

    <div class="login">
      <el-dialog title="用户登录" :visible.sync="userStore.Visiable" width="40%">
        <div class="left">
          <h1>用户登录</h1>
          <div class="input">
            <el-form label-width="50px" :model="User" style="width: 350px">
              <el-form-item label="账号">
                <el-input  v-model.email="User.email" placeholder="请输入邮箱" />
              </el-form-item>
              <el-form-item label="密码">
                <el-input v-model.email="User.password" placeholder="请输入6位密码" />
              </el-form-item>
              <el-form-item>
                <el-checkbox label="记住账号"></el-checkbox>
              </el-form-item>
            </el-form>
          </div>
          <div class="button">
            <el-button style="width: 75%" type="primary" size="default" @click="handleLogin">用户登录</el-button>
          </div>
        </div>
      </el-dialog>
    </div>

    <div class="login">
      <el-dialog title="用户注册" :visible.sync="userStore.Register" width="40%">
        <div class="left">
          <h1>用户注册</h1>
          <div class="input">
            <el-form label-width="50px" :model="User" style="width: 350px">
              <el-form-item label="账号">
                <el-input  v-model.email="User.email" placeholder="请输入邮箱" />
              </el-form-item>
              <el-form-item label="密码">
                <el-input v-model.email="User.password" placeholder="请输入6位密码" />
              </el-form-item>
            </el-form>
          </div>
          <div class="button">
            <el-button style="width: 75%" type="primary" size="default" @click="handleRegister">用户注册</el-button>
          </div>
        </div>
      </el-dialog>
    </div>

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
      userStore:{
        Visiable:false,
        Register:false,
      },
      User:{
        email:'',
        password:'',
      }
    }
  },
  methods:{
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

          this.$message.success("登录成功");
        })
        .catch((error) => {
          console.error('Login failed:', error);
        });
    },
    handleRegister(){

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
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  /* text-align: center; */
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


.login {
  .left {
    border: 1px solid #ccc;
    h1 {
      font-size: 20px;
      margin: 30px 10px 30px 10px;
      text-align: center;
    }
    .input {
      margin: 0px 0px 0px 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .button {
      display: flex;
      flex-direction: column;
      align-items: center;
    }
  }
}
</style>
