<template>
    <div>
        <el-card class="book-list">
            <h3>待归还图书</h3>
            <el-table :data="pendingReturnBooks" stripe>
                <el-table-column prop="title" label="书名"></el-table-column>
                <el-table-column prop="author" label="作者"></el-table-column>
                <el-table-column prop="borrowDate" label="借阅日期"></el-table-column>
                <el-table-column prop="returnDate" label="应还日期"></el-table-column>
                <el-table-column label="操作" width="120">
                    <template slot-scope="scope">
                        <el-button type="primary" size="mini" @click="handleReturn(scope.row)">
                            归还
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
            total_records:0,
            pendingReturnBooks: []
        };
    },
    computed: {
        
    },
    created() {
        this.loadData();
    },
    methods: {
        // 归还图书
        handleReturn(book) {
            // 更新图书状态
            book.status = '已归还';

            // 发送请求更新图书状态
            this.$http.post('api/userBook/returnBook', {
                bookId: book.id
            })
            .then(response => {
                // 更新成功后，重新加载数据
                this.$message.success('归还成功');
                // this.loadData();
            }).catch(error => {
                this.$message.error('归还失败');
            });

        },
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
            this.$http.get('api/userBook/getPendingReturnBooksList',{
                params: {
                    page_size:this.pageSize,
                    page:this.currentPage
                }
            }).then(response => {
                this.total_records = response.paging.total_records;
                this.pendingReturnBooks = response.results;
                this.loading = false;
            }).catch(error => {
                this.$message.error('获取借阅记录失败');
                this.loading = false;
            });
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