<template>
  <div class="drop-down">
    <p>sdfsfs</p>
  </div>
</template>

<style scoped>
  .drop-down {
    position: relative;
    background: #00aabb;
  }

  .drop-down:after {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    width: 0;
    height: 0;
    border: 27px solid transparent;
    border-bottom-color: #00aabb;
    border-top: 0;
    margin-left: -27px;
    margin-top: -27px;
  }
</style>
