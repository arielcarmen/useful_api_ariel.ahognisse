import axios from "axios";

const apiService = axios.create({
    baseURL: import.meta.env.VITE_API_BASE_URL
})

apiService.interceptors.request.use(config => {
    config.headers.Authorization = `Bearer ${localStorage.getItem('token')}`
})

apiService.interceptors.response.use((response) => {
    return response
}, error => {
    if (error.response && error.response.status === 401) {
        router.push("/")
    }

    throw error
})

export default apiService