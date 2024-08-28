import axios from "axios"
import { Credentials } from "../../interfaces/auth"

async function login(credentias: Credentials) {
    try {
        const response = await axios.post('/auth/login', credentias)
        return response
    } catch (error) {
        throw error
    }
}

const authService = {
    login
}

export default authService
