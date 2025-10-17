import { ref, computed } from 'vue'
import { defineStore } from 'pinia'

export const authStore = defineStore('auth', () => {
  const loginUser = ref({})
  const registerUser = ref({})
  const isLoggingIn = ref(false)
  const isRegistering = ref(false)

//   const doubleCount = computed(() => count.value * 2)
//   function increment() {
//     count.value++
//   }

  return { count, doubleCount, increment }
})
