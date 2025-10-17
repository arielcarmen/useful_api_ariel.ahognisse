import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import apiService from '@/services/api'
import { useToast } from 'vue-toastification'

export const useModulesStore = defineStore('modules', () => {
    const toast = useToast()

    const modules = ref([])
    const loading = ref(false)
    const updating = ref(false)

    const getAll = async () => {
        try {
            const response = await apiService.get("/user_modules")
            modules.value = response.data
            console.log(response.data);
            
        } catch (error) {
            toast.error('Cannot load modules')
            console.error(error.message);
        }
    }

    const activateModule = async (moduleId) => {
        try {
            const response = await apiService.get(`/modules/${moduleId}/activate`)
            toast.success(response.data)
        } catch (error) {
            toast.error('Cannot activate modules')
            console.error(error.message);
        }
    }

    const deactivateModule = async (moduleId) => {
        try {
            const response = await apiService.get(`/modules/${moduleId}/deactivate`)
            toast.success(response.data)
        } catch (error) {
            toast.error('Cannot deactivate modules')
            console.error(error.message);
        }
    }

    return { modules, loading, updating, getAll, activateModule, deactivateModule }
}, {
    persist: true,
})
