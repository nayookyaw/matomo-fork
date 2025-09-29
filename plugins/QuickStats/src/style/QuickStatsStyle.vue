<template><!-- style-only component --></template>
<script setup lang="ts">
// no-op
</script>

<style>
.qs-btn{
    position: fixed;
    bottom: 20px;   /* distance from bottom */
    right: 20px;    /* distance from right */
    padding:.5rem .75rem;
    border-radius:.5rem;
    border:0;
    background:#1f6feb;
    color:#fff;
    padding: 10px 16px;
    border-radius: 8px;
    cursor:pointer;
    box-shadow:0 2px 8px rgba(0,0,0,.15)
}
.qs-btn:hover{
    filter:brightness(1.05)
}
.qs-modal{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.35);
    display:grid;
    place-items:center;
    z-index:9999
}
.qs-card{
    width:min(720px,92vw);
    background:#fff;
    border-radius:12px;
    overflow:hidden
}
.qs-card-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:.75rem 1rem;
    border-bottom:1px solid #eee
}
.qs-close-icon{
    background:transparent;
    border:0;
    font-size:1.5rem;
    line-height:1;
    cursor:pointer
}
.qs-card-body{
    padding:1rem
}
.qs-grid{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:1rem
}
.qs-metric{
    padding:.75rem;
    border:1px solid #f0f0f0;
    border-radius:.5rem
}
.qs-metric-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 1em;
    height: 1em;
    margin-right: 8px;
    vertical-align: middle;
    color: #666;
}
.qs-label{
    font-size:.8rem;
    color:#666
}
.qs-value{
    font-size:1.6rem;
    font-weight:700
}
.qs-card-footer{
    padding:.75rem 1rem;
    border-top:1px solid #eee;
    display:flex;
    justify-content:flex-end
}
.qs-refresh-btn{
    background:#efefef;
    border:0;
    border-radius:.5rem;
    padding:.5rem .75rem;
    cursor:pointer
}
.qs-close-btn{
    background: #666;
    color: #f5f2f2;
    border: 0;
    border-radius: .5rem;
    padding: .5em .75rem;
    cursor: pointer;
    margin-right: 8px;
}
.qs-error{
    color:#b00020
}
.qs-charts {
  display: grid;
  grid-template-columns: 1fr;
  gap: 16px;
  margin-top: 16px;
}
@media (min-width: 900px) {
  .qs-charts {
    /* grid-template-columns: 1fr 1fr; */
  }
}
</style>