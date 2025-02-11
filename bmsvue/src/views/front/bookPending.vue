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
                layout="total, sizes, prev, pager, next, jumper" :total="pendingReturnBooks.length"></el-pagination>
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
            borrowedBooks: [
                {
                    id: 1,
                    title: 'Vue.js 实战',
                    author: '李四',
                    borrowDate: '2023-10-01',
                    returnDate: '2023-11-01',
                    status: '已归还'
                },
                {
                    id: 2,
                    title: 'JavaScript 高级程序设计',
                    author: '王五',
                    borrowDate: '2023-10-15',
                    returnDate: '2023-11-15',
                    status: '借阅中'
                }
            ]
        };
    },
    computed: {
        // 待归还图书
        pendingReturnBooks() {
            return this.borrowedBooks.filter(book => book.status === '借阅中');
        }
    },
    methods: {
        // 归还图书
        handleReturn(book) {
            book.status = '已归还';
            this.$message.success('归还成功');
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