<template>
    <div class="w-full h-full justify-center items-center">
        <div class=" bg-gray-100">
            <form action="" class="flex flex-col gap-1 bg-white rounded-lg shadow-lg p-2">
                <h1 class="text-2xl text-black">Register</h1>
                <label class=" text-gray-900 text-sm mt-2" for="name">Name:</label>
                <input class="p-2 text-black font-bold text-md rounded-lg outline-2 outline-blue-500" placeholder="John"
                    type="text" name="name" id="name" v-model="store.registerUser.name">
                <div v-if="store.registerErrors.name?.length">
                    <span v-for="error in store.registerErrors.name" :key="error" class=" text-xs text-red-500">
                        {{ error }}
                    </span>
                </div>
                <label for="email" class="text-gray-900 text-sm mt-2">Email:</label>
                <input class="p-2 text-black font-bold text-md rounded-lg outline-2 outline-blue-500"
                    placeholder="john@doe.com" type="email" name="email" id="email" v-model="store.registerUser.email">
                <div v-if="store.registerErrors.email?.length">
                    <span v-for="error in store.registerErrors.email" :key="error" class=" text-xs text-red-500">
                        {{ error }}
                    </span>
                </div>
                <label for="password" class="text-gray-900 text-sm mt-2">Password: <span class=" text-xs">(min 8
                        characters)</span></label>
                <input class="p-2 text-black font-bold text-md rounded-lg outline-2 outline-blue-500" type="password"
                    name="password" id="password" v-model="store.registerUser.password">
                <div v-if="store.registerErrors.password?.length">
                    <span v-for="error in store.registerErrors.password" :key="error" class=" text-xs text-red-500">
                        {{ error }}
                    </span>
                </div>
                <button :disabled="!store.canRegister"
                    class="px-2 py-1 text-white bg-blue-500 rounded-lg disabled:bg-gray-600"
                    @click.prevent="store.register"><p v-if="store.isRegistering">...</p><p v-else>Register</p></button>
                <p class="py-2 text-center text-black text-sm">Or login <router-link class="text-blue-500"
                            to="/login">here</router-link></p>
            </form>
        </div>
    </div>
</template>

<script setup>
import { authStore } from '@/stores/authStore';

const store = authStore()
</script>