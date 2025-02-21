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
                layout="total, sizes, prev, pager, next, jumper" :total="total_records"></el-pagination>
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
            total_records: 0,
            favoriteBooks: []
        };
    },
    computed: {

    },
    created() {
        this.loadData();
    },
    methods: {
        handleSizeChange(val) {
            this.pageSize = val
            this.currentPage = 1
            this.loadData();
        },
        handleCurrentChange(val) {
            this.currentPage = val
            this.loadData();
        },
        loadData() {
            this.loading = true;
            this.$http.get('/api/userBook/getfavoriteBookList')
                .then(response => {
                    this.total_records = response.paging.total_records;
                    this.favoriteBooks = response.results;
                    this.loading = false;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        
        // 取消收藏
        removeFavorite(book) {
            this.favoriteBooks = this.favoriteBooks.filter(item => item.id !== book.id);
            this.$http.post('/api/userBook/removeFavorite',
                {
                    book_id: book.id
                })
                .then(response => {
                    this.$message.success('已取消收藏');
                    this.loadData();
                })
                .catch(error => {
                    console.error(error);
                });
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