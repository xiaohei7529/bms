<template>
  <div>
    <el-card class="book-list">
      <h3>收藏图书</h3>
      <el-table :data="favoriteBooks" stripe>
        <el-table-column prop="title" label="书名"></el-table-column>
        <el-table-column prop="author" label="作者"></el-table-column>
        <el-table-column prop="category" label="分类"></el-table-column>
        <el-table-column label="操作" width="120">
          <template slot-scope="scope">
            <el-button type="danger" size="mini" @click="removeFavorite(scope.row)">
              取消收藏
            </el-button>
          </template>
        </el-table-column>
      </el-table>
      <el-pagination class="pagination" @size-change="handleSizeChange" @current-change="handleCurrentChange"
        :current-page="currentPage" :page-sizes="[10, 20, 50]" :page-size="pageSize"
        layout="total, sizes, prev, pager, next, jumper" :total="favoriteBooks.length"></el-pagination>
    </el-card>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showEditDialog: false,
      currentPage: 1,
      pageSize: 10,
      favoriteBooks: [
        {
          id: 1,
          title: 'Vue.js 实战',
          author: '李四',
          category: '前端开发'
        },
        {
          id: 2,
          title: 'JavaScript 高级程序设计',
          author: '王五',
          category: '前端开发'
        }
      ]
    };
  },
  computed: {

  },
  methods: {
    // 取消收藏
    removeFavorite(book) {
      this.favoriteBooks = this.favoriteBooks.filter(item => item.id !== book.id);
      this.$message.success('已取消收藏');
    },
    handleSizeChange(val) {
      this.pageSize = val
      this.currentPage = 1
    },
    handleCurrentChange(val) {
      this.currentPage = val
    },
  }
};
</script>

<style scoped>
.user-profile-container {
  height: 100vh;
  padding: 70px;
}

.el-main {
  margin-top: 0;
  /* 调整顶部间距，避免内容被头部遮挡 */
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