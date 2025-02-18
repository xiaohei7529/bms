<template>
  <div class="employee-task-container">
    <!-- 搜索栏 -->
    <el-input
      v-model="searchKeyword"
      placeholder="搜索员工或任务"
      clearable
      class="search-input"
      @input="handleSearch"
    >
      <el-button slot="append" icon="el-icon-search"></el-button>
    </el-input>

    <!-- 员工任务卡片 -->
    <div class="card-container">
      <el-card
        v-for="employee in filteredEmployees"
        :key="employee.id"
        class="employee-card"
      >
        <!-- 卡片头部：员工名称 -->
        <div slot="header" class="card-header">
          <span>{{ employee.name }}</span>
        </div>

        <!-- 卡片内容：任务列表 -->
        <div v-for="task in employee.tasks" :key="task.id" class="task-card">
          <el-card shadow="hover"       @dblclick.native="cardclick(task)">
            <div class="task-info">
              <span class="task-name">项目：{{ task.project }}</span>
              <el-tag :type="statusType[task.status]" size="small">
                {{ task.status }}
              </el-tag>
            </div>
            <div class="task-details">
              <span>计划时间：{{ task.planDate }}</span>
            </div>
          </el-card>
        </div>
      </el-card>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      searchKeyword: '', // 搜索关键词
      employees: [], // 员工列表
      statusType: {
        '未开始': 'info',
        '进行中': 'primary',
        '已完成': 'success',
        '已取消': 'danger'
      }
    };
  },
  computed: {
    // 过滤后的员工列表
    filteredEmployees() {
      return this.employees.filter(employee => {
        const matchEmployee = employee.name.toLowerCase().includes(this.searchKeyword.toLowerCase());
        const matchTask = employee.tasks.some(task => 
          task.project.toLowerCase().includes(this.searchKeyword.toLowerCase())
        );
        return matchEmployee || matchTask;
      });
    }
  },
  created() {
    this.loadData();
  },
  methods: {
    // 加载数据
    loadData() {
      // 模拟异步加载数据
      this.employees = [
        {
          id: 1,
          name: '陈洁',
          tasks: [
            {
              id: 1,
              project: '医疗项目',
              planDate: '2025年2月13日 - 2025年2月15日',
              status: '未开始'
            },
            {
              id: 2,
              project: '儿童床垫项目',
              planDate: '2025年2月14日 - 2025年2月15日',
              status: '未开始'
            },
            {
              id: 3,
              project: '医疗项目',
              planDate: '2025年2月13日 - 2025年2月15日',
              status: '未开始'
            },
            {
              id: 4,
              project: '儿童床垫项目',
              planDate: '2025年2月14日 - 2025年2月15日',
              status: '未开始'
            },
            {
              id: 5,
              project: '医疗项目',
              planDate: '2025年2月13日 - 2025年2月15日',
              status: '未开始'
            },
            {
              id: 6,
              project: '儿童床垫项目',
              planDate: '2025年2月14日 - 2025年2月15日',
              status: '未开始'
            },
            {
              id: 7,
              project: '医疗项目',
              planDate: '2025年2月13日 - 2025年2月15日',
              status: '未开始'
            },
            {
              id: 8,
              project: '儿童床垫项目',
              planDate: '2025年2月14日 - 2025年2月15日',
              status: '未开始'
            },
            {
              id: 9,
              project: '医疗项目',
              planDate: '2025年2月13日 - 2025年2月15日',
              status: '未开始'
            },
            {
              id: 10,
              project: '儿童床垫项目',
              planDate: '2025年2月14日 - 2025年2月15日',
              status: '未开始'
            }
          ]
        },
        {
          id: 2,
          name: '孙志娟',
          tasks: [
            {
              id: 3,
              project: '儿童床垫项目',
              planDate: '2025年2月11日 - 2025年2月12日',
              status: '进行中'
            }
          ]
        },
        {
          id: 3,
          name: '关玮',
          tasks: [
            {
              id: 4,
              project: '智能家居项目',
              planDate: '2025年2月13日 - 2025年2月16日',
              status: '未开始'
            },
            {
              id: 5,
              project: '智能家居项目',
              planDate: '2025年2月14日 - 2025年2月16日',
              status: '未开始'
            }
          ]
        },
        {
          id: 4,
          name: '关玮',
          tasks: [
            {
              id: 4,
              project: '智能家居项目',
              planDate: '2025年2月13日 - 2025年2月16日',
              status: '未开始'
            },
            {
              id: 5,
              project: '智能家居项目',
              planDate: '2025年2月14日 - 2025年2月16日',
              status: '未开始'
            }
          ]
        },
        {
          id: 5,
          name: '关玮',
          tasks: [
            {
              id: 4,
              project: '智能家居项目',
              planDate: '2025年2月13日 - 2025年2月16日',
              status: '未开始'
            },
            {
              id: 5,
              project: '智能家居项目',
              planDate: '2025年2月14日 - 2025年2月16日',
              status: '未开始'
            }
          ]
        },
        {
          id: 6,
          name: '关玮',
          tasks: [
            {
              id: 4,
              project: '智能家居项目',
              planDate: '2025年2月13日 - 2025年2月16日',
              status: '未开始'
            },
            {
              id: 5,
              project: '智能家居项目',
              planDate: '2025年2月14日 - 2025年2月16日',
              status: '未开始'
            }
          ]
        },
        {
          id: 7,
          name: '关玮',
          tasks: [
            {
              id: 4,
              project: '智能家居项目',
              planDate: '2025年2月13日 - 2025年2月16日',
              status: '未开始'
            },
            {
              id: 5,
              project: '智能家居项目',
              planDate: '2025年2月14日 - 2025年2月16日',
              status: '未开始'
            }
          ]
        },
        {
          id: 8,
          name: '关玮',
          tasks: [
            {
              id: 4,
              project: '智能家居项目',
              planDate: '2025年2月13日 - 2025年2月16日',
              status: '未开始'
            },
            {
              id: 5,
              project: '智能家居项目',
              planDate: '2025年2月14日 - 2025年2月16日',
              status: '未开始'
            }
          ]
        }
      ];
    },
    // 搜索员工或任务
    handleSearch() {
      console.log('搜索关键词:', this.searchKeyword);
    },
    cardclick(){
      console.log('1111111111111111111111');
    }
  }
};
</script>

<style scoped>
.employee-task-container {
  padding: 20px;
}

.search-input {
  margin-bottom: 20px;
}

.card-container {
  display: flex;
  flex-wrap: nowrap;
  overflow-x: auto;
  gap: 20px;
}

.employee-card {
  min-width: 300px;
  max-width: 300px;
}

.card-header {
  font-size: 18px;
  font-weight: bold;
}

.task-card {
  margin-bottom: 10px;
}

.task-info {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}

.task-name {
  font-weight: bold;
}

.task-details {
  color: #666;
  font-size: 14px;
}
</style>