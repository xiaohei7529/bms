<template>
    <div class="book-list-container">
        <!-- 搜索栏 -->
        <el-card class="search-box">
            <el-row :gutter="20">
                <el-col :span="8">
                    <el-input v-model="searchKey" placeholder="请输入书名/作者" clearable @keyup.enter.native="handleSearch">
                        <el-button slot="append" icon="el-icon-search" @click="handleSearch"></el-button>
                    </el-input>
                </el-col>
                <el-col :span="6">
                    <el-select v-model="filterCategory" placeholder="全部分类" clearable>
                        <el-option v-for="item in categories" :key="item.value" :label="item.label"
                            :value="item.value"></el-option>
                    </el-select>
                </el-col>
            </el-row>
        </el-card>

        <!-- 结果列表 -->
        <el-table :data="paginatedData" stripe style="width: 100%" v-loading="loading">
            <el-table-column prop="cover" label="封面" width="120">
                <template slot-scope="scope">
                    <el-image :src="scope.row.cover" fit="contain" style="width: 80px; height: 100px">
                        <div slot="error" class="image-slot">
                            <i class="el-icon-picture-outline"></i>
                        </div>
                    </el-image>
                </template>
            </el-table-column>
            <el-table-column prop="title" label="书名" width="250"></el-table-column>
            <el-table-column prop="author" label="作者"></el-table-column>
            <el-table-column prop="category" label="分类">
                <template slot-scope="scope">
                    <el-tag>{{ scope.row.category }}</el-tag>
                </template>
            </el-table-column>
            <el-table-column prop="publishDate" label="出版日期" width="120"></el-table-column>
            <el-table-column prop="price" label="价格" width="100">
                <template slot-scope="scope">
                    ￥{{ scope.row.price }}
                </template>
            </el-table-column>
            <el-table-column prop="status" label="状态" width="100">
                <template slot-scope="scope">
                    <el-tag :type="statusType[scope.row.status]">
                        {{ scope.row.status }}
                    </el-tag>
                </template>
            </el-table-column>
            <el-table-column label="操作" width="180">
                <template slot-scope="scope">
                    <el-button type="warning" icon="el-icon-star-off" size="mini"
                        @click="handleCollect(row)"></el-button>
                    <el-button type="primary" size="mini" @click="handleDetail(scope.row)">详情</el-button>

                </template>
            </el-table-column>
        </el-table>

        <!-- 分页 -->
        <el-pagination class="pagination" @size-change="handleSizeChange" @current-change="handleCurrentChange"
            :current-page="currentPage" :page-sizes="[10, 20, 50]" :page-size="pageSize"
            layout="total, sizes, prev, pager, next, jumper" :total="filteredData.length"></el-pagination>
    </div>
</template>

<script>
export default {
    data() {
        return {
            searchKey: '',
            filterCategory: '',
            currentPage: 1,
            pageSize: 10,
            loading: false,
            categories: [
                { value: 'technology', label: '科学技术' },
                { value: 'literature', label: '文学艺术' },
                { value: 'history', label: '历史地理' }
            ],
            statusType: {
                '可借阅': 'success',
                '已借出': 'danger',
                '预约中': 'warning'
            },
            bookList: [
                // 示例数据
                {
                    id: 1,
                    title: 'Vue.js 实战',
                    author: '张三',
                    category: 'technology',
                    publishDate: '2023-01-01',
                    price: 59.8,
                    status: '可借阅',
                    cover: 'https://dummyimage.com/80x100/eee/999'
                },
                // 可添加更多测试数据...
            ]
        }
    },
    computed: {
        filteredData() {
            return this.bookList.filter(item => {
                const matchSearch = item.title.includes(this.searchKey) ||
                    item.author.includes(this.searchKey)
                const matchCategory = this.filterCategory ?
                    item.category === this.filterCategory : true
                return matchSearch && matchCategory
            })
        },
        paginatedData() {
            const start = (this.currentPage - 1) * this.pageSize
            const end = start + this.pageSize
            return this.filteredData.slice(start, end)
        }
    },
    methods: {
        handleSearch() {
            this.currentPage = 1
        },
        handleSizeChange(val) {
            this.pageSize = val
            this.currentPage = 1
        },
        handleCurrentChange(val) {
            this.currentPage = val
        },
        handleDetail(row) {
            this.$router.push(`/bookDetails/${row.id}`)
        }
    }
}
</script>

<style scoped>
.book-list-container {
    padding: 70px;
}

.search-box {
    margin-bottom: 20px;
}

.pagination {
    margin-top: 20px;
    text-align: right;
}

.image-slot {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
    background: #f5f7fa;
    color: #909399;
}
</style>