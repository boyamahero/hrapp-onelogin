<template>
<div class="snowflakes row justify-center">
    <div class="col-xs-12 col-md-10 col-lg-8 justify-between">
    <i class="snow"></i><i class="snow"></i><i class="snow"></i><i class="snow"></i>
    <i class="snow"></i><i class="snow"></i><i class="snow"></i><i class="snow"></i>
    <i class="snow"></i><i class="snow"></i><i class="snow"></i><i class="snow"></i>
    <i class="snow"></i><i class="snow"></i><i class="snow"></i><i class="snow"></i>
    <i class="snow"></i><i class="snow"></i><i class="snow"></i><i class="snow"></i>
    <i class="snow"></i><i class="snow"></i><i class="snow"></i><i class="snow"></i>
    <i class="snow"></i><i class="snow"></i><i class="snow"></i><i class="snow"></i>
    <i class="snow"></i><i class="snow"></i><i class="snow"></i><i class="snow"></i>
    <i class="snow"></i><i class="snow"></i><i class="snow"></i><i class="snow"></i>
    <i class="snow"></i><i class="snow"></i><i class="snow"></i><i class="snow"></i>
    <i class="snow"></i><i class="snow"></i><i class="snow"></i><i class="snow"></i>
    <i class="snow"></i><i class="snow"></i><i class="snow"></i><i class="snow"></i>
    <i class="snow"></i><i class="snow"></i><i class="snow"></i><i class="snow"></i>
    </div>
</div>
</template>
<style>
.snowflakes {
  width: 100%; height: 100%;
  position: fixed; top: -90px; left: 0;
}

i.snow, i.snow:after, i.snow:before { background: white; }
i.snow {
  display: inline-block;
  -webkit-animation: snowflakes 10s linear 2s 20;
  -moz-animation: snowflakes 10s linear 2s 20;
  position: relative;
}
i.snow:after, i.snow:before {
  height: 100%;
  width: 100%;
  content: ".";
  position: absolute;
  top: 0px;
  left: 0px;
  -webkit-transform: rotate(120deg);
}
i.snow:before { -webkit-transform: rotate(240deg); }

@-webkit-keyframes snowflakes {
  0% {
    -webkit-transform: translate3d(0,0,0) rotate(0deg) scale(0.6);
  }
  100% {
    -webkit-transform: translate3d(15px, 1200px, 0px) rotate(360deg) scale(0.6);
  };
}

.snowflakes i.snow:nth-child(3n) {
  width: 16px; height: 4px;
  -webkit-animation-duration: 4s;
  -webkit-animation-iteration-count: 30;
  -webkit-transform-origin: right -45px;
}

.snowflakes i.snow:nth-child(3n+1) {
  width: 24px; height: 6px;
  -webkit-animation-duration: 6s;
  -webkit-animation-iteration-count: 45;
  -webkit-transform-origin: right -30px;
}

.snowflakes i.snow:nth-child(3n+2) {
  width: 32px; height: 8px;
  -webkit-animation-duration: 8s;
  -webkit-animation-iteration-count: 60;
  -webkit-transform-origin: right -15px;
}

.snowflakes i.snow:nth-child(7n) {
  opacity:.3;
  -webkit-animation-delay: 0s;
  -webkit-animation-timing-function:ease-in;
}
.snowflakes i.snow:nth-child(7n+1) {
  opacity:.4;
  -webkit-animation-delay: 1s;
  -webkit-animation-timing-function:ease-out;
}
.snowflakes i.snow:nth-child(7n+2) {
  opacity:.5;
  -webkit-animation-delay: 1.5s;
  -webkit-animation-timing-function:linear;
}
.snowflakes i.snow:nth-child(7n+3) {
  opacity:.6;
  -webkit-animation-delay: 2s;
  -webkit-animation-timing-function:ease-in;
}
.snowflakes i.snow:nth-child(7n+4) {
  opacity:.7;
  -webkit-animation-delay: 2.5s;
  -webkit-animation-timing-function:linear;
}
.snowflakes i.snow:nth-child(7n+5) {
  opacity:.8;
  -webkit-animation-delay: 3s;
  -webkit-animation-timing-function:ease-out;
}
.snowflakes i.snow:nth-child(7n+6) {
  opacity:.9;
  -webkit-animation-delay: 3.5s;
  -webkit-animation-timing-function:ease-in;
}
</style>
