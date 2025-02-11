<template>
    <div>
        <el-card class="book-list">
            <h3>已借阅图书</h3>
            <el-table :data="borrowedBooks" stripe>
                <el-table-column prop="title" label="书名"></el-table-column>
                <el-table-column prop="author" label="作者"></el-table-column>
                <el-table-column prop="borrowDate" label="借阅日期"></el-table-column>
                <el-table-column prop="returnDate" label="应还日期"></el-table-column>
                <el-table-column label="状态" width="120">
                    <template slot-scope="scope">
                        <el-tag :type="scope.row.status === '已归还' ? 'success' : 'warning'">
                            {{ scope.row.status }}
                        </el-tag>
                    </template>
                </el-table-column>
            </el-table>
            <el-pagination class="pagination" @size-change="handleSizeChange" @current-change="handleCurrentChange"
                :current-page="currentPage" :page-sizes="[10, 20, 50]" :page-size="pageSize"
                layout="total, sizes, prev, pager, next, jumper" :total="borrowedBooks.length"></el-pagination>
        </el-card>
    </div>
</template>

<script>
export default {
    data() {
        return {
            currentPage: 1,
            pageSize: 10,
            activeMenu: 'bookProfile', // 当前选中的菜单项
            showEditDialog: false,
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

    },
    methods: {
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