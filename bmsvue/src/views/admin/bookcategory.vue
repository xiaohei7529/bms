<template>
    <div>

        <h3>图书分类</h3>
        <el-card class="book-list">
            <el-table :data="BookCategoryList" stripe>
                <el-table-column prop="name" label="分类名称"></el-table-column>
                <el-table-column label="操作" width="120">
                    <template slot-scope="scope">
                        <el-button type="primary" size="mini" @click="handleReturn(scope.row)">
                            编辑
                        </el-button>
                    </template>
                </el-table-column>
            </el-table>
            <el-pagination class="pagination" @size-change="handleSizeChange" @current-change="handleCurrentChange"
                :current-page="currentPage" :page-sizes="[10, 20, 50]" :page-size="pageSize"
                layout="total, sizes, prev, pager, next, jumper" :total="BookCategoryList.length"></el-pagination>
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
            BookCategoryList: []
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
            // 模拟登录成功
            this.$http.get('api/manageBook/getBookCategoryList',)
                .then((response) => {
                    console.log(response)
                    this.BookCategoryList = response.results
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