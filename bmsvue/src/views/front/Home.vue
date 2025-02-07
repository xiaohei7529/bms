<template>
    <div>
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
          <div class="module-header">
            <!-- 左侧标题 -->
            <div class="title-group">
              <span
                :class="['title', activeTab === 'borrow' ? 'active' : '']"
                @click="switchTab('borrow')"
              >
                热门借阅
              </span>
              <span
                :class="['title', activeTab === 'collect' ? 'active' : '']"
                @click="switchTab('collect')"
              >
                热门收藏
              </span>
              <span
                :class="['title', activeTab === 'score' ? 'active' : '']"
                @click="switchTab('score')"
              >
                高分图书
              </span>
            </div>
  
            <!-- 右侧查看更多 -->
            <span class="more" @click="handleMore">查看更多</span>
          </div>
  
          <!-- 图书列表 -->
          <el-row :gutter="20">
            <el-col :span="6" v-for="(book, index) in currentBooks" :key="index">
              <el-card :body-style="{ padding: '0px' }">
                <img :src="book.image" class="image" />
                <div style="padding: 14px;">
                  <span>{{ book.title }}</span>
                  <div class="bottom clearfix">
                    <el-button type="text" class="button" @click="bookDetails(book.id)">查看详情</el-button>
                  </div>
                </div>
              </el-card>
            </el-col>
          </el-row>
        </el-card>
  
        <!-- 新书推荐模块 -->
        <el-card class="new-books">
          <div class="module-header">
            <!-- 左侧标题 -->
            <span class="title">新书推荐</span>
  
            <!-- 右侧查看更多 -->
            <span class="more" @click="handleMoreNewBooks">查看更多</span>
          </div>
  
          <!-- 图书列表 -->
          <el-row :gutter="20">
            <el-col :span="6" v-for="(book, index) in newBooks" :key="index">
              <el-card :body-style="{ padding: '0px' }">
                <img :src="book.image" class="image" />
                <div style="padding: 14px;">
                  <span>{{ book.title }}</span>
                  <div class="bottom clearfix">
                    <el-button type="text" class="button" @click="bookDetails(book.id)">查看详情</el-button>
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
      activeTab: "borrow", // 当前选中的标签
      hotBooks: [
        // 热门借阅书籍数据
        { title: "书籍1", image: "https://via.placeholder.com/150" },
        { title: "书籍2", image: "https://via.placeholder.com/150" },
        { title: "书籍3", image: "https://via.placeholder.com/150" },
        { title: "书籍4", image: "https://via.placeholder.com/150" },
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
    };
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
    bookDetails(id) {
      id = 123
      this.$router.push({ name: 'bookDetails', params: { id: id }});
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
  },
};
</script>
  
<style>
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
    background-image: url("https://static12.libsp.cn/static/img/new3.0bg.fc712c1.png");
    /* 替换为你的背景图 */
    background-size: cover;
    background-position: center;
    z-index: 1;
}

/* 透明阴影区域 */
.search-shadow {
    width: 1140px;
    height: 126px;
    background: rgba(0, 0, 0, .25);
    /* 透明阴影 */
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

/* 热门借阅模块样式 */
.hot-borrow {
    margin-top: 20px;
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
    color: #409eff;
    /* 选中时的颜色 */
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
</style>