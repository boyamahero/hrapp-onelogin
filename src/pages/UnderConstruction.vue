<template>
  <div class="fixed-center text-center">
    <p class="text-faded">อยู่ระหว่างดำเนินการปรับปรุง</p>
    <q-btn
      color="secondary"
      style="width:200px;"
      @click="$router.push('/')"
    >Go back</q-btn>
  </div>
</template>

<script>
export default {
  name: 'UnderConstruction'
}
</script>
