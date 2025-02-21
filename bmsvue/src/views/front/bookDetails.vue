<template>
    <div class="book-detail">
        <el-row :gutter="20">
            <!-- 左侧：图书封面 -->
            <el-col :span="8">
                <el-card class="book-cover">
                    <img :src="book.cover" alt="图书封面" class="cover-image" />
                </el-card>
            </el-col>

            <!-- 右侧：图书信息 -->
            <el-col :span="16">
                <el-card class="book-info">
                    <!-- 标题和操作按钮 -->
                    <div class="header-wrapper">
                        <h1 class="book-title">{{ book.title }}</h1>
                        <el-descriptions-item label="借阅状态">
                            <el-tag :type="book.isBorrowed ? 'danger' : 'success'">
                                {{ book.isBorrowed ? '已借出' : '可借阅' }}
                            </el-tag>
                        </el-descriptions-item>
                        <!-- 可添加还书功能 -->
                        <el-button v-if="book.isBorrowed" type="danger" @click="handleReturn">
                            归还图书
                        </el-button>
                        <el-button type="primary" :disabled="book.isBorrowed || loading" @click="handleBorrow">
                            {{ book.isBorrowed ? '已借阅' : '立即借阅' }}
                            <i v-if="loading" class="el-icon-loading"></i>
                        </el-button>
                    </div>
                    <el-divider></el-divider>

                    <!-- 基本信息 -->
                    <el-descriptions title="图书信息" :column="1" border>
                        <el-descriptions-item label="作者">{{ book.author }}</el-descriptions-item>
                        <el-descriptions-item label="出版社">{{ book.publisher }}</el-descriptions-item>
                        <el-descriptions-item label="出版日期">{{ book.publishDate }}</el-descriptions-item>
                        <el-descriptions-item label="ISBN">{{ book.isbn }}</el-descriptions-item>
                        <el-descriptions-item label="页数">{{ book.pages }} 页</el-descriptions-item>
                        <el-descriptions-item label="价格">{{ book.price }} 元</el-descriptions-item>
                    </el-descriptions>

                    <!-- 图书描述 -->
                    <el-divider></el-divider>
                    <h3>图书简介</h3>
                    <p class="book-description">{{ book.description }}</p>
                </el-card>
            </el-col>
        </el-row>
    </div>
</template>

<script>
export default {
    name: 'BookDetail',
    data() {
        return {
            loading: false,
            book: {
                // 新增借阅状态字段
                isBorrowed: false,
                title: 'Vue.js 实战',
                author: '张三',
                publisher: '人民邮电出版社',
                publishDate: '2023-01-01',
                isbn: '9787115588888',
                pages: 300,
                price: 59.8,
                cover: require('@/assets/book-cover.jpg'), // 封面图片
                description: '本书是一本全面介绍 Vue.js 的实战指南，适合初学者和进阶开发者。书中详细讲解了 Vue.js 的核心概念、组件化开发、状态管理、路由等内容，并通过丰富的案例帮助读者掌握 Vue.js 的开发技巧。'
            }
        };
    },
    created() {
        // 模拟从后端获取图书信息
        this.fetchBookDetails();
    },
    methods: {
        handleBorrow() {
            this.$confirm('确定要借阅这本书吗？', '借阅确认', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                this.submitBorrowRequest()
            }).catch(() => { })
        },
       
        submitBorrowRequest() {
            this.$http.post('/api/userBook/borrowBook',{
                book_id:this.$route.query.book_id
            })
               .then(response => {
                    // 更新成功后，重新加载数据
                    this.$message.success('借阅成功');
                    this.book.isBorrowed = true
                }).catch(error => {
                    this.$message.error('借阅失败');
                });
        },
        handleReturn() {
            this.$confirm('确定要归还这本书吗？', '归还确认', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                this.submitReturnRequest()
            }).catch(() => { })
        },
        submitReturnRequest() {
           this.$http.post('/api/userBook/returnBook',{
                book_id:this.$route.query.book_id
            })
              .then(response => {
                    // 更新成功后，重新加载数据
                    this.$message.success('归还成功');
                    this.book.isBorrowed = false
                }).catch(error => {
                    this.$message.error('归还失败');
                });
        },
        fetchBookDetails() {
            // 模拟从后端获取图书信息
            // 这里可以调用后端接口获取图书详细信息
            this.$http.get('/api/userBook/fetchBookDetails',{
                params:{
                    book_id:this.$route.query.book_id
                }
            })
                .then(response => {
                    this.book = response.results;
                })
                .catch(error => {
                    console.error('获取图书详情失败:', error)
                })
        }
    }

};
</script>

<style scoped>
.book-detail {
    padding: 70px;
}

.book-cover {
    text-align: center;
}

.cover-image {
    max-width: 100%;
    height: auto;
    border-radius: 4px;
}

.book-title {
    font-size: 24px;
    margin-bottom: 20px;
}

.book-description {
    font-size: 14px;
    line-height: 1.6;
    color: #666;
}
</style>