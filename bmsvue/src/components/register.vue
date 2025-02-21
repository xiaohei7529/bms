<!-- <template>
    <div class="login">
      <el-dialog title="用户注册" :visible.sync="userStore.Register" width="40%">
        <div class="left">
          <h1>用户注册</h1>
          <div class="input">
            <el-form label-width="50px" :model="User" style="width: 350px">
              <el-form-item label="账号">
                <el-input v-model.email="User.email" placeholder="请输入邮箱" />
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
    }

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
    // 处理退出登录
    handleLogout() {
      localStorage.removeItem('token');
      this.isLoggedIn = false;
      this.$message.success("退出登录成功");
    },
  }
}
</script>

<style>
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
</style> -->


<template>
    <el-container class="custom-container">
        <el-main>
            <div class="login-container">
                <h2>用户注册</h2>
                <div v-if="errorMessage" class="error-message">
                    {{ errorMessage }}
                </div>
                <form @submit.prevent="register" class="login-form">
                    <input type="text" v-model="email" placeholder="邮箱" required>
                    <input type="text" v-model="username" placeholder="用户名" required>
                    <div class="password-container">
                        <input :type="showPassword ? 'text' : 'password'" v-model="password" placeholder="密码"
                            required />
                    </div>
                    <button class="zhuce" type="submit">注册</button>
                </form>
            </div>
        </el-main>
    </el-container>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            email: '', // 用户名
            username: '', // 用户名
            password: '', // 密码
            errorMessage: '', // 错误信息
            successMessage: '', // 成功信息
            showPassword: false, // 控制密码是否明文显示
        };
    },
    methods: {
        async register() {
            try {
                const response = await this.$http.post('api/auth/userRegister', {
                    email: this.email,
                    name: this.username,
                    password: this.password,
                });
                // 处理返回结果
                if (response.code == 200) {
                    this.$notify({
                        title: '成功',
                        message: '注册成功！',
                        type: 'success'
                    });
                    // 注册成功后，跳转到指定的路由
                    this.$router.push({ path: '/login' });
                } else {
                    // 如果注册失败，显示错误信息
                    this.errorMessage = response.message || '注册失败，请重试。';
                }
            } catch (error) {
                // 捕获网络错误或其他异常
                this.errorMessage = '网络错误，请稍后重试。';
            }
        },
        togglePassword() {
            this.showPassword = !this.showPassword;
        },
    },
};
</script>

<style scoped>
/* 样式保持不变 */
body {
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    /* height: 100vh; */
    margin: 0;
    background-color: #f0f0f0;
}

.el-main {
    display: flex;
    justify-content: center;
    align-items: center;
    /* height: 100vh; */
}

.login-container {
    background-color: rgba(255, 255, 255, 0.8);
    /* 半透明白色背景 */
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    /* 调整表单的最大宽度 */
    width: 100%;
    /* 确保容器宽度根据屏幕自适应 */
    height: 300px;
    margin: auto;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    /* 增强阴影效果 */
    border: 1px solid #ccc;
    /* 添加边框 */
}

.custom-container {
    height: 700px;
    border: 1px solid #eee;
    background-image: url('../assets/register.jpg');
    background-size: cover;
    /* 根据需要调整背景图片的缩放方式 */
    background-position: center;
    /* 背景居中 */

}

h2 {
    text-align: center;
    color: #333;
}

form {
    display: flex;
    flex-direction: column;
    align-items: center;
    /* 让输入框和按钮居中 */
}

.password-container {
    display: flex;
    align-items: center;
    position: relative;
    width: 100%;
    max-width: 300px;
    border-radius: 4px;
}

input {
    width: 100%;
    max-width: 300px;
    margin: 10px 0;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    box-sizing: border-box;
    transition: box-shadow 0.3s ease;
}

input:focus {
    box-shadow: 0 0 8px rgba(74, 144, 226, 0.5);
    border-color: #4A90E2;
}

.toggle-password {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #007bff;
    cursor: pointer;
    width: auto;
    /* 让按钮宽度自适应文字 */
    padding: 0;
    /* 去掉内边距，避免撑开 */
    font-size: 14px;
    /* 控制文字大小 */
}

button {
    background: linear-gradient(90deg, #4A90E2, #9013FE);
    /* 渐变色按钮 */
    color: white;
    padding: 10px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    box-shadow: 0 8px 10px rgba(0, 0, 0, 0.2);
}

button:hover {
    background: linear-gradient(90deg, #357ABD, #7316E5);
    /* 鼠标悬浮时颜色变化 */
}

.error-message {
    color: red;
    text-align: center;
}

.zhuce {
    width: 120px;
    margin-top: 30px;
}
</style>
