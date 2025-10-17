import axios from "axios";
import { useToast } from "vue-toastification";

const toast = useToast()
const apiService = axios.create({
    baseURL: import.meta.env.VITE_API_BASE_URL
})

// apiService.interceptors.request.use(config => {
//     config.headers.Authorization = `Bearer ${localStorage.getItem('token')}`
// })

apiService.interceptors.response.use(response => {
    return response
}, error => {
    if (error.response && error.response.status === 401 && !error.response.data.includes('credentials')) {
        toast.error('Unauthenticated !')
        router.push("/login")
    }
    throw error
})

export default apiService