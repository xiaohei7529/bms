<template>
    <div>
        
        <h3>待归还图书</h3>
        <el-card class="book-list">
            <el-table :data="borrowedBooks" stripe v-loading="loading">
                <el-table-column prop="cover_image" label="书籍封面">
                    <template slot-scope="scope">
                        <img src="scope.row.cover_image" alt="" width="60px" height="90px">
                    </template>
                </el-table-column>
                <el-table-column prop="book_name" label="书名"></el-table-column>
                <el-table-column prop="book_author" label="作者"></el-table-column>
                <el-table-column prop="user_name" label="借阅人"></el-table-column>
                <el-table-column prop="borrow_date" label="借阅日期"></el-table-column>
                <el-table-column prop="return_date" label="归还日期"></el-table-column>
                <el-table-column label="审批状态" width="120">
                    <template slot-scope="scope">
                        <el-tag :type="scope.row.audit_atatus == 1 ? 'success' : (scope.row.audit_atatus == 0 ? 'warning' : 'danger')">
                            {{ scope.row.audit_atatus == 0 ? '未审批' : (scope.row.audit_atatus == 1 ? '已审批' : '拒绝') }}
                        </el-tag>
                    </template>
                </el-table-column>
                <el-table-column label="操作" width="220">
                    <template slot-scope="scope">
                        <el-button v-if="scope.row.audit_atatus === 0 " type="primary" size="mini" @click="handleReturn(scope.row,1)">
                            同意借阅
                        </el-button>
                        <el-button v-if="scope.row.audit_atatus === 0 " type="danger" size="mini" @click="handleReturn(scope.row,2)">
                            拒绝借阅
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
            loading: false,
            showEditDialog: false,
            currentPage: 1,
            pageSize: 10,
            total_records: 0,
            borrowedBooks: []
        };
    },
    computed: {
        
    },
    created() {
        this.loadData();
    },
    methods: {
        // 同意借阅
        handleReturn(book,status) {

            this.$http.post('api/manageBook/bookAudit',
                {
                    bookid:book.id,
                    status:status
                }
            )
                .then((response) => {
                    console.log(response)
                    this.borrowedBooks = response.results
                })
                .catch((error) => {
                    console.error('Login failed:', error);
                });

            book.audit_atatus = '1';
            this.$message.success('同意借阅成功');

        },
        handleSizeChange(val) {
            this.pageSize = val;
            this.currentPage = 1;
            this.loadData();
        },
        handleCurrentChange(val) {
            this.currentPage = val;
            this.loadData();
        },
        loadData() {
            // 模拟登录成功
            this.loading = true;
            this.$http.get('api/manageBook/getBookAuditList',{
                params: {
                    page_size:this.pageSize,
                    page_no:this.currentPage
                }
            })
                .then((response) => {
                    console.log(response);
                    this.borrowedBooks = response.results;
                    this.loading = false;
                })
                .catch((error) => {
                    console.error('Login failed:', error);
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