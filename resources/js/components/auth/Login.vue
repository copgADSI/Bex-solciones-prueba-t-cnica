<template>
    <div class="d-flex justify-content-center my-4">
        <VueMarkdown :source="markdown"></VueMarkdown>
    </div>
    <div class="container d-flex justify-content-center align-items-center">

        <div class="card shadow  rounded p-4 w-50">
            <div class="my-4">
                <!-- <span class="text-danger fw-bold fs-3">{{  backendErrors.error }}</span> -->
                <span class="text-danger fw-bold"> {{ backendErrors.message }} </span>
            </div>
            <form @submit.prevent="handleLogin" class="needs-validation" novalidate>
                <div class="form-floating mb-3">
                    <input
                        type="email"
                        class="form-control bg-primary"
                        v-bind:class="{'is-invalid': backendErrors.error}"
                        id="floatingInput"
                        placeholder="name@example.com"
                        v-model="form.email" required
                    >
                    <label for="floatingInput">Email address</label>
                    <div class="invalid-feedback">
                        <small class="text-danger"> Please provide a valid email. </small>
                    </div>
                </div>
                <div class="form-floating">
                    <input
                        type="password"
                        class="form-control bg-primary"
                        v-bind:class="{'is-invalid': backendErrors.error}"
                        id="floatingPassword"
                        placeholder="Password"
                        v-model="form.password" required
                    >
                    <label for="floatingPassword">Password</label>
                    <div class="invalid-feedback">
                        <small class="text-danger"> Please provide a valid password. </small>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-3" :disabled="isLoading">
                    Login
                </button>
            </form>
        </div>

    </div>
</template>
<script lang="ts">
import { defineComponent, ref } from 'vue';
import { useStore } from 'vuex';
import authService from '../../services/auth';
import VueMarkdown from 'vue-markdown-render'

export default defineComponent({
    name: 'Login',
    components: {
        VueMarkdown,
    },
    setup() {
        const markdown = `
            # Prueba Técnica

            Para verificar la prueba técnica:

            1. **Inicia sesión** en la aplicación utilizando las siguientes credenciales:

            - **Correo electrónico**: "admin@mail.com"
            - **Contraseña**: "123456789"

            2. Una vez que hayas iniciado sesión, podrás acceder a las funcionalidades de la aplicación y realizar las pruebas necesarias.

        `
        const backendErrors = ref({
            error: null,
            message: null
        });
        const store = useStore();
        const isLoading = ref(false);
        const form = ref({
            email: 'admin@mail.com',
            password: 123456789
        })


        const handleLogin = async (event: Event) => {
            clearBackendErrors()
            event.preventDefault();
            if (isLoading.value) return;
            if (!(event.target as HTMLFormElement).checkValidity()) {
                (event.target as HTMLFormElement).classList.add('was-validated');
                return;
            }

            isLoading.value = true;

            authService.login(form.value).then((response) => {
                const STATUS_LIST = {
                    200: () => {
                        const { user, token } = response.data;
                        store.commit('auth/SET_AUTH_USER', user);
                        store.commit('auth/SET_TOKEN', token);
                        window.location.href = '/visits/on-map';
                    },
                }

                STATUS_LIST[response.status]();

            }).catch((error) => {
                backendErrors.value = error.response.data;
            }).finally(() => {
                isLoading.value = false;
            })
        }

        const clearBackendErrors = () => {
            backendErrors.value = {
                error: null,
                message: null
            }
        }

        return {
            isLoading,
            form,
            handleLogin,
            backendErrors,
            markdown,
        }
    }
})

</script>
