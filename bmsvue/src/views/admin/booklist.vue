<template>
    <div>
        <el-breadcrumb separator-class="el-icon-arrow-right">
            <el-breadcrumb-item :to="{ path: '/admin' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item>图书管理</el-breadcrumb-item>
            <el-breadcrumb-item>图书列表</el-breadcrumb-item>
        </el-breadcrumb>

        <el-divider></el-divider>

        <!-- 搜索栏 -->
        <el-form :inline="true" :model="formInline" class="demo-form-inline">

            <el-form-item label="图书名称">
                <el-input v-model="formInline.name"></el-input>
            </el-form-item>

            <el-form-item>
                <el-button type="primary" @click="loadData">查询</el-button>
                <el-button type="primary" @click="dialogVisible = true">图书添加</el-button>
            </el-form-item>
        </el-form>
        <el-card class="book-list">
            <el-table :data="booksList" stripe v-loading="loading">
                <el-table-column prop="cover_image" label="书籍封面">
                    <template slot-scope="scope">
                        <img src="scope.row.cover_image" alt="" width="60px" height="90px">
                    </template>
                </el-table-column>
                <el-table-column prop="title" label="书名"></el-table-column>
                <el-table-column prop="author" label="作者"></el-table-column>
                <el-table-column prop="category_name" label="分类"></el-table-column>
                <el-table-column prop="isbn" label="国际标准书号"></el-table-column>
                <el-table-column prop="description" label="书籍简介"></el-table-column>
                <el-table-column prop="create_time" label="创建时间"></el-table-column>
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
                layout="total, sizes, prev, pager, next, jumper" :total="total_records"></el-pagination>
        </el-card>


        <!-- 添加图书 Dialog -->
        <el-dialog title="添加图书" :visible.sync="dialogVisible" width="30%" :before-close="handleClose">
            <!-- 表单 -->
            <el-form :model="bookForm" label-width="100px" :rules="rules" ref="bookForm">
                <!-- 封面 -->
                <el-form-item label="封面" prop="cover">
                    <el-upload action="" :on-success="handleCoverSuccess" :before-upload="beforeCoverUpload" :limit="1"
                        :on-exceed="handleCoverExceed" :http-request="onFileChange" :file-list="fileList" list-type="picture">
                        <el-button type="primary">点击上传</el-button>
                        <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过500kb</div>
                    </el-upload>
                </el-form-item>

                <!-- 书名 -->
                <el-form-item label="书名" prop="title">
                    <el-input v-model="bookForm.title" placeholder="请输入书名"></el-input>
                </el-form-item>

                <!-- 作者 -->
                <el-form-item label="作者" prop="author">
                    <el-input v-model="bookForm.author" placeholder="请输入作者"></el-input>
                </el-form-item>

                <!-- 分类 ID -->
                <el-form-item label="分类 ID" prop="categoryId">
                    <el-select v-model="bookForm.categoryId" style="width: 230px;" placeholder="请选择" filterable>
                        <el-option v-for="item in bookCategory" :key="item.id" :label="item.name" :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>

                <!-- 国际标准书号 -->
                <el-form-item label="ISBN" prop="isbn">
                    <el-input v-model="bookForm.isbn" placeholder="请输入国际标准书号"></el-input>
                </el-form-item>

                <!-- 库存数量 -->
                <el-form-item label="库存数量" prop="stock">
                    <el-input-number v-model="bookForm.stock" :min="0" label="库存数量"></el-input-number>
                </el-form-item>

                <!-- 书籍简介 -->
                <el-form-item label="书籍简介" prop="description">
                    <el-input type="textarea" v-model="bookForm.description" placeholder="请输入书籍简介" :rows="4"></el-input>
                </el-form-item>
            </el-form>

            <!-- 底部按钮 -->
            <span slot="footer" class="dialog-footer">
                <el-button @click="dialogVisible = false">取消</el-button>
                <el-button type="primary" @click="submitForm">确定</el-button>
            </span>
        </el-dialog>
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
            booksList: [],
            formInline: {
                name: ''
            },
            dialogVisible: false, // 控制 Dialog 显示
            bookCategory: [],
            bookForm: {
                cover: "", // 封面
                title: "", // 书名
                author: "", // 作者
                categoryId: "", // 分类 ID
                isbn: "", // 国际标准书号
                stock: 0, // 库存数量
                description: "", // 书籍简介
            },
            // 表单验证规则
            rules: {
                title: [{ required: true, message: "请输入书名", trigger: "blur" }],
                author: [{ required: true, message: "请输入作者", trigger: "blur" }],
                categoryId: [{ required: true, message: "请输入分类 ID", trigger: "change" }],
                isbn: [{ required: true, message: "请输入国际标准书号", trigger: "blur" }],
                stock: [{ required: true, message: "请输入库存数量", trigger: "blur" }],
                description: [{ required: true, message: "请输入书籍简介", trigger: "blur" }],
            },
            selectedFiles:[],
            fileList:[],
        };
    },
    computed: {

    },

    created() {
        this.loadData();
    },
    watch: {
        // 使用 watch 监听 字段
        'dialogVisible'(newVal, oldVal) {
            if (newVal == false) return false;
            this.$http.get('api/manageBook/getBookCategoryList',)
                .then((response) => {
                    console.log(response)
                    this.bookCategory = response.results;
                })
                .catch((error) => {
                    console.error('Login failed:', error);
                });
        }
    },
    methods: {
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
            // 
            this.loading = true;
            this.$http.get('api/manageBook/bookList', {
                params: {
                    page_size: this.pageSize,
                    page_no: this.currentPage
                }
            })
                .then((response) => {
                    console.log(response)
                    this.total_records = response.paging.total_records;
                    this.booksList = response.results;
                    this.loading = false;
                })
                .catch((error) => {
                    console.error('Login failed:', error);
                });
        },
        // 关闭 Dialog 前的回调
        handleClose(done) {
            this.$confirm("确认关闭？")
                .then(() => {
                    this.resetForm(); // 重置表单
                    done();
                })
                .catch(() => { });
        },
        // 提交表单
        submitForm() {
            this.$refs.bookForm.validate((valid) => {
                if (valid) {
                    // 表单验证通过，提交数据
                    console.log("提交的图书数据：", this.bookForm);
                    this.bookstore();
                } else {
                    this.$message.error("请填写完整信息！");
                    return false;
                }
            });
        },
        bookstore() {
            this.$http.post('api/manageBook/bookStore', this.bookForm)
                .then((response) => {
                    console.log(response);
                    this.loadData();

                    this.$message.success("添加成功！");
                    this.dialogVisible = false;
                    this.resetForm(); // 重置表单
                })
                .catch((error) => {
                    console.error('Login failed:', error);
                });
        },
        // 重置表单
        resetForm() {
            this.$refs.bookForm.resetFields();
        },
        // 封面上传成功
        handleCoverSuccess(response, file) {
            this.bookForm.cover = URL.createObjectURL(file.raw);
            this.$message.success("封面上传成功！");
        },
        // 封面上传前的校验
        beforeCoverUpload(file) {
            const isImage = file.type.startsWith("image/");
            const isLt500KB = file.size / 1024 < 500;

            if (!isImage) {
                this.$message.error("只能上传图片文件！");
            }
            if (!isLt500KB) {
                this.$message.error("图片大小不能超过 500KB！");
            }
            return isImage && isLt500KB;
        },
        // 封面上传超出限制
        handleCoverExceed() {
            this.$message.warning("只能上传一张封面图片！");
        },


        onFileChange(event) {
            console.log(event)
            // 当文件输入发生变化时，获取用户选择的文件列表
            if (!event.target) {
                const file = event.file,
                fileType = file.type,

                isImage = fileType.indexOf('image') !== -1,
                isLt100M = file.size / 1024 / 1024 < 100;

                if (!isImage) {
                    this.$message.error('只能上传图片格式png、jpg、gif!');
                    return;
                }
                if (!isLt100M) {
                    this.$message.error('只能上传图片大小小于10M');
                    return;
                }
                this.selectedFiles.push(event.file);
            } else {
                this.selectedFiles = event.target.files;
            }
            this.uploadFiles()
        },
        uploadFiles() {
            var that = this;
            // 检查是否有文件被选择
            if (this.selectedFiles.length === 0) {
                this.$message.error('请先选择一个或多个文件！');
                return;
            }

            // 创建FormData对象
            const formData = new FormData();

            // 遍历文件列表并添加到FormData对象中
            for (let i = 0; i < this.selectedFiles.length; i++) {
                formData.append('file', this.selectedFiles[i]);
            }

            // 发送文件到服务器
            // 假设你有一个名为uploadFiles的API端点，它接受一个名为files的数组
            this.$http.post('api/uploadFile', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(response => {
                // 处理上传成功后的响应
                console.log('文件上传成功:', response);
                //上传附件
                this.fileList.push(response.data.results);
                this.selectedFiles = [];
            }).catch(error => {
                // 处理上传失败的情况
                console.error('文件上传失败:', error);
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

.el-upload__tip {
    font-size: 12px;
    color: #606266;
}
</style>