<template>
    <div>
        <el-card class="book-list">
            <h3>已借阅图书</h3>
            <el-table :data="borrowedBooks" stripe>
                <el-table-column prop="title" label="书名"></el-table-column>
                <el-table-column prop="author" label="作者"></el-table-column>
                <el-table-column prop="borrow_date" label="借阅日期"></el-table-column>
                <el-table-column prop="return_date" label="归还日期"></el-table-column>
                <el-table-column label="状态" width="120">
                    <template slot-scope="scope">
                        <el-tag :type="scope.row.borrow_status === 1 ? 'success' : 'warning'">
                            {{ scope.row.borrow_status === 1 ? '已归还' : '未归还' }}
                        </el-tag>
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
            currentPage: 1,
            pageSize: 10,
            total_records: 0,
            activeMenu: 'bookProfile', // 当前选中的菜单项
            showEditDialog: false,
            borrowedBooks:[]
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
        },
        handleCurrentChange(val) {
            this.currentPage = val
        },
        loadData() {
            this.loading = true;
            this.$http.get('api/userBook/getBorrowedBooksList',{
                params: {
                    page_size:this.pageSize,
                    page_no:this.currentPage
                }
            }).then(response => {
                this.total_records = response.paging.total_records;
                this.borrowedBooks = response.results;
                this.loading = false;
            }).catch(error => {
                console.error('Login failed:', error);
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