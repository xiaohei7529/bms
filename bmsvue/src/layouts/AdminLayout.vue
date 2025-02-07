<template>
    <div class="admin-layout">
      <aside>后台侧边栏</aside>
      <main>
        <router-view></router-view>
      </main>
    </div>
  </template>
  
  <style scoped>
  .admin-layout {
    display: flex;
  }
  </style>