import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import axios, { AxiosError } from 'axios'
import router from '@/router'
import { useToast } from 'vue-toastification'
import apiService from '@/services/api'
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

    const canRegister = computed(() => registerUser.value.name.trim().length >= 0 && registerUser.value.password.trim().length > 8 && registerUser.value.email.trim().length > 0)

    const canLogin = computed(() => loginUser.value.password.trim().length >= 8 && loginUser.value.email.trim().length > 0)

    const login = async () => {
        try {
            isLoggingIn.value = true
            await apiService.post('/login', loginUser.value)
            router.push("/")
            toast.success("Logged in succesfully")
            loginErrors.value = {
                'email': [],
                'password': []
            }
            loginUser.value = {
                'email': '',
                'password': ''
            }
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

    const register = async () => {
        try {
            isRegistering.value = true
            await apiService.post('/register', registerUser.value)
            router.push("/login")
            toast.success("Account created !")

            registerErrors.value = {
                'name': [],
                'email': [],
                'password': []
            }
            registerUser.value = {
                'name': '',
                'email': '',
                'password': ''
            }
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

    return { register, login, isRegistering, isLoggingIn, registerErrors, loginErrors, loginUser, registerUser, canRegister, canLogin }
})
