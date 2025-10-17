import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import axios, { AxiosError } from 'axios'
import router from '@/router'
import { useToast } from 'vue-toastification'
const toast = useToast()

export const authStore = defineStore('auth', () => {
    const loginUser = ref({
        'email': '',
        'password': ''
    })
    const registerUser = ref({
        'name': '',
        'email': '',
        'password': ''
    })

    const loginErrors = ref({
        'email': [],
        'password': []
    })

    const registerErrors = ref({
        'name': [],
        'email': [],
        'password': []
    })

    const isLoggingIn = ref(false)

    const isRegistering = ref(false)

    const login = () => {
        try {
            isLoggingIn.value = true
            axios.post('/login', loginUser.value)
            router.push("/")
            toast.success("Logged in succesfully")
        } catch (error) {
            if (error instanceof AxiosError && error.response?.status === 422) {
                loginErrors.value.email = error.response?.data.errors.email,
                loginErrors.value.password = error.response?.data.errors.password
            } else {
                toast.error("Login failed !")
                console.error(error.message);
            }
        } finally {
            isLoggingIn.value = false
        }
    }

    const register = () => {
        try {
            isRegistering.value = true
            axios.post('/register', registerUser.value)
            router.push("/login")
            toast.success("Account created !")
        } catch (error) {
            if (error instanceof AxiosError && error.response?.status === 422) {
                registerErrors.value.name = error.response?.data.errors.name,
                registerErrors.value.email = error.response?.data.errors.email,
                registerErrors.value.password = error.response?.data.errors.password
            } else {
                toast.error("Register failed !")
                console.error(error.message);
            }
        } finally {
            isRegistering.value = false
        }
    }

    return { register, login, isRegistering, isLoggingIn, registerErrors, loginErrors }
})
