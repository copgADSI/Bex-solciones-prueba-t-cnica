import { toast, ToastOptions } from "vue3-toastify";
import 'vue3-toastify/dist/index.css';

// Definición de tipos para las funciones toast
type ToastFunction = (text: string, options?: ToastOptions) => void;

// Tipos específicos para las funciones de toast
interface ToastFunctions {
    success: ToastFunction;
    error: ToastFunction;
    warning: ToastFunction;
    loading: ToastFunction;
}

export default function useNotificationToast() {
    // Configuración común de toast
    const commonConfig: ToastOptions = {
        position: toast.POSITION.BOTTOM_CENTER,
        theme: toast.THEME.DARK,
        closeOnClick: true,
        autoClose: 3000,
    };

    // Función auxiliar para evitar repetición de código
    const showToast = (type: keyof ToastFunctions, text: string) => {
        return toast[type](text, commonConfig);
    };

    // Funciones específicas de tipo toast
    const toastLoading = (text: string) => showToast('loading', text);
    const toastSuccess = (text: string) => showToast('success', text);
    const toastError = (text: string) => showToast('error', text);
    const toastWarning = (text: string) => showToast('warning', text);

    // Función para actualizar un toast existente
    const toastUpdate = (id: string | number, type: keyof ToastFunctions, text: string) => {
        toast.update(id, {
            render: text,
            type: toast.TYPE[type],
            ...commonConfig,
            isLoading: false
        });
    };

    // Objeto que contiene las funciones de toast
    const types: ToastFunctions = {
        success: toast.success,
        error: toast.error,
        warning: toast.warning,
        loading: toast.loading
    };

    return { toastLoading, toastSuccess, toastError, toastWarning, toastUpdate, types };
}
