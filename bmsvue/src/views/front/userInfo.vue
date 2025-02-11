<template>
  <el-container class="user-profile-container">
    <!-- 左侧菜单栏 -->
    <el-aside width="200px">
      <el-menu
        default-active="profile"
        class="side-menu"
        @select="handleMenuSelect"
      >
        <el-menu-item index="bookProfile">
          <i class="el-icon-user"></i>
          <span>个人中心</span>
        </el-menu-item>
        <el-menu-item index="bookFavorite">
          <i class="el-icon-star-on"></i>
          <span>收藏图书</span>
        </el-menu-item>
        <el-menu-item index="bookBorrowed">
          <i class="el-icon-notebook-2"></i>
          <span>已借阅图书</span>
        </el-menu-item>
        <el-menu-item index="bookPending">
          <i class="el-icon-alarm-clock"></i>
          <span>待归还图书</span>
        </el-menu-item>
      </el-menu>
    </el-aside>

    <!-- 右侧内容 -->
    <el-main>
      <!-- 个人中心 -->
      <div v-if="activeMenu === 'bookProfile'">
        <el-card class="user-info">
          <el-row :gutter="20">
            <el-col :span="4">
              <el-avatar :size="100" :src="user.avatar"></el-avatar>
            </el-col>
            <el-col :span="20">
              <h2>{{ user.name }}</h2>
              <el-descriptions :column="2" border>
                <el-descriptions-item label="用户名">{{ user.username }}</el-descriptions-item>
                <el-descriptions-item label="邮箱">{{ user.email }}</el-descriptions-item>
                <el-descriptions-item label="手机号">{{ user.phone }}</el-descriptions-item>
                <el-descriptions-item label="注册时间">{{ user.registerDate }}</el-descriptions-item>
              </el-descriptions>
              <el-button 
                type="primary" 
                icon="el-icon-edit" 
                class="edit-btn"
                @click="showEditDialog = true"
              >
                编辑信息
              </el-button>
            </el-col>
          </el-row>
        </el-card>
        <router-view></router-view>
      </div>

      <!-- 收藏图书 -->
      <div v-if="activeMenu === 'bookFavorite'">
        <router-view></router-view>
      </div>

      <!-- 已借阅图书 -->
      <div v-if="activeMenu === 'bookBorrowed'">
        <router-view></router-view>
      </div>

      <!-- 待归还图书 -->
      <div v-if="activeMenu === 'bookPending'">
        <router-view></router-view>
      </div>
    </el-main>

    <!-- 编辑信息对话框 -->
    <el-dialog 
      title="编辑个人信息" 
      :visible.sync="showEditDialog" 
      width="30%"
    >
      <el-form :model="user" label-width="80px">
        <el-form-item label="用户名">
          <el-input v-model="user.username"></el-input>
        </el-form-item>
        <el-form-item label="邮箱">
          <el-input v-model="user.email"></el-input>
        </el-form-item>
        <el-form-item label="手机号">
          <el-input v-model="user.phone"></el-input>
        </el-form-item>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button @click="showEditDialog = false">取消</el-button>
        <el-button type="primary" @click="saveUserInfo">保存</el-button>
      </span>
    </el-dialog>
  </el-container>
</template>

<script>
export default {
  data() {
    return {
      activeMenu: 'bookProfile', // 当前选中的菜单项
      showEditDialog: false,
      user: {
        name: '张三',
        username: 'zhangsan',
        email: 'zhangsan@example.com',
        phone: '13800138000',
        registerDate: '2023-01-01',
        avatar: 'https://dummyimage.com/100x100/409EFF/fff' // 头像图片
      },
    };
  },
  computed: {

  },
  methods: {
    // 菜单项选择
    handleMenuSelect(index) {
        if(index == 'bookProfile'){
            this.activeMenu = index;
            this.$router.push(`/userInfo`);
        }else{
            this.$router.push(`/${index}`);
        }
    },
    // 保存用户信息
    saveUserInfo() {
      this.showEditDialog = false;
      this.$message.success('信息保存成功');
    }
  }
};
</script>

<style scoped>
.user-profile-container {
  height: 100vh;
  padding: 70px;
}

.el-main {
  margin-top: 0; /* 调整顶部间距，避免内容被头部遮挡 */
}

.side-menu {
  height: 100%;
}

.user-info {
  margin-bottom: 20px;
}

.edit-btn {
  margin-top: 20px;
}

.book-list {
  margin-bottom: 20px;
}

.book-list h3 {
  margin-bottom: 20px;
}
</style>