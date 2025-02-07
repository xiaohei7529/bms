<template>
  <div id="app">
    <router-view />
  </div>
</template>

<script>
</script>

<style>
html,
body,
#app{
  margin: 0;
  padding: 0;
}

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  /* text-align: center; */
  color: #2c3e50;
}

.el-header {
  padding: 0;
  width: 100%;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 1000;
}

.el-main {
  margin-top: 60px; /* 调整顶部间距，避免内容被头部遮挡 */
}

.el-container {
    padding: 0;
    margin: 0;
    height: 100vh;
    width:100vw;
}

/*滚动条的宽度和高度*/
::-webkit-scrollbar {
    width: 5px;
    height: 10px;
}

::-webkit-scrollbar-track {
    width: 5px;
    background-color: rgba(238, 238, 238, 0.5);
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
} 
/*滚动条的设置*/
::-webkit-scrollbar-thumb {
    background-color: rgba(193, 193, 193, 0.75);
    background-clip: padding-box;
    min-height: 28px;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
} 
</style>
