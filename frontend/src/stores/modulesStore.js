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

        } catch (error) {
            toast.error('Cannot load modules')
            console.error(error.message);
        }
    }

    const activateModule = async (moduleId) => {
        try {
            const response = await apiService.post(`/modules/${moduleId}/activate`)
            toast.success(response.data)
        } catch (error) {
            toast.error('Cannot activate modules')
            console.error(error.message);
        }
    }

    const deactivateModule = async (moduleId) => {
        try {
            const response = await apiService.post(`/modules/${moduleId}/deactivate`)
            toast.success(response.data)
        } catch (error) {
            toast.error('Cannot deactivate modules')
            console.error(error.message);
        }
    }

    const toggleActive = async (moduleId, active) => {

        if (active === true) {
            await deactivateModule(moduleId)
        } else {
            await activateModule(moduleId)
        }
        getAll()
    }

    return { modules, loading, updating, getAll, activateModule, deactivateModule, toggleActive }
}, {
    persist: true,
})
